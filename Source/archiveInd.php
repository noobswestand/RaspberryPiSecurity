<!--
	add CSS to check if below a width, then it resized bars
	
	make it so that when you select a bar it shows images
-->


<?php
	include 'db.php';
?>

<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
		<script src="full_jquery.js"></script> 
	</head>
	
<body class="body" id="body">
	<!--Archive-->

	<div>
		<?php
		dbConnect();
		$day=$_GET['day'];
		$month=$_GET['month'];
		$year=$_GET['year'];
		$year=mysqli_real_escape_string($dbCon,$year);
		$month=mysqli_real_escape_string($dbCon,$month);
		$day=mysqli_real_escape_string($dbCon,$day);
		dbClose();
		?>
		<div class="archiveBack"><h3 onclick="back()">Back</h2></div>
		<h1 style="display:inline-block;"><?php echo $month;?>/<?php echo $day;?>/<?php echo $year;?></h1>
		<div class="graph">
		
		
		<?php
		//Create divs for 24 hours and scale them accordingly
		dbConnect();
		$hh = array();
		$max=0;
		for($i=1;$i<=24;$i+=1){
			$h=query("SELECT COUNT(time) FROM capture WHERE DAY(time)=$day AND MONTH(time)=$month AND YEAR(time)=$year AND HOUR(time)=$i;");
			$h=$h[0]["COUNT(time)"];
			$hh[$i]=$h;
			$max=max($max,$h);
		}
		dbClose();
		for($i=1;$i<=24;$i+=1){
			if ($max==0){
				$h=50;
			}else{
				$h=($hh[$i]/$max)*100;
			}
			$h=strval($h)."px;";
			$hr=$i%12;
			if ($hr==0){
				$hr=12;
			}
			echo "<div class='bar2'><div style='height: $h' class='bar' id='bar$i' onclick='changeHour($i);'></div><div class='barText'><p>$hr</p></div></div>";
			echo "<!--
			-->";
			//dividing bar
			if ($i==12){
				echo "<div class='barDiv'></div>";
				echo "<!--
				-->";
			}	
		}
		?>
		<div class="ampm"><h2>AM</h2></div>
		<div class="ampm"><h2>PM</h2></div>
		
		<script>
			function display(img){
				parent.display(img);
			}
			function changeHour(h){
				//Reset every other one
				for(i=0;i<=24;i++){
					$("#bar"+i).css("background-color", "#aeaeae");
				}
				$("#bar"+h).css("background-color", "#3267bc");
				document.getElementById('frame').src = "pictures.php?year=<?php echo $year;?>&month=<?php echo $month;?>&day=<?php echo $day;?>&hour="+h;
			}
			function back(){
				window.location = "archiveDay.php?year="+<?php echo $year;?>+"&month="+<?php echo $month;?>+"&day="+<?php echo $day;?>
			}
		</script>
		
		<iframe id="frame" class="pictureFrame" src="" frameborder="0">
		</iframe>
		
		
		</div>
			

	</div>

</body>
</html>