<?php 
session_start();
require_once "../inc/database.php";
header("Content-type: text/html; charset=utf-8");
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
                echo $res['account'];
                echo "</br>";
                echo $res['descr'];
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
        $sql = "select * from message where id = :id";
        $result = $handle->prepare($sql);
        $result->bindValue(':id',$_GET['id'],PDO::PARAM_INT);
        $result->execute();
        $message = $result->fetch(PDO::FETCH_ASSOC);
        $sql2 = "select * from user where account = :account";
        $result2 = $handle->prepare($sql2);
        $result2->bindValue(':account',$message['account'],PDO::PARAM_STR);
        $result2->execute();
        $description = $result2->fetch(PDO::FETCH_ASSOC);
        $sql5 = "select * from avatar where account = :account";
        $result5 = $handle->prepare($sql5);
        $result5->bindParam(':account',$message['account'],PDO::PARAM_STR);
        $result5->execute();
        $res5 = $result5->fetch(PDO::FETCH_ASSOC); 
        if(!isset($res5['path'])){
            $path1 = "../image/icon.png";
        }else{
            $path1 = $res5['path'];
        }
        $sql6 = "select * from pic where message_id = :message_id";
        $query6 = $handle->prepare($sql6);
        $query6->bindParam(":message_id",$_GET['id'],PDO::PARAM_STR);
        $query6->execute();
        $result6 = $query6->fetch(PDO::FETCH_ASSOC);
        if(isset($result6['path'])){
            $path3=$result6['path'];
        }else{
            $path3 = null;
        }
        echo "<div class='list'"
        ."<div class='listInf'>".
        "<img src='$path1' class='listIcon'>".
        "<div class='listID'> {$description['id']}</div>".
        "<div class='listContent'>{$message['description']}<img src='$path3' style='width:200px;height:200px;'> </div>".
        "</br>".
        "个性签名：{$description['descr']} </br>";
    ?>
    <form action="dianzan.php" method="POST">
    <input type="hidden"  name="id" value=<?php echo $message['id'] ?>/>
    点赞数：<span><?php echo $message['zanshu']; ?></span>
    <button style='float:right' class="btn">👍</button>
    </form>
    </div>
    </div>
    <form class="comment" action="comment.php" method="POST">
    <input type="hidden" name="message_id" value="<?php echo $message['id'] ?>"/>
    <input type="hidden" name="account" value="<?php echo $account; ?>"/>
    <label for="title">主题：</label>
    <input type="text" name="title" />
    <textarea cols="40" name="body"></textarea>
    <button class="btn">分享评论</button>
    </form>
    <div class="main">
        <?php
            $sql = "select * from comments where message_id = {$message['id']}";
            $result2 = $handle->prepare($sql);
            $result2->execute();
            while($comment = $result2->fetch(PDO::FETCH_ASSOC)){
                $result3 = $handle->prepare("select * from user where account = :account");
                $result3->bindParam(":account",$comment['account'],PDO::PARAM_STR);
                $result3->execute();
                $res3 = $result3->fetch(PDO::FETCH_ASSOC);
                $ss = $res3['account'];
                $sql4 = "select * from avatar where account = '$ss'";
                $result4 = $handle->prepare($sql4);
                $result4->execute();
                $res4 = $result4->fetch(PDO::FETCH_ASSOC); 
                if(!isset($res4['path'])){
                    $path2 = "../image/icon.png";
                }else{
                    $path2 = $res4['path'];
                }

                echo "<div class='list'"
                ."<div class='listInf'>".
                "<img src='$path2' class='listIcon'>".
                "<div class='listID'> {$comment['title']} </div>".
                "<div class='listContent'>{$comment['body']}</div>".
                "点赞数：<span>{$comment['zanshu']}</span>";
        ?>
        <form action="dianzan2.php" method="POST">
        <input type="hidden" name="id" value=<?php echo $comment['id'] ?>/>
        <button class="btn">👍</button>
        </form>
        <?php echo "</div>"; }?>
    </div>
    </div>
    <div class="foot">
        <a href="admin.php?page=1" class="fontNav">
            <img src="imgs/square.png" class="fontPng" style="width: 2.4rem;">
        </a>
        <a href="user.php" class="fontNav">
            <img src="imgs/user.png" class="fontPng" style="width: 2rem;">
        </a>
    </div>
</body>
<script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js">
    </script>
    <script src="js/main.js"></script> 
</html>