<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Terminy wyjazdów</title>
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
		$ofertyTerminowQuery = "SELECT * from termin join oferta on termin.numerOferty = oferta.numerOferty";
		$resultOf = $connect->query($ofertyTerminowQuery);

		if( $resultOf !=false)
		{
			$contents = "<table>";
			while($oferta = $resultOf->fetch_array())
			{
				$contents = $contents."<tr>"."<td>".$oferta['dataWyjazdu']."</td>"."<td>".$oferta['nazwa']."</td>"."<td>".$oferta['skad']."<td>".$oferta['dokad'].
				"</td>"."<td>".$oferta['srodekTransportu']."</td>"."<td>".$oferta['rodzaj']."</td>"."</tr>";
				
			}
			$contents =$contents."</table>";
			
			echo  $contents;

			$resultOf->free();
		}

		$connect->close();
	}


?>

</body>
</html>