<?php
	require_once "danebazy.php";

	$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);

	if($connect->errno)
	{
		echo $polaczenie->connect_errno;
	}
	else{
		 
		



		$polaczenie->close();
	}


?>