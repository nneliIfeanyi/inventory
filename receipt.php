<?php
require_once('inc/config/constants.php');
require_once('inc/config/db.php');

$customerID = '';
$saleDate = date('Y-m-d');
$searchError = '';
$saleRows = [];
$numRows = 0;
$searchPerformed = false;
$totalAmount = 0;
$amountPaid = 0;
$balance = 0;
$showReceipt = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'search') {
        $customerID = trim($_POST['customerID'] ?? '');
        $saleDate = trim($_POST['saleDate'] ?? '');

        if ($customerID === '' || $saleDate === '') {
            $searchError = 'Please enter both Customer ID and Sale Date.';
        } else {
            $customerID = htmlentities($customerID);
            $saleDate = htmlentities($saleDate);

            try {
                $salesSql = 'SELECT * FROM sale WHERE customerID = :customerID AND saleDate = :saleDate ORDER BY saleID ASC';
                $statement = $conn->prepare($salesSql);
                $statement->execute([
                    ':customerID' => $customerID,
                    ':saleDate' => $saleDate
                ]);
                $saleRows = $statement->fetchAll(PDO::FETCH_ASSOC);
                $numRows = count($saleRows);
                $searchPerformed = true;
            } catch (PDOException $e) {
                $searchError = 'Unable to fetch sales records. Please try again.';
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'generateReceipt') {
        $customerID = htmlentities(trim($_POST['customerID'] ?? ''));
        $saleDate = htmlentities(trim($_POST['saleDate'] ?? ''));
        $amountPaid = floatval($_POST['amountPaid'] ?? 0);

        try {
            $salesSql = 'SELECT * FROM sale WHERE customerID = :customerID AND saleDate = :saleDate ORDER BY saleID ASC';
            $statement = $conn->prepare($salesSql);
            $statement->execute([
                ':customerID' => $customerID,
                ':saleDate' => $saleDate
            ]);
            $saleRows = $statement->fetchAll(PDO::FETCH_ASSOC);
            //$numRows = count($saleRows);
            foreach ($saleRows as $row) {
                $totalAmount += calculateTotal($row['quantity'], $row['unitPrice'], $row['discount']);
            }
            $balance = $amountPaid - $totalAmount;
            // Insert the receipt details into the credit_book table if purchaseTotal greater than amountPaid
            if ($totalAmount > $amountPaid) {
                $insertSql = 'INSERT INTO credit_book (customerID, purchaseDate, purchaseTotal, paid) VALUES (:customerID, :purchaseDate, :purchaseTotal, :paid)';
                $insertStatement = $conn->prepare($insertSql);
                $insertStatement->execute([
                    ':customerID' => $customerID,
                    ':purchaseDate' => $saleDate,
                    ':purchaseTotal' => $totalAmount,
                    ':paid' => $amountPaid
                ]);
            }
            $showReceipt = true;
        } catch (PDOException $e) {
            $searchError = 'Unable to generate receipt. Please try again.';
        }
    }
}

function formatMoney($value)
{
    return number_format((float)$value, 2);
}

function calculateTotal($quantity, $unitPrice, $discount)
{
    $subtotal = $quantity * $unitPrice;
    $discountAmount = $subtotal * ($discount / 100);
    return $subtotal - $discountAmount;
}
// Start the session at the beginning of the script
session_start();
// Redirect the user to login page if not logged in.
if (!isset($_SESSION['loggedIn'])) {
    header('Location: login.php');
    exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');
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
                        <div class="card-header"><strong>Generate Receipt</strong></div>
                        <div class="card-body">
                            <form method="post">
                                <input type="hidden" name="action" value="search">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="customerID">Customer ID</label>
                                        <input type="text" class="form-control" id="customerID" name="customerID" value="<?php echo htmlspecialchars($customerID); ?>" autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="saleDate">Sale Date</label>
                                        <input type="text" class="form-control datepicker" id="saleDate" name="saleDate" value="<?php echo htmlspecialchars($saleDate); ?>" readonly>
                                    </div>
                                    <div class="form-group col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-block">Generate Receipt</button>
                                    </div>
                                </div>
                            </form>

                            <?php if ($searchError): ?>
                                <div class="alert alert-danger mt-3"><?php echo $searchError; ?></div>
                            <?php endif; ?>

                            <?php if ($searchPerformed): ?>
                                <!-- <div class="alert alert-info mt-3">
                        Found <?php echo $numRows; ?> sale record<?php echo $numRows === 1 ? '' : 's'; ?> for Customer ID <?php echo htmlspecialchars($customerID); ?> on <?php echo htmlspecialchars($saleDate); ?>.
                    </div> -->

                                <?php if ($numRows > 0): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Sale ID</th>
                                                    <th>Item Number</th>
                                                    <th>Item Name</th>
                                                    <th>Category</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Discount %</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rowIndex = 0;
                                                $searchTotal = 0;
                                                while ($rowIndex < $numRows):
                                                    $row = $saleRows[$rowIndex];
                                                    $rowTotal = calculateTotal($row['quantity'], $row['unitPrice'], $row['discount']);
                                                    $searchTotal += $rowTotal;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $rowIndex + 1; ?></td>
                                                        <td><?php echo htmlspecialchars($row['saleID']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['itemNumber']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['itemName']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['category']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                                        <td><?php echo formatMoney($row['unitPrice']); ?></td>
                                                        <td><?php echo htmlspecialchars($row['discount']); ?></td>
                                                        <td><?php echo formatMoney($rowTotal); ?></td>
                                                    </tr>
                                                <?php
                                                    $rowIndex++;
                                                endwhile;
                                                ?>
                                                <tr style="font-weight: bold; background-color: #f0f0f0;">
                                                    <td colspan="8" style="text-align: right;">Purchase Total:</td>
                                                    <td><?php echo formatMoney($searchTotal); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Amount Paid Form -->
                                    <form method="post" class="mt-4">
                                        <input type="hidden" name="action" value="generateReceipt">
                                        <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customerID); ?>">
                                        <input type="hidden" name="saleDate" value="<?php echo htmlspecialchars($saleDate); ?>">

                                        <div class="form-row">
                                            <div class="form-group col-md-3">
                                                <label for="amountPaid">Amount Paid</label>
                                                <input type="number" class="form-control" id="amountPaid" name="amountPaid" step="0.01" placeholder="0.00" required>
                                            </div>
                                            <div class="form-group col-md-3 d-flex align-items-end">
                                                <button type="submit" class="btn btn-success btn-block">Generate Receipt</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-warning mt-3">No sales records were found for the selected customer and date.</div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- 80mm Thermal Receipt Display Modal/Section -->
                <?php if ($showReceipt): ?>
                    <div class="container mt-4">
                        <div class="card card-outline-secondary">
                            <div class="card-header"><strong>Receipt Preview (80mm)</strong></div>
                            <div class="card-body">
                                <div id="receipt" style="width: 80mm; margin: 0 auto; font-family: 'Courier New', monospace; font-size: 10pt; background: white; padding: 10px; border: 1px solid #ddd;">
                                    <div style="text-align: center; margin-bottom: 10px;">
                                        <strong><?php echo DEFAULT_SITE_NAME; ?></strong>
                                        <br>Receipt
                                        <br>------------------
                                    </div>

                                    <div style="margin-bottom: 10px;">
                                        <!-- <div>Customer ID: <?php echo htmlspecialchars($customerID); ?></div> -->
                                        <div>Date: <?php echo htmlspecialchars($saleDate); ?></div>
                                        <div>Time: <?php echo date('H:i:s'); ?></div>
                                        <div>------------------</div>
                                    </div>

                                    <div style="margin-bottom: 10px;">
                                        <div style="font-weight: bold; margin-bottom: 5px;">Items:</div>
                                        <?php foreach ($saleRows as $idx => $row):
                                            $itemTotal = calculateTotal($row['quantity'], $row['unitPrice'], $row['discount']);
                                        ?>
                                            <div style="margin-bottom: 5px; font-size: 9pt;">
                                                <div><?php echo substr(htmlspecialchars($row['itemName']), 0, 30); ?></div>
                                                <div><?php echo $row['quantity']; ?> x <?php echo formatMoney($row['unitPrice']); ?> = <?php echo formatMoney($itemTotal); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                        <div>------------------</div>
                                    </div>

                                    <div style="text-align: right; margin-bottom: 10px; font-size: 11pt;">
                                        <div style="margin-bottom: 5px;">
                                            Subtotal: <?php echo formatMoney($totalAmount); ?>
                                        </div>
                                        <div style="margin-bottom: 5px;">
                                            Amount Paid: <?php echo formatMoney($amountPaid); ?>
                                        </div>
                                        <div style="margin-bottom: 5px; font-weight: bold; font-size: 12pt;">
                                            Balance: <?php echo formatMoney($balance); ?>
                                        </div>
                                    </div>

                                    <div style="text-align: center; margin-top: 10px; border-top: 1px dashed #000;">
                                        <div style="margin-top: 10px; font-size: 9pt;">Thank you for your purchase!</div>
                                        <div style="font-size: 9pt;">Please call again.</div>
                                    </div>
                                </div>

                                <div style="text-align: center; margin-top: 20px;">
                                    <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                                    <a href="receipt.php" class="btn btn-secondary">Back to Search</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        @media print {
                            body * {
                                visibility: hidden;
                            }

                            #receipt,
                            #receipt * {
                                visibility: visible;
                            }

                            #receipt {
                                position: absolute;
                                left: 0;
                                top: 0;
                                width: 80mm;
                            }

                            button {
                                display: none;
                            }
                        }
                    </style>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php require 'inc/footer.php'; ?>
</body>

</html>