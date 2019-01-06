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
                include "../inc/database.php";
                session_start();
                if(!empty($_SESSION['account'])){
                $account=$_SESSION['account'];
                } else {
                        echo "<script>window.alert('请先登录')</script>";
                        echo "<script>window.location.href='/login/login.html'</script>";
                }

                $sql = "select id,descr from user where account='$account'";
                $result = $handle->prepare($sql);
                $result->execute();
                $res = $result->fetch(PDO::FETCH_ASSOC);
                echo $res['id'];
                echo "</br>";
                echo $res['descr'];
            ?>
            </span>
        </div>
        <div class="leftPageNav">
            <a href="../home/home.php?page=1" class="leftPageList">
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
    <form class="main" action="add.php" method="POST" enctype="multipart/form-data">
        <textarea class="text" placeholder="记录这一刻，分享给懂你的人^_^" name="description"></textarea>
            <label for="file">图片：</label>
            <input type="file" name="file" id="file">
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