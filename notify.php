<?php
session_start();
// Redirect the user to login page if not logged in.
if (!isset($_SESSION['loggedIn'])) {
    header('Location: login.php');
    exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');
$lowStockThreshold = DEFAULT_LOW_STOCK_THRESHOLD;
?>

<body>
    <?php require 'inc/navigation.php'; ?>
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
                        <div class="card-header"><b>Notifications - Low Stock Items</b></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
                                $stmt = $conn->query("SELECT * FROM item WHERE stock < $lowStockThreshold ORDER BY stock ASC");
                                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <table class="table table-bordered" id="notifyTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Product ID</th>
                                            <th>Item Number</th>
                                            <th>Item Name</th>
                                            <th>Stock</th>
                                            <th>Unit Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $row) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['productID']); ?></td>
                                                <td><?php echo htmlspecialchars($row['itemNumber']); ?></td>
                                                <td><?php echo htmlspecialchars($row['itemName']); ?></td>
                                                <td><?php echo htmlspecialchars($row['stock']); ?></td>
                                                <td><?php echo htmlspecialchars($row['unitPrice']); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <a href="index.php" class="btn btn-primary mt-2">Back to Dashboard</a>
                        </div>
                    </div>

                    <!-- include the existing tabs so the sidebar works like index.php -->

                </div>
            </div>

            <?php require 'inc/footer.php'; ?>
</body>

</html>