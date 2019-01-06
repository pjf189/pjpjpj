<?php 
header("Content-type: text/html; charset=utf-8");
require_once '../inc/database.php';
require_once '../inc/common.php';
$id = $_POST['id'];
$sql = "update message set description = :description where id = :id;" ;	
$query = $handle->prepare($sql);
$query->bindValue('description',$_POST['description'],PDO::PARAM_STR);
$query->bindValue(':id',$id,PDO::PARAM_INT);

if (!$query->execute()) {	
	print_r($query->errorInfo());
}else{
	redirect_to("../show/show.php?id={$id}");
};


?>