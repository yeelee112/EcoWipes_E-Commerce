<?php
	define("SERVER", "localhost");
	define("DATABASE", "ecowipes_ecommerce");
	define("USERNAME", "root");
	define("PASSWORD", "");
	
	class DataProvider
	{
		public static function getConnection(){
			$connection=mysqli_connect(SERVER,USERNAME,PASSWORD)or
			die("Could not connect to ".SERVER.".");
			return $connection;
		}

		public static function execQuery($sql)
		{
			$connection=mysqli_connect(SERVER,USERNAME,PASSWORD)or
			die("Could not connect to ".SERVER.".");
			mysqli_select_db($connection,DATABASE);
			mysqli_query($connection,"set names 'utf8mb4'");
			$result = mysqli_query($connection,$sql);
			if(!$result)die ("Query failed:".mysqli_error($connection));
			mysqli_close($connection);
			return $result;
		}
	}
?>