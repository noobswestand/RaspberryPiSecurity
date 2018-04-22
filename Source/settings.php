<?php
	include 'db.php';
?>
<html>
	
	<head>
		<link rel="stylesheet" href="style.css">
	</head>
	
<body class="body" id="body">
	<p>Please allow a minute for any changes to take effect.</p>
	<?php
	dbConnect();
	$sql="SELECT name,ID FROM weekday;";
	$result=query($sql);
	
	?>
	
	<script type="text/javascript">
		function changeDay() {
			//Hide everything else
			for(var i=1;i<=7;i++){
				var div = document.getElementById("day"+i);
				div.style.display = "none";
			}
			var selectBox = document.getElementById("days");
			var selectedValue = selectBox.options[selectBox.selectedIndex].value;
			document.cookie=selectedValue;
			var div = document.getElementById("day"+selectedValue);
			div.style.display = "block";
		}
		function loadDay(){
			var val = document.cookie;
			var sel = document.getElementById('days');
			  var opts = sel.options;
			  for (var opt, j = 0; opt = opts[j]; j++) {
				if (opt.value == val) {
				  sel.selectedIndex = j;
				  break;
				}
			  }

		}
		
		</script>
	
	<select id="days" name="days" onchange="changeDay();">
	<?php
	foreach ($result as $r){
		$name=$r["name"];
		$id=$r["ID"];
		?>
		<option value="<?php echo $id;?>">
		<?php echo $name;?>
		</option>

		<?php
	}?>
	</select>
	<br>
	
	<?php
	foreach ($result as $r){
		$name=$r["name"];
		$id=$r["ID"];
		?>
		<div id="day<?php echo $id; ?>" class='settingsDay' style="display:none;">
			<table class='settingsTable'>
				<tr>
					<th>Start</th>
					<th>End</th>
					<th></th>
				</tr>
				<?php
				$sql="SELECT start,end,time.ID FROM time
						JOIN weekday ON weekday.ID=time.DayID
						WHERE weekday.name='$name';";
				$result2=query($sql);
				foreach ($result2 as $r2){
					?>
					<tr>
					<form action="actions.php">
					<input type="hidden" name="action" value="delete">
					<input type="hidden" name="ID" value="<?php echo $r2["ID"];?>">
					<th><?php echo $r2["start"];?></th>
					<th><?php echo $r2["end"];?></th>
					<th><input type="submit" value="Remove"></th>
					</form>
					</tr>
					<?php
				}
				?>
				<tr>
					<form action="actions.php">
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="day" value="<?php echo $id;?>">
					<th><input type="text" name="start" value=""></th>
					<th><input type="text" name="end" value=""></th>
					<th><input type="submit" value="Add"></th>
					</form>
				</tr>
			</table>
				
		</div>
		<?php
	}?>
	<script>
		loadDay();
		changeDay();
	</script>
	<?php
	
	
	dbClose();
	?>

</body>
</html>