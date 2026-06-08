<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');
$uPrice = 0;
$qty = 0;
$totalPrice = 0;
$itemDetailsSearchSql = 'SELECT * FROM item';
$itemDetailsSearchStatement = $conn->prepare($itemDetailsSearchSql);
$itemDetailsSearchStatement->execute();
$output = '<table id="itemReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>Product ID</th>
						<th>Item Number</th>
						<th>Item Name</th>
						<th>Discount %</th>
						<th>Stock</th>
						<th>Unit Price</th>
						<th>Total Price</th>
					</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $itemDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
	$uPrice = $row['unitPrice'];
	$qty = $row['stock'];
	$totalPrice = $uPrice * $qty;

	$output .= '<tr>' .
		'<td>' . $row['productID'] . '</td>' .
		'<td>' . $row['itemNumber'] . '</td>' .
		//'<td>' . $row['itemName'] . '</td>' .
		'<td><a href="#" class="itemDetailsHover" data-toggle="popover" id="' . $row['productID'] . '">' . $row['itemName'] . '</a></td>' .
		'<td>' . $row['discount'] . '</td>' .
		'<td>' . $row['stock'] . '</td>' .
		'<td>' . $row['unitPrice'] . '</td>' .
		'<td>' . $totalPrice . '</td>' .
		// '<td>' . $row['description'] . '</td>' .
		'</tr>';
}
$itemDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						<tr>
							<th>Totals</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tfoot>
				</table>';


echo $output;
