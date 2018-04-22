<?php
	include 'db.php';
	dbConnect();
	switch($_GET['action']){
		case "delete":
			$id=$_GET["ID"];
			$id=mysqli_real_escape_string($dbCon,$id);
			$sql="DELETE FROM time WHERE ID=$id;";
			query($sql);
		break;
		case "add":
			$start=$_GET["start"];
			$end=$_GET["end"];
			$day=$_GET["day"];
			$start=mysqli_real_escape_string($dbCon,$start);
			$end=mysqli_real_escape_string($dbCon,$end);
			$day=mysqli_real_escape_string($dbCon,$day);
			if ($start!="" && $end!=""){
				$sql="INSERT INTO time VALUES (null,$start,$end,$day);";
				query($sql);
			}
		break;
	}
	dbClose();
	header("location:settings.php");
?>