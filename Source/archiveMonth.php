<?php
	include 'db.php';
?>
<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	
<body class="body" id="body">
	<!--Archive-->
	<?php
	dbConnect();
	$cur=$_GET["year"];
	$cur=mysqli_real_escape_string($dbCon,$cur);
	dbClose();
	?>
	<div>
		<br>
		<div class="archiveBack"><h3 onclick="back()">Back</h2></div>
		<h1 style="display:inline-block;"><?php echo $cur;?></h1>
		<script>
			function changeMonth(month){
				window.location = "archiveDay.php?year="+<?php echo $cur;?>+"&month="+month
			}
			function back(){
				window.location = "archive.php?year=<?php echo $cur;?>";
			}
		</script>
		<?php
		//Echo months in year
		echo "<br>";
		dbConnect();
		for($i=1;$i<=12;$i+=1){
			//Check to see if there is anything in that month
			$sql="SELECT COUNT(time) FROM capture WHERE MONTH(time)=$i;";
			$result=query($sql);
			$result=$result[0]["COUNT(time)"];
			if ($result>0){
				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = $dateObj->format('F');
				echo "<div onclick='changeMonth($i)' class='month'><p>$monthName</p></div>";
			}
		}
		dbClose();
		
		?>
	</div>
	



</body>
</html>
		