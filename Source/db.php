<?php
	// database variables
   $dbHost = "localhost";
   $dbName = "security";
   $dbUser = "root";
   $dbPass = "raspberry";
	// database connection functions
   function dbConnect() {
	  global $dbCon, $dbHost, $dbName, $dbUser, $dbPass;
	  $dbCon = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
	  if(! $dbCon ){
		die('Could not connect: ' . mysql_error());
	  }
   }
   
   function dbClose() {
	  global $dbCon, $dbHost, $dbName, $dbUser, $dbPass;
	  mysqli_close($dbCon);
	  unset($dbCon);
   }
   if (!function_exists('mysqli_fetch_all')) {
		function mysqli_fetch_all(mysqli_result $result) {
			$data = [];
			while ($data[] = $result->fetch_assoc()) {}
			array_pop($data);
			return $data;
		}
	}
   function query($sql){
	   global $dbCon, $dbResult;
	   if ($dbResult){
		mysqli_free_result($dbResult);
	   }
	   $dbResult=mysqli_query ($dbCon,$sql);
	   if ($dbResult===FALSE){
			die ("Error in query: $sql. " .mysqli_error($dbCon));
	   }
	   return mysqli_fetch_all($dbResult,MYSQLI_ASSOC);
   }
?>