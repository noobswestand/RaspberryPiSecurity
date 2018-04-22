
<!--
	Displays the latest image that was captured
-->

<?php
	include 'db.php';
?>

<!--Main-->
<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body class="body" id="body">
		<div id="headButtonDiv0"></div>
	</body>

	<script>
	var current=true;
	var live=`
		<h2>Live</h2>
		<iframe class="liveView" scrolling="no" src="http://174.103.234.234:5000/">
		</iframe>
		
		<a onclick="switchViews()" class="live"><h2>Switch to basic view</h2></a>
	`;
	var picture=`
		<h2>Latest Motion</h2>
		<img
		src="<?php
			dbConnect();
			$result=query("SELECT location FROM capture ORDER BY time DESC LIMIT 1;");
			$img=$result[0]["location"];
			dbClose();
			echo $img;
		?>">
		
		<a onclick="switchViews()" class="live"><h2>Switch to live view</h2></a>
	`;
	function switchViews(){
		current=!current;
		if (current==true){
			document.getElementById("headButtonDiv0").innerHTML=live
		}else{
			document.getElementById("headButtonDiv0").innerHTML=picture
		}
	}
	switchViews()
	</script>

</html>

