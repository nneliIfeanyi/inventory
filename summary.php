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

// Get date range from request parameters
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : date('Y-m-01'); // Default to 1st of current month
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : date('Y-m-d'); // Default to today

// Calculate Sales Total
if (!empty($startDate) && !empty($endDate)) {
	$salesTotalQuery = $conn->prepare("SELECT SUM(quantity * unitPrice * (1 - discount/100)) as salesTotal FROM sale WHERE saleDate BETWEEN :startDate AND :endDate");
	$salesTotalQuery->execute(['startDate' => $startDate, 'endDate' => $endDate]);
} else {
	$salesTotalQuery = $conn->query("SELECT SUM(quantity * unitPrice * (1 - discount/100)) as salesTotal FROM sale");
}
$salesTotalRow = $salesTotalQuery->fetch(PDO::FETCH_ASSOC);
$salesTotal = $salesTotalRow['salesTotal'] ?? 0;

// Calculate Closing Stock Total (current stock value - not filtered by date)
$closingStockQuery = $conn->query("SELECT SUM(stock * unitPrice) as closingStock FROM item");
$closingStockRow = $closingStockQuery->fetch(PDO::FETCH_ASSOC);
$closingStock = $closingStockRow['closingStock'] ?? 0;

// Calculate Purchases Total
if (!empty($startDate) && !empty($endDate)) {
	$purchasesTotalQuery = $conn->prepare("SELECT SUM(quantity * unitPrice) as purchasesTotal FROM purchase WHERE purchaseDate BETWEEN :startDate AND :endDate");
	$purchasesTotalQuery->execute(['startDate' => $startDate, 'endDate' => $endDate]);
} else {
	$purchasesTotalQuery = $conn->query("SELECT SUM(quantity * unitPrice) as purchasesTotal FROM purchase");
}
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
			<div class="container mt-5">
				<!-- Date Range Filter -->
				<div class="row mb-4">
					<div class="col-12">
						<div class="card border-secondary">
							<div class="card-header bg-secondary text-white">
								<h6 class="mb-0">Filter by Date Range</h6>
							</div>
							<div class="card-body">
								<form method="GET" class="row g-3 align-items-end">
									<div class="col-md-3">
										<label for="startDate" class="form-label">Start Date</label>
										<input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
									</div>
									<div class="col-md-3">
										<label for="endDate" class="form-label">End Date</label>
										<input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
									</div>
									<div class="col-md-6">
										<button type="submit" class="btn btn-primary">Filter</button>
										<a href="summary.php" class="btn btn-secondary">Reset</a>
										<button type="button" class="btn btn-outline-info" onclick="setDateRange('today')">Today</button>
										<button type="button" class="btn btn-outline-info" onclick="setDateRange('week')">This Week</button>
										<button type="button" class="btn btn-outline-info" onclick="setDateRange('month')">This Month</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<!--
i like this page to able to pull out its details based on selected start date and end date so as totrack daily weekly and monthly profit

-->

					<!-- Sales Total Card -->
					<div class="col-md-6 col-lg-3 mb-4">
						<div class="card h-100 border-primary">
							<div class="card-body">
								<h5 class="card-title">Sales Total</h5>
								<p class="card-text display-6 text-primary">Rs. <?php echo number_format($salesTotal, 2); ?></p>
							</div>
						</div>
					</div>

					<!-- Closing Stock Total Card -->
					<div class="col-md-6 col-lg-3 mb-4">
						<div class="card h-100 border-success">
							<div class="card-body">
								<h5 class="card-title">Closing Stock Total</h5>
								<p class="card-text display-6 text-success">Rs. <?php echo number_format($closingStock, 2); ?></p>
							</div>
						</div>
					</div>

					<!-- Purchases Total Card -->
					<div class="col-md-6 col-lg-3 mb-4">
						<div class="card h-100 border-warning">
							<div class="card-body">
								<h5 class="card-title">Purchases Total</h5>
								<p class="card-text display-6 text-warning">Rs. <?php echo number_format($purchasesTotal, 2); ?></p>
							</div>
						</div>
					</div>

					<!-- Profit Card -->
					<div class="col-md-6 col-lg-3 mb-4">
						<div class="card h-100 border-info">
							<div class="card-body">
								<h5 class="card-title">Profit</h5>
								<p class="card-text display-6 text-info">Rs. <?php echo number_format($profit, 2); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>
	<script>
		function setDateRange(range) {
			const today = new Date();
			let startDate, endDate;

			endDate = today.toISOString().split('T')[0];

			switch (range) {
				case 'today':
					startDate = endDate;
					break;
				case 'week':
					const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
					startDate = firstDay.toISOString().split('T')[0];
					break;
				case 'month':
					startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
					break;
			}

			document.getElementById('startDate').value = startDate;
			document.getElementById('endDate').value = endDate;
			document.querySelector('form').submit();
		}
	</script>
</body>

</html>