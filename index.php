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
?>

<body>
	<?php
	require 'inc/navigation.php';
	require 'inc/sidebar.php';
	?>

	<div class="col-lg-10">
		<div class="tab-content" id="v-pills-tabContent">
			<!-- Dashboard Tab -->
			<?php include 'tabs/dashboard_tab.php'; ?>
			<!-- Item Tab -->
			<?php include 'tabs/item_tab.php'; ?>
			<!-- Purchase Tab -->
			<?php include 'tabs/purchase_tab.php'; ?>
			<!-- Vendor Tab -->
			<?php include 'tabs/vendor_tab.php'; ?>
			<!-- Sales Tab -->
			<?php include 'tabs/sales_tab.php'; ?>
			<!-- Customer Tab -->
			<?php include 'tabs/customer_tab.php'; ?>
			<!-- search Tab -->
			<?php include 'tabs/search_tab.php'; ?>
			<!-- Reports Tab -->
			<?php include 'tabs/reports_tab.php'; ?>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>
</body>

</html>