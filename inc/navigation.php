	 <?php
		$lowStockThreshold = DEFAULT_LOW_STOCK_THRESHOLD;
		try {
			$countStmt = $conn->query("SELECT COUNT(*) FROM item WHERE stock < $lowStockThreshold");
			$notifyCount = $countStmt->fetchColumn();
		} catch (Exception $e) {
			$notifyCount = 0;
		}
		?>
	 <!-- Navigation -->
	 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
	 	<div class="container">
	 		<a class="navbar-brand" href="<?php echo ROOT_URL; ?>"><?php echo DEFAULT_SITE_NAME; ?></a>
	 		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
	 			<span class="navbar-toggler-icon"></span>
	 		</button>
	 		<div class="collapse navbar-collapse" id="navbarResponsive">
	 			<ul class="navbar-nav ml-auto">
	 				<!-- <li class="nav-item">
				<form class="form-inline" action="/action_page.php">
					<input class="form-control col-md-8 mr-sm-2" type="text" placeholder="Search">
					<button class="btn btn-success" type="submit">Search</button>
				</form>
			</li> -->
	 				<li class="nav-item">
	 					<a href="<?php echo ROOT_URL; ?>" class="nav-link">Home</a>
	 				</li>
	 				<li class="nav-item">
	 					<a class="nav-link" href="notify.php">Notify<?php if (!empty($notifyCount) && $notifyCount > 0) {
																			echo '<span class="badge badge-danger">' . htmlspecialchars($notifyCount) . '</span>';
																		} ?></a>
	 				</li>
	 				<li class="nav-item">
	 					<a class="nav-link" href="settings.php">Settings</a>
	 				</li>
	 				<li class="nav-item">
	 					<a class="nav-link" href="model/login/logout.php">Log Out</a>
	 				</li>
	 			</ul>
	 		</div>
	 	</div>
	 </nav>
	 <!-- Page Content -->
	 <div class="container-fluid">
	 	<div class="row">
	 		<div class="col-lg-2">
	 			<!-- <h3 class="my-4">Hi!</h3> -->
	 			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
	 				<a class="nav-link" id="v-pills-dashboard-tab" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="false">Dashboard</a>
	 				<a class="nav-link active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">Item</a>
	 				<a class="nav-link" id="v-pills-purchase-tab" data-toggle="pill" href="#v-pills-purchase" role="tab" aria-controls="v-pills-purchase" aria-selected="false">Purchase</a>
	 				<a class="nav-link" id="v-pills-vendor-tab" data-toggle="pill" href="#v-pills-vendor" role="tab" aria-controls="v-pills-vendor" aria-selected="false">Vendor</a>
	 				<a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false">Sale</a>
	 				<a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Customer</a>
	 				<a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Search</a>
	 				<a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</a>
	 			</div>
	 		</div>