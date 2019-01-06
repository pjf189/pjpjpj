<?php 

require_once '../inc/database.php';
require_once '../inc/common.php';
$sql = 	"delete from user where id = :id" ;	
$query = $handle->prepare($sql);
$query->bindValue(':id',$_GET['id'],PDO::PARAM_INT);

if (!$query->execute()) {	
	print_r($query->errorInfo());
}else{
	redirect_back();
};

?>