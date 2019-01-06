<?php
session_start();
header("Content-type: text/html; charset=utf-8");
$file = $_FILES["file"];
require_once "../inc/database.php";
require_once "../inc/common.php";
if(!empty($_SESSION['account'])){
    $account=$_SESSION['account'];
    }else{
        echo "<script>window.alert('请先登录')</script>";
        echo "<script>window.location.href='/login/login.html'</script>";
}
$sql1="select * from avatar where account = :account";
$query1=$handle->prepare($sql1);
$query1->bindParam(":account",$account,PDO::PARAM_STR);
$query1->execute();
$result1=$query1->fetchObject();

// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if(!isset($file)){
    break;
}else if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts)){
    $filename  = "../image/avatar/".$file["name"];

    if ($_FILES["file"]["error"] > 0){
        echo "<script>alert(" . $_FILES["file"]["error"].");window.location.href='avatar.php'</script>";
    }
    else{

        // 判断目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("../image/avatar/" . $file['name'])){
            echo "<script>alert(".$file["name"] . " has been existed);window.location.href='avatar.php'</script> ";
        }
        else if(empty($result1)){
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($file['tmp_name'], iconv("UTF-8","gb2312",$filename));
            $query = $handle->prepare("insert into avatar (path,account) values(:path,:account)");
            $query->bindParam(":path",$filename,PDO::PARAM_STR);
            $query->bindParam(":account",$account,PDO::PARAM_STR);
            $query->execute();
            redirect_back();
        }else{
            move_uploaded_file($_FILES['file']['tmp_name'], iconv("UTF-8","gb2312",$filename));
            $query = $handle->prepare("update avatar set path = :path where account = :account");
            $query->bindParam(":path",$filename,PDO::PARAM_STR);
            $query->bindParam(":account",$account,PDO::PARAM_STR);
            $query->execute();
            redirect_back();
        }
    }
}
else 
{
    echo "<script>alert('wrong format!');window.location.href='avatar.php'</script>";
}
?>