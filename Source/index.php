<?php
session_start();

$loginPage="
<div style='margin:auto;'>
<form action=login.php method='post'>
<p>Username</p>
<input type='text' name='username' value=''>
<p>Password</p>
<input type='password' name='password' value=''>
<br><br>
<input type='submit' value='Login'>
</form>
</div>
";
?>

<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
		<script src="full_jquery.js"></script> 
		<title>Home Security</title>
	</head>
	
	<body>
		<?php
		if (isset($_SESSION["login"])) {
			if ($_SESSION["login"]=="true"){
		?>
		<!--Nav-->
		<div class="nav">
			<div id="headButton0"><h1>Main</h1></div>
			<div id="headButton1"><h1>Archive</h1></div>
			<div id="headButton2"><h1>Settings</h1></div>
		</div>
		
		<!--Bod-->
		<iframe style="width:95%" id="body" class="body" frameborder="0" src="">	
		</iframe>
		
		<!--Pop up Image-->
		<div class="popup" id="popupDiv" onclick="hide()">
			<p>Click anywhere to close</p>
			<img src="" id="popup"></img>
		</div>
		
		<script>
		function display(img){
			document.getElementById('popup').src=img;
			document.getElementById("popupDiv").style.display = "block";
		}
		function hide(){
			document.getElementById("popupDiv").style.display = "none";
		}
		</script>
		
		<script>
		$("#headButton0").click(function(){
			document.getElementById('body').src = "main.php";
			$("#headButton0").css("color", "#3267bc");
			$("#headButton1").css("color", "white");
			$("#headButton2").css("color", "white");
		});
		$("#headButton1").click(function(){
			document.getElementById('body').src = "archive.php";
			$("#headButton0").css("color", "white");
			$("#headButton1").css("color", "#3267bc");
			$("#headButton2").css("color", "white");
		});
		$("#headButton2").click(function(){
			document.getElementById('body').src = "settings.php";
			$("#headButton0").css("color", "white");
			$("#headButton1").css("color", "white");
			$("#headButton2").css("color", "#3267bc");
		});
		
		$("#headButton0").css("color", "#3267bc");
		document.getElementById('body').src = "main.php";
		</script>
		
		<!--Footer-->
		<div class="foot">
			<p>By Dan</p>
		</div>
		<?php
		}else{
				echo $loginPage;
			}
		}else{
			echo $loginPage;
		}
		?>
	</body>
	
</html>