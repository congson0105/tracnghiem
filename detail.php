<?php
include('connect.php');
$id = $_GET['id'];

$sql = "select * from cauhoi where id = '" . $id . "'";
$rs = $conn->prepare($sql);
$rs->execute();
$result = $rs->fetch();
echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>