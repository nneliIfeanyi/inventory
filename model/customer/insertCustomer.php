<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

if (isset($_POST['customerDetailsCustomerFullName'])) {

	$fullName = htmlentities($_POST['customerDetailsCustomerFullName']);
	//$email = htmlentities($_POST['customerDetailsCustomerEmail']);
	$mobile = htmlentities($_POST['customerDetailsCustomerMobile']);
	//$phone2 = htmlentities($_POST['customerDetailsCustomerPhone2']);
	$address = htmlentities($_POST['customerDetailsCustomerAddress']);
	//$address2 = htmlentities($_POST['customerDetailsCustomerAddress2']);
	//$city = htmlentities($_POST['customerDetailsCustomerCity']);
	$district = htmlentities($_POST['customerDetailsCustomerDistrict']);
	$status = htmlentities($_POST['customerDetailsStatus']);

	if (isset($fullName) && isset($mobile)) {
		// Validate mobile number
		if (filter_var($mobile, FILTER_VALIDATE_INT) === 0 || filter_var($mobile, FILTER_VALIDATE_INT)) {
			// Valid mobile number
		} else {
			// Mobile is wrong
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid phone number</div>';
			exit();
		}

		// Check if Full name is empty or not
		if ($fullName == '') {
			// Full Name is empty
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter Full Name.</div>';
			exit();
		}

		// Start the insert process
		$sql = 'INSERT INTO customer(fullName, mobile, address, district, status) VALUES(:fullName, :mobile, :address, :district, :status)';
		$stmt = $conn->prepare($sql);
		$stmt->execute(['fullName' => $fullName, 'mobile' => $mobile, 'address' => $address, 'district' => $district, 'status' => $status]);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Customer added to database</div>';
	} else {
		// One or more fields are empty
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
		exit();
	}
}
