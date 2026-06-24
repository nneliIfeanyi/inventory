<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
    header('Location: login.php');
    exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');

$saveSuccess = '';
$saveError = '';
$siteName = DEFAULT_SITE_NAME;
$lowStockThreshold = DEFAULT_LOW_STOCK_THRESHOLD;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteName = trim($_POST['siteName'] ?? '');
    $lowStockThreshold = trim($_POST['lowStockThreshold'] ?? '');

    if ($siteName === '') {
        $saveError = 'Site Name is required.';
    } elseif ($lowStockThreshold === '' || !ctype_digit((string) $lowStockThreshold)) {
        $saveError = 'Low Stock Threshold must be a non-negative integer.';
    } else {
        $constantsPath = __DIR__ . '/inc/config/constants.php';
        $constantsContent = file_get_contents($constantsPath);

        if ($constantsContent === false) {
            $saveError = 'Unable to read constants.php. Check file permissions.';
        } else {
            $constantsContent = preg_replace(
                "/define\\('DEFAULT_LOW_STOCK_THRESHOLD',\\s*\\d+\\);/",
                "define('DEFAULT_LOW_STOCK_THRESHOLD', " . intval($lowStockThreshold) . ");",
                $constantsContent,
                -1,
                $thresholdReplacements
            );

            $siteNameEscaped = str_replace("'", "\\'", $siteName);
            $constantsContent = preg_replace(
                "/define\\('DEFAULT_SITE_NAME',\\s*'[^']*'\\);/",
                "define('DEFAULT_SITE_NAME', '" . $siteNameEscaped . "');",
                $constantsContent,
                -1,
                $siteNameReplacements
            );

            if ($thresholdReplacements === 0 || $siteNameReplacements === 0) {
                $saveError = 'Unable to update constants.php. The expected define statements were not found.';
            } elseif (file_put_contents($constantsPath, $constantsContent) === false) {
                $saveError = 'Unable to write to constants.php. Check file permissions.';
            } else {
                $saveSuccess = 'Settings saved successfully.';
                // redirect to index.php after 4 seconds to show the success message
                header("refresh:4;url=index.php");
            }
        }
    }
}

require_once('inc/header.html');
?>

<body>
    <?php
    require 'inc/navigation.php';
    ?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <!-- <h3 class="my-4">Hi!</h3> -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" href="index.php">Dashboard</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header"><b>Site Settings</b></div>
                        <div class="card-body">
                            <?php if ($saveError): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($saveError); ?></div>
                            <?php elseif ($saveSuccess): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($saveSuccess); ?></div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="form-group">
                                    <!-- Site Name Setting -->
                                    <label for="siteName">Site Name</label>
                                    <input type="text" class="form-control" id="siteName" name="siteName" aria-describedby="siteNameHelp" value="<?php echo htmlspecialchars($siteName); ?>" placeholder="Enter setting value">
                                    <small id="siteNameHelp" class="form-text text-muted">Change the name of your site.</small>
                                </div>
                                <div class="form-group">
                                    <!-- Low Stock Threshold Setting -->
                                    <label for="lowStockThreshold">Low Stock Threshold</label>
                                    <input type="number" class="form-control" id="lowStockThreshold" name="lowStockThreshold" value="<?php echo htmlspecialchars($lowStockThreshold); ?>" aria-describedby="lowStockThresholdHelp" placeholder="Enter setting value">
                                    <small id="lowStockThresholdHelp" class="form-text text-muted">Set the threshold for low stock notifications.</small>
                                </div>
                                <button type="submit" class="btn btn-secondary">Save Settings</button>
                                <!-- Back to Dashboard Button -->
                                <a href="index.php" class="btn btn-primary ml-2">Back to Dashboard</a>
                            </form>
                            <!-- Crucial Info -->
                            <div class="alert alert-info mt-4" role="alert">
                                <h4 class="alert-heading">Crucial Info</h4>
                                <p>
                                    <small class="form-text text-muted">
                                        For Password Reset, kindly logout and use the "Reset Password" link.
                                        <br><a href="login.php?action=resetPassword">Reset Password</a>
                                    </small>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            require 'inc/footer.php';
            ?>
</body>

</html>