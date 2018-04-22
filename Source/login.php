<?php
session_start();

if ($_POST['username']=='root' && $_POST['password']=='raspberry'){
	$_SESSION['login']=true;
}

header("location:index.php");
?>