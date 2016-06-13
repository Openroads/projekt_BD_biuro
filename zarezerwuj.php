<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Oferty wycieczek</title>
</head>
<body>

<?php
	require_once "danebazy.php";

	$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
	$connect->query('SET NAMES utf8');
	if($connect->errno)
	{
		echo $connect->connect_errno;
	}
	else{

		$pesel = $_POST['Pesel'];
		/*$imie =  $_POST['Imie'];
		$nazwisko = $_POST['Nazwisko'];
		$adres = $POST['Adres'];*/

		$pesel_query ="SELECT * from klient where pesel='$pesel'";
		$result = $connect->query($pesel_query);

		if($result!=false)
		{
			if($result->num_rows > 0)
			{
				$klient = $result->fetch_array();
				echo $klient['imie'].$klient['nazwisko'];
			}else{

				$insert_client ="INSERT INTO klient VALUES ('{$_POST["Pesel"]}','{$_POST["Imie"]}','{$_POST["Nazwisko"]}','{$_POST["Adres"]}')";
				$connect->query($insert_client);
			}
			$result->free();
		}
		$connect->close();
	}
?>

</body>
</html>