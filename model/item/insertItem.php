<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$initialStock = 0;
$baseImageFolder = '../../data/item_images/';
$itemImageFolder = '';
$today = date('Y-m-d');
$vendorID = 1; // Default vendor ID for new items. This is required as purchase table has a foreign key constraint with vendor table. Hence, we need to insert a default value here. You can change this as per your requirement.
$vendorName = '';
if (isset($_POST['itemDetailsItemNumber'])) {

	$itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
	$itemName = htmlentities($_POST['itemDetailsItemName']);
	$discount = htmlentities($_POST['itemDetailsDiscount']);
	$quantity = htmlentities($_POST['itemDetailsQuantity']);
	$unitPrice = htmlentities($_POST['itemDetailsUnitPrice']);
	$status = htmlentities($_POST['itemDetailsStatus']);
	$description = htmlentities($_POST['itemDetailsDescription']);

	// Check if mandatory fields are not empty
	if (!empty($itemNumber) && !empty($itemName) && isset($quantity) && isset($unitPrice)) {

		// Sanitize item number
		$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

		// Validate item quantity. It has to be a number
		if (filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)) {
			// Valid quantity
		} else {
			// Quantity is not a valid number
			echo '<div class="alert alert-danger">Please enter a valid number for quantity</div>';
			exit();
		}

		// Validate unit price. It has to be a number or floating point value
		if (filter_var($unitPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($unitPrice, FILTER_VALIDATE_FLOAT)) {
			// Valid float (unit price)
		} else {
			// Unit price is not a valid number
			echo '<div class="alert alert-danger">Please enter a valid number for unit price</div>';
			exit();
		}

		// Validate discount only if it's provided
		if (!empty($discount)) {
			if (filter_var($discount, FILTER_VALIDATE_FLOAT) === false) {
				// Discount is not a valid floating point number
				echo '<div class="alert alert-danger">Please enter a valid discount amount</div>';
				exit();
			}
		}

		// Create image folder for uploading images
		$itemImageFolder = $baseImageFolder . $itemNumber;
		if (is_dir($itemImageFolder)) {
			// Folder already exist. Hence, do nothing
		} else {
			// Folder does not exist, Hence, create it
			@mkdir($itemImageFolder, 0777, true);
		}

		// Calculate the stock values
		$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
		$stockStatement = $conn->prepare($stockSql);
		$stockStatement->execute(['itemNumber' => $itemNumber]);
		if ($stockStatement->rowCount() > 0) {
			//$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
			//$quantity = $quantity + $row['stock'];
			echo '<div class="alert alert-danger">Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
			exit();
		} else {
			// Item does not exist, therefore, you can add it to DB as a new item
			// Start the insert process
			$insertItemSql = 'INSERT INTO item(itemNumber, itemName, discount, stock, unitPrice, status, description) VALUES(:itemNumber, :itemName, :discount, :stock, :unitPrice, :status, :description)';
			$insertItemStatement = $conn->prepare($insertItemSql);
			$insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'discount' => $discount, 'stock' => $quantity, 'unitPrice' => $unitPrice, 'status' => $status, 'description' => $description]);
			//Also insert to purchase table
			$insertPurchaseSql = 'INSERT INTO purchase(itemNumber, purchaseDate, itemName, unitPrice, quantity, vendorName, vendorID) VALUES(:itemNumber, :purchaseDate, :itemName, :unitPrice, :quantity, :vendorName, :vendorID)';
			$insertPurchaseStatement = $conn->prepare($insertPurchaseSql);
			$insertPurchaseStatement->execute(['itemNumber' => $itemNumber, 'purchaseDate' => $today, 'itemName' => $itemName, 'unitPrice' => $unitPrice, 'quantity' => $quantity, 'vendorName' => $vendorName, 'vendorID' => $vendorID]);
			echo '<div class="alert alert-success">Item added to database.</div>';
			exit();
		}
	} else {
		// One or more mandatory fields are empty. Therefore, display a the error message
		echo '<div class="alert alert-danger">Please enter all fields marked with a (*)</div>';
		exit();
	}
}
