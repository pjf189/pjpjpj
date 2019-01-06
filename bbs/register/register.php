<?php

include "../inc/database.php";
include "../inc/common.php";
header("Content-type: text/html; charset=utf-8");
$account = $_POST['account'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

    $sql = "select account from user where account=:account";
    $result = $handle->prepare($sql);
    $result->bindParam(':account',$account,PDO::PARAM_STR);
    $result->execute();
    $data = $result->fetch(PDO::FETCH_ASSOC);
    if($data) {
        echo "<script>window.alert('Account has already existed!');window.location.href='register.html'</script>";
    } else if(strlen($password1)<6){
        echo "<script>window.alert('Unqualified password!');
        window.location.href='register.html'</script>";
    } else {
        $result=0;
        if($password1 == $password2){
        $sql = "insert into user(account, password) values(:account, :password);";
        $result = $handle->prepare($sql);
        $result->bindValue(':account',$account,PDO::PARAM_STR);
        $result->bindValue(':password',$password1,PDO::PARAM_STR);
        $result->execute();
        }
        echo $result ? "<script>window.alert('registering has been completed!');
        window.location.href='../login/login.html'</script>" : 
        "<script>window.alert('the passwords input are different!');
        window.location.href='register.html'</script>";
    }

?>