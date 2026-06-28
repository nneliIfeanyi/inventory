<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

header('Content-Type: application/json');

if (!isset($_POST['creditID'])) {
    echo json_encode(['success' => false, 'message' => 'Missing credit ID']);
    exit();
}

$creditID = intval($_POST['creditID']);
$paidRaw = isset($_POST['paid']) ? $_POST['paid'] : '';

if ($paidRaw === '') {
    echo json_encode(['success' => false, 'message' => 'Please provide an amount paid']);
    exit();
}

$paid = filter_var($paidRaw, FILTER_VALIDATE_FLOAT);
if ($paid === false) {
    echo json_encode(['success' => false, 'message' => 'Invalid amount provided']);
    exit();
}

try {
    $stmt = $conn->prepare('SELECT purchaseTotal FROM credit_book WHERE id = :id');
    $stmt->execute(['id' => $creditID]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode(['success' => false, 'message' => 'Credit entry not found']);
        exit();
    }

    $purchaseTotal = floatval($row['purchaseTotal']);

    if ($paid >= $purchaseTotal) {
        // remove record
        $del = $conn->prepare('DELETE FROM credit_book WHERE id = :id');
        $del->execute(['id' => $creditID]);
        echo json_encode(['success' => true, 'action' => 'deleted', 'id' => $creditID, 'message' => 'Credit entry cleared and removed.']);
        exit();
    } else {
        // update paid
        $upd = $conn->prepare('UPDATE credit_book SET paid = :paid WHERE id = :id');
        $upd->execute(['paid' => $paid, 'id' => $creditID]);
        echo json_encode(['success' => true, 'action' => 'updated', 'id' => $creditID, 'paid' => $paid, 'message' => 'Credit entry updated.']);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}
