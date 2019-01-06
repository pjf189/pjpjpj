<?php 
session_start();
require_once "../inc/database.php";
require_once "../inc/common.php";

$pager = new Pager('select * from user');
$query = $pager->query($_GET['page']);
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
            <img src="imgs/icon.png" class="leftPageIcon">
            <span class="leftPageId" id="leftUsername">
            <?php

                if(!empty($_SESSION['account'])){
                $account=$_SESSION['account'];
                } else {
                        echo "<script>window.alert('请先登录')</script>";
                        echo "<script>window.location.href='/login/login.html'</script>";
                }
                $sql = "select account,descr from user where account='$account'";
                $result = $handle->prepare($sql);
                $result->execute();
                $res = $result->fetch(PDO::FETCH_ASSOC);
                echo $res['account'];
            ?>
            </span>
        </div>
        <div class="leftPageNav">
            <a href="admin.php?page=1" class="leftPageList">
                <img src="imgs/edit.png" class="leftPageListIcon">
                <img src="imgs/editW.png" class="leftPageListTable" style="height: 1rem;">
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
        if($ss=="admin"){
            continue;
        }
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
            "<div class='listID'> {$row['id']}  </div>".
            "<div class='listContent'>account:{$row['account']}".
            "<a style='float:right;width:200px;' href='delete_user.php?id={$row['id']}'>删</a>".
            "<input type='hidden' name='id' value='{$row['id']}'>"
        ."</div></div>";
    }
    echo $pager->nav_html();
?>
    </div>
    <div class="foot">
        <a href="admin.php?page=1" class="fontNav">
            <img src="imgs/square.png" class="fontPng" style="width: 2.4rem;">
        </a>
        <a href="users.php?page=1" class="fontNav">
            <img src="imgs/user.png" class="fontPng" style="width: 2rem;">
        </a>
    </div>

</body>
<script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js">

</script>
    <script src="js/main.js"></script>
</html>