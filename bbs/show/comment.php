<?php
session_start();
include "../inc/database.php";
include "../inc/common.php";
header("Content-type: text/html; charset=utf-8");
if(!empty($_SESSION['account'])){
    $account = $_SESSION['account'];
} else {
    echo "<script>window.alert('请先登录')</script>";
    echo "<script>window.location.href='../login/login.html'</script>";
}


$result = 0;
$sql = "insert into comments (title,body,message_id,account) values(:title,:body,:message_id,:account)";
$result = $handle->prepare($sql);
$result->bindParam(':title',$_POST['title'],PDO::PARAM_STR);
$result->bindParam(':body',$_POST['body'],PDO::PARAM_STR);
$result->bindParam(':message_id',$_POST['message_id'],PDO::PARAM_INT);
$result->bindParam(':account',$_POST['account'],PDO::PARAM_STR);
$result->execute();
redirect_back();
?>