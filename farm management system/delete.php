<?php include 'setting/system.php'; ?>
<?php

if(!$_GET['id'] OR empty($_GET['id']))
{
	header('location: manage-dog.php');
}else
{
	$id = (int)$_GET['id'];
	$query = $db->query("DELETE FROM dogs WHERE id = $id ");
	if($query){
		header('location: manage-dog.php');
	}
}

