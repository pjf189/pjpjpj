<?php
header("Content-type: text/html; charset=utf-8");
include "../inc/database.php";
session_start();
if(!empty($_SESSION['account'])){
    $account = $_SESSION['account'];
} else {
    echo "<script>window.alert('请先登录')</script>";
    echo "<script>window.location.href='../login/login.html'</script>";
}

$description = $_POST['description'];

$result = 0;
$sql = "insert into message (account,description) values(:account,:description)";
$result = $handle->prepare($sql);
$result->bindParam(':account',$account,PDO::PARAM_STR);
$result->bindParam(':description',$description,PDO::PARAM_STR);
$result->execute();
$message_id = $handle->lastInsertId();
$file = $_FILES["file"];
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if($file['size'] == 0){
    echo "<script>window.location.href='../home/home.php?page=1'</script>";
}else if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2048000)   // 小于 2000 kb
&& in_array($extension, $allowedExts)){
    $filename  = "../image/pic/".$file["name"];

    if ($_FILES["file"]["error"] > 0){
        echo "<script>alert(" . $_FILES["file"]["error"].");window.location.href='add_1.php'</script>";
    }
    else{

        // 判断目录是否存在该文件
        // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        if (file_exists("../image/pic/" . $file['name'])){
            echo "<script>alert(".$file["name"] . " has been existed);window.location.href='add_1.php'</script> ";
        }
        else{
            // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
            move_uploaded_file($file['tmp_name'],iconv("UTF-8","gb2312",$filename));
            $query = $handle->prepare("insert into pic (path,message_id) value(:path,:message_id)");
            $query->bindParam(":path",$filename,PDO::PARAM_STR);
            $query->bindParam(":message_id",$message_id,PDO::PARAM_INT);
            $query->execute();
            echo "<script>window.location.href='../home/home.php?page=1'</script>";
        }
    }
}
?>