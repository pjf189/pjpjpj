<?php
header("Content-type: text/html; charset=utf-8");
include "../inc/database.php";
session_start();
if(!empty($_SESSION['account'])){
    $account = $_SESSION['account'];
} else {
    echo "<script>window.alert('请先登录')</script>";
    echo "<script>window.location.href='/front/login/login.html'</script>";
}

$description = $_POST['description'];

$result = 0;
$sql = "update user set descr=:description where account=:account";
$result = $handle->prepare($sql);
$result->bindParam(':account',$account,PDO::PARAM_STR);
$result->bindParam(':description',$description,PDO::PARAM_STR);
$result->execute();
echo "<script>window.location.href='/home/home.php?page=1'</script>";
?>
