<?php 
session_start();
require_once "../inc/database.php";
require_once "../inc/common.php";
header("Content-type: text/html; charset=utf-8");
$pager = new Pager('select * from message order by id desc');
$query = $pager->query($_GET['page']);
if(!empty($_SESSION['account'])){
    $account=$_SESSION['account'];
    } else {
            echo "<script>window.alert('请先登录')</script>";
            echo "<script>window.location.href='/login/login.html'</script>";
    }
    $sql1="select * from avatar where account = :account";
    $query1=$handle->prepare($sql1);
    $query1->bindParam(":account",$account,PDO::PARAM_STR);
    $query1->execute();
    $result = $query1->fetch(PDO::FETCH_ASSOC);
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
                $sql2 = "select id,descr from user where account='$account'";
                $result2 = $handle->prepare($sql2);
                $result2->execute();
                $res = $result2->fetch(PDO::FETCH_ASSOC);
                echo $res['id'];
                echo "</br>";
                echo $res['descr'];
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
    <div class="main"> 
    <?php

    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $ss = $row['account'];
        $sql2 = "select id from user where account='$ss'";
        $result2 = $handle->prepare($sql2);
        $result2->execute();
        $res = $result2->fetch(PDO::FETCH_ASSOC);
        $sql3 = "select * from avatar where account = '$ss'";
        $result3 = $handle->prepare($sql3);
        $result3->execute();
        $res1 = $result3->fetch(PDO::FETCH_ASSOC); 
        if(!isset($res1['path'])){
            $path1 = "../image/icon.png";
        }else{
            $path1 = $res1['path'];
        }
        echo "<div class='list'"
            ."<div class='listInf'>".
            "<img src='$path1' class='listIcon'>".
            "<div class='listID'> {$res['id']}  </div>".
            "<div class='listContent'>{$row['description']}</div>".
            "<a style='float:right;width:200px;' href='../show/show.php?id={$row['id']}'>查看详情      </a>"
            ."<input type='hidden' name='id' value='{$row['id']}'>"
            ."点赞数： <span id='s'> {$row['zanshu']}</span>"
        ."</div>";
    }
    echo $pager->nav_html();
?>
    </div>
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

</body>
<script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js">

</script>
    <script src="js/main.js"></script>
</html>