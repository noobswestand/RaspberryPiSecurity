<?php
	include 'db.php';
?>

<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	
<body class="body" id="body">
	<!--Archive-->

	<div id="year">
	<script>
		function changeYear(year){
			window.location = "archiveMonth.php?year="+year;
		}
	</script>
	<?php
		//Create divs for years
		dbConnect();
		$result=query("SELECT DISTINCT YEAR(time) FROM capture ORDER BY YEAR(time) DESC;");
		dbClose();
		$result=$result;
		foreach($result as $year){
			$cur=$year["YEAR(time)"];
			?>
			<br>
			<div class="year" onclick="changeYear(<?php echo $cur;?>);">
				<h1><?php echo $cur;?></h1>
			</div>
			<?php
		}
	?>

	</div>

</body>
</html>