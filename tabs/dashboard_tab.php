<div class="tab-pane fade" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
    <div class="card card-outline-secondary my-4">
        <div class="card-header"><b>Dashboard</b></div>
        <div class="card-body">
            <div class="row">
                <?php
                $resetMessage = '';
                $resetError = '';
                $today = new DateTime();
                $isLastDayOfMonth = $today->format('Y-m-d') === $today->format('Y-m-t');
                $vendorID = 1;
                $vendorName = 'previousMonthRollover';
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_month_end'])) {
                    try {
                        $conn->exec("CREATE TABLE IF NOT EXISTS sales_archive LIKE sale");
                        $conn->exec("CREATE TABLE IF NOT EXISTS purchase_archive LIKE purchase");

                        $conn->beginTransaction();
                        $conn->exec("INSERT INTO sales_archive SELECT * FROM sale");
                        $conn->exec("INSERT INTO purchase_archive SELECT * FROM purchase");
                        $conn->exec("DELETE FROM sale");
                        $conn->exec("DELETE FROM purchase");
                        $sql = "INSERT INTO purchase (itemNumber, purchaseDate, itemName, unitPrice, quantity, vendorName, vendorID) SELECT itemNumber, NOW(), itemName, unitPrice, stock, :vendorName, :vendorID FROM item";
                        $smt = $conn->prepare($sql);
                        $smt->execute(['vendorName' => $vendorName, 'vendorID' => $vendorID]);
                        $conn->commit();
                        $resetMessage = 'Month-end reset completed. Sales and purchases have been archived.';
                    } catch (PDOException $e) {
                        if ($conn->inTransaction()) {
                            try {
                                $conn->rollBack();
                            } catch (PDOException $rollbackException) {
                                // ignore rollback errors when transaction is no longer active
                            }
                        }
                        $resetError = 'Month-end reset failed: ' . htmlspecialchars($e->getMessage());
                    }
                }

                // Calculate Sales Total
                $salesTotalQuery = $conn->query("SELECT SUM(quantity * unitPrice * (1 - discount/100)) as salesTotal FROM sale");
                $salesTotalRow = $salesTotalQuery->fetch(PDO::FETCH_ASSOC);
                $salesTotal = $salesTotalRow['salesTotal'] ?? 0;

                // Calculate Closing Stock Total (current stock value - not filtered by date)
                $closingStockQuery = $conn->query("SELECT SUM(stock * unitPrice) as closingStock FROM item");
                $closingStockRow = $closingStockQuery->fetch(PDO::FETCH_ASSOC);
                $closingStock = $closingStockRow['closingStock'] ?? 0;

                $purchasesTotalQuery = $conn->query("SELECT SUM(quantity * unitPrice) as purchasesTotal FROM purchase");
                $purchasesTotalRow = $purchasesTotalQuery->fetch(PDO::FETCH_ASSOC);
                $purchasesTotal = $purchasesTotalRow['purchasesTotal'] ?? 0;

                // Calculate Profit with current stock value included
                $profit = $salesTotal + $closingStock - $purchasesTotal;
                ?>

                <?php if ($resetMessage): ?>
                    <div class="col-12 mb-3">
                        <div class="alert alert-success mb-0"><?php echo $resetMessage; ?></div>
                    </div>
                <?php endif; ?>
                <?php if ($resetError): ?>
                    <div class="col-12 mb-3">
                        <div class="alert alert-danger mb-0"><?php echo $resetError; ?></div>
                    </div>
                <?php endif; ?>

                <!-- Closing Stock Total Card -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Current Stock Total</h5>
                            <p class="card-text display-6 text-success">&#8358;<?php echo number_format($closingStock, 2); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Sales Total Card -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Sales Total</h5>
                            <p class="card-text display-6 text-primary">&#8358;<?php echo number_format($salesTotal, 2); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Purchases Total Card -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Purchases Total</h5>
                            <p class="card-text display-6 text-warning">&#8358;<?php echo number_format($purchasesTotal, 2); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Profit Card -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Profit</h5>
                            <p class="card-text display-6 text-info">&#8358;<?php echo number_format($profit, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-2 mb-md-0">End-of-month reset</h5>
                                <p class="card-text mb-0">Click to archive current sales and purchase data into archive tables. Current stock remains unchanged and becomes next month opening stock.</p>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#resetMonthModal">Reset Month Data</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="resetMonthModal" tabindex="-1" role="dialog" aria-labelledby="resetMonthModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resetMonthModalLabel">Confirm Month-End Reset</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Archive current sales and purchase records and clear the live tables? This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <form method="post" class="mb-0">
                                <input type="hidden" name="reset_month_end" value="1">
                                <button type="submit" class="btn btn-danger">Confirm Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>