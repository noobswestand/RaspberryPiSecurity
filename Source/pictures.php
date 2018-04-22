<?php
	include 'db.php';
?>

<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	
<body class="pictureBody">
	<!--Archive-->
	<?php
		dbConnect();
		$day=$_GET['day'];
		$month=$_GET['month'];
		$year=$_GET['year'];
		$hour=$_GET['hour'];
		
		$year=mysqli_real_escape_string($dbCon,$year);
		$month=mysqli_real_escape_string($dbCon,$month);
		$day=mysqli_real_escape_string($dbCon,$day);
		$hour=mysqli_real_escape_string($dbCon,$hour);
		
		$page=0;
		if(isset($_GET['page'])){
			$page=$_GET['page'];
			$page=mysqli_real_escape_string($dbCon,$page);
		}
		$page=(int)$page;
		$page2=$page*10;
		
		$sql="SELECT location FROM capture WHERE DAY(time)=$day AND MONTH(time)=$month AND YEAR(time)=$year AND HOUR(time)=$hour LIMIT $page2,10;";
		$result=query($sql);
		echo "<div class='archiveDiv' align='center'>";
		foreach ($result as $r){
			$img=$r["location"];
			$img2='"'.$img.'"';
			echo "<img src='$img' onclick='display($img2)' class='archiveImg'>";
		}
		?>
		<script>
		function display(img){
			parent.display(img);
		}
		</script>
		<?php
		echo "<br>";
		
		if ($page!=0){
			$page-=1;
			$onclick="pictures.php?year=$year&month=$month&day=$day&hour=$hour&page=$page";
			?>
			<i class='leftArrow' onclick="location.href ='<?php echo $onclick;?> '"></i>
			<?php
			$page+=1;
		}
		
		$page+=1;
		$page2=$page*10;
		$onclick2="pictures.php?year=$year&month=$month&day=$day&hour=$hour&page=$page";
		$sql="SELECT location FROM capture WHERE DAY(time)=$day AND MONTH(time)=$month AND YEAR(time)=$year AND HOUR(time)=$hour LIMIT $page2,10;";
		$result=query($sql);
		if (count($result)>0){
			?>
			<i class='rightArrow' onclick="location.href ='<?php echo $onclick2;?> '"></i>
			<?php
		}
		echo "</div>";
		dbClose();
	?>

</body>
</html>