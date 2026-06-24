<?php
require_once('inc/config/constants.php');
require_once('inc/config/db.php');

$saleID = isset($_GET['saleID']) ? intval($_GET['saleID']) : 0;
$sale = null;

if ($saleID > 0) {
    $saleSql = 'SELECT * FROM sale WHERE saleID = :saleID';
    $saleStatement = $conn->prepare($saleSql);
    $saleStatement->execute(['saleID' => $saleID]);
    if ($saleStatement->rowCount() > 0) {
        $sale = $saleStatement->fetch(PDO::FETCH_ASSOC);
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo DEFAULT_SITE_NAME; ?> - Receipt</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/cerulean.theme.min.css">
    <style>
        body {
            margin: 20px;
            background: #f8f9fa;
        }

        .receipt-container {
            max-width: 720px;
            margin: auto;
            background: #fff;
            padding: 24px;
            border: 1px solid #e3e6ea;
            border-radius: 6px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.04);
        }

        .receipt-header {
            margin-bottom: 20px;
        }

        .receipt-title {
            margin-bottom: 0;
            font-size: 1.8rem;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .receipt-meta {
            margin-top: 8px;
            color: #6c757d;
        }

        .receipt-table th,
        .receipt-table td {
            padding: 10px;
            border-top: 1px solid #dee2e6;
        }

        .receipt-total {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .no-print {
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: #fff;
                margin: 0;
            }

            .receipt-container {
                box-shadow: none;
                border: none;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="no-print text-right">
            <button id="printButton" class="btn btn-primary">Print Receipt</button>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <?php if ($sale): ?>
            <div class="receipt-header text-center">
                <h1 class="receipt-title"><?php echo htmlspecialchars(DEFAULT_SITE_NAME); ?></h1>
                <p class="receipt-meta">Customer Copy Receipt</p>
            </div>

            <div class="row mb-3">
                <div class="col-sm-6">
                    <strong>Sale ID:</strong> <?php echo htmlspecialchars($sale['saleID']); ?><br>
                    <strong>Sale Date:</strong> <?php echo htmlspecialchars($sale['saleDate']); ?><br>
                </div>
                <div class="col-sm-6 text-sm-right">
                    <strong>Customer:</strong> <?php echo htmlspecialchars($sale['customerName']); ?><br>
                    <strong>Customer ID:</strong> <?php echo htmlspecialchars($sale['customerID']); ?><br>
                </div>
            </div>

            <table class="table table-bordered receipt-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Discount</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['itemName'] ?: $sale['itemNumber']); ?></td>
                        <td class="text-right"><?php echo htmlspecialchars($sale['quantity']); ?></td>
                        <td class="text-right"><?php echo '₦' . formatMoney($sale['unitPrice']); ?></td>
                        <td class="text-right"><?php echo formatMoney($sale['discount']); ?>%</td>
                        <td class="text-right"><?php echo '₦' . formatMoney(calculateTotal($sale['quantity'], $sale['unitPrice'], $sale['discount'])); ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="row mt-3">
                <div class="col-sm-8">
                    <p><strong>Thank you for your purchase!</strong></p>
                </div>
                <div class="col-sm-4 text-right">
                    <p class="receipt-total">Grand Total: <?php echo '₦' . formatMoney(calculateTotal($sale['quantity'], $sale['unitPrice'], $sale['discount'])); ?></p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No sale record found for the requested receipt.</div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.print();
        });
    </script>
</body>

</html>