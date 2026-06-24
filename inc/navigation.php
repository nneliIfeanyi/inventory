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