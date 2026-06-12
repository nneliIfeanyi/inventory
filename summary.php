<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
	header('Location: login.php');
	exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');

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

// Calculate Profit
$profit = $salesTotal + $closingStock - $purchasesTotal;
?>

<body>
	<?php
	require 'inc/navigation.php';
	?>
	<div class="col-lg-10">
		<div class="tab-content" id="v-pills-tabContent">
			<div class="card card-outline-secondary my-4">
				<div class="card-header"><b>Summary</b></div>
				<div class="card-body">
					<div class="row">

						<!-- Sales Total Card -->
						<div class="col-md-6 col-lg-3 mb-4">
							<div class="card h-100 shadow-sm">
								<div class="card-body">
									<h5 class="card-title">Sales Total</h5>
									<p class="card-text display-6 text-primary">Rs. <?php echo number_format($salesTotal, 2); ?></p>
								</div>
							</div>
						</div>

						<!-- Closing Stock Total Card -->
						<div class="col-md-6 col-lg-3 mb-4">
							<div class="card h-100 shadow-sm">
								<div class="card-body">
									<h5 class="card-title">Closing Stock Total</h5>
									<p class="card-text display-6 text-success">Rs. <?php echo number_format($closingStock, 2); ?></p>
								</div>
							</div>
						</div>

						<!-- Purchases Total Card -->
						<div class="col-md-6 col-lg-3 mb-4">
							<div class="card h-100 shadow-sm">
								<div class="card-body">
									<h5 class="card-title">Purchases Total</h5>
									<p class="card-text display-6 text-warning">Rs. <?php echo number_format($purchasesTotal, 2); ?></p>
								</div>
							</div>
						</div>

						<!-- Profit Card -->
						<div class="col-md-6 col-lg-3 mb-4">
							<div class="card h-100 shadow-sm">
								<div class="card-body">
									<h5 class="card-title">Profit</h5>
									<p class="card-text display-6 text-info">Rs. <?php echo number_format($profit, 2); ?></p>
								</div>
							</div>
						</div>
					</div>
					<!-- Back to Dashboard Button -->
					<a href="index.php" class="btn btn-primary mt-2">Back to Dashboard</a>
				</div>
			</div>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>
	<!-- No date filter UI needed for this summary page -->
</body>

</html>