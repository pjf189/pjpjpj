<?php
header("Content-type:text/html;charset=utf-8");
require_once '../inc/database.php';
require_once '../inc/common.php';

$id = $_POST['id'];
$sql = "UPDATE message SET zanshu = zanshu +1 WHERE id = '$id'";
$res = $handle->query($sql);
redirect_back();
?>