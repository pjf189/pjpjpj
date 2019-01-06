<?php
include "../inc/database.php";
header("Content-type: text/html; charset=utf-8");
session_start();
if(!empty($_SESSION['account'])){
    $account=$_SESSION['account'];
} else {
        echo "<script>window.alert('请先登录')</script>";
        echo "<script>window.location.href='/login/login.html'</script>";
    }
    $sql="select * from avatar where account = :account";
    $query=$handle->prepare($sql);
    $query->bindParam(":account",$account,PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if(isset($result['path'])){
        $path = $result['path'];
    }else{
        $path = "../image/icon.png";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="leftPage">
        <div>
            <img src="imgs/setting.png" class="setting">
            <img src="imgs/person.png" class="person">
        </div>
        <div>
            <img src="<?php echo $path; ?>" class="leftPageIcon">
            <span class="leftPageId" id="leftUsername">
            <?php


                $sql = "select id,descr from user where account='$account'";
                $result = $handle->prepare($sql);
                $result->execute();
                $res = $result->fetch(PDO::FETCH_ASSOC);
                echo $res['id'];
                echo "</br>";
                echo $res['descr'];
                $id = $_GET['id'];
                $query = $handle->prepare('select * from message where id = :id');
                $query->bindValue(':id',$id,PDO::PARAM_INT);
                $query->execute();
                $message = $query->fetchObject();
            ?>
            </span>
        </div>
        <div class="leftPageNav">
            <a href="../avatar/avatar.php" class="leftPageList">
                <img src="imgs/edit.png" class="leftPageListIcon">
                <img src="imgs/editW.png" class="leftPageListTable" style="height: 1rem;">
            </a>
            <a href="../setting/setting_1.php" class="leftPageList">
                <img src="imgs/settings.png" class="leftPageListIcon">
                <img src="imgs/settingsW.png" class="leftPageListTable">
            </a>
            <a href="../login/login.html" class="leftPageList">
                <img src="imgs/signOut.png" class="leftPageListIcon">
                <img src="imgs/signOutW.png" class="leftPageListTable">
            </a>
        </div>
    </div>
    <div class="head">
            <img src="imgs/box.png" class="box">
            <img src="imgs/setting.png" class="setting">
            <img src="imgs/logo.png" class="logo">
    </div>
    <form class="main" action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id;?>"/>
        <br/>
        <textarea class="text" placeholder="<?php echo $message->description;?>" name="description"></textarea>
        <button class="btn">分享此刻美好~</button>
    </form>
    <div class="foot">
            <a href="../home/home.php?page=1" class="fontNav">
                <img src="imgs/square.png" class="fontPng" style="width: 2.4rem;">
            </a>
            <a href="../add/add_1.php" class="fontNav">
                <img src="imgs/add.png" class="fontAdd">
            </a>
            <a href="../users/users.php" class="fontNav">
                <img src="imgs/user.png" class="fontPng" style="width: 2rem;">
            </a>
    </div>
    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js">
    </script>
    <script src="js/main.js"></script>
</body>
</html>