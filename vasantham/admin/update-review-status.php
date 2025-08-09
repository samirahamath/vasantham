<?php
session_start();
include('includes/dbconnection.php');

if (!isset($_POST['id']) || !isset($_POST['type'])) {
    echo 'error';
    exit();
}

$id = intval($_POST['id']);
$type = $_POST['type'];

if ($type === 'buy') {
    $table = 'tblwanttobuy';
} elseif ($type === 'sell') {
    $table = 'tblwanttosell';
} else {
    echo 'error';
    exit();
}

// Make sure the column name matches your DB schema
$q = "UPDATE $table SET IsReviewed=1 WHERE ID=$id";
if (mysqli_query($con, $q)) {
    echo 'success';
} else {
    echo 'error';
}
?>
