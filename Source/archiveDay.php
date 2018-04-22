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
		$month=$_GET['month'];
		$year=$_GET['year'];
		$month=mysqli_real_escape_string($dbCon,$month);
		$year=mysqli_real_escape_string($dbCon,$year);
		dbClose();
		
	
	
		
		$dateObj   = DateTime::createFromFormat('!m', $month);
		$monthName = $dateObj->format('F');
		?>
		<div class="archiveBack"><h3 onclick="back()">Back</h2></div>
		<h2 style='display:inline-block;'><?php echo $year;?> - <?php echo $monthName;?></h2>
		<?php
		$number = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		dbConnect();
		?>
		<script>
			function changeDay(day){
				window.location = "archiveInd.php?year="+<?php echo $year;?>+"&month="+<?php echo $month;?>+"&day="+day
			}
			function back(){
				window.location = "archiveMonth.php?year="+<?php echo $year;?>+"&month="+<?php echo $month;?>;
			}
		</script>
		<?php
		echo "<br>";
		for($i=1;$i<=$number;$i+=1){
			$sql="SELECT * FROM capture WHERE DAY(time)=$i AND MONTH(time)=$month AND YEAR(time)=$year;";
			$result=query($sql);
			$count=count($result);
			if ($count==0){
				//echo "<div class='day'><p class='left'>$i</p><br><p>$count</p></div>";
			}else{
				echo "<div class='day hit' onclick='changeDay($i)'><p class='left'>$i</p><br><p>$count</p></div>";
			}
		}
		dbClose();
	
	?>
	</body>
	
</html>