<?php

include "../inc/database.php";
include "../inc/common.php";
header("Content-type: text/html; charset=utf-8");
$account = $_POST['account'];
$password = $_POST['password'];

$sql = "select account,password from user where account=:account";
$result = $handle->prepare($sql);
$result->bindValue(':account',$account,PDO::PARAM_STR);
$result->execute();
$res = $result->fetch(PDO::FETCH_ASSOC);//返回数据
if(!$res){
    echo "<script>alert('no this user!');window.location.href='login.html'</script>";
}

if ($account == $res['account'] && $password == $res['password'] && $account <> "admin"){
    session_start();
    $_SESSION['account'] = $account;
    echo "<script>window.location.href='../home/home.php?page=1'</script>";
}else if($account == $res['account'] && $password == $res['password'] && $account == "admin"){
    session_start();
    $_SESSION['account'] = $account;
    echo "<script>window.location.href='../admin/admin.php?page=1'</script>";
}else{
    echo "<script>alert('wrong password!');window.location.href='login.html'</script>";
}
?>
