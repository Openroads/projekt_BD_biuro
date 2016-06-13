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
		$oferty_query ="SELECT * from oferta";
		
		$result = $connect->query($oferty_query);

		if($result!=false)
		{
			$contents = "<table>";
			while($oferta = $result->fetch_array())
			{
				$contents = $contents."<tr>"."<td>".$oferta['nazwa']."</td>"."<td>".$oferta['skad']."<td>".$oferta['dokad'].
				"</td>"."<td>".$oferta['srodekTransportu']."</td>"."<td>".$oferta['rodzaj']."</td>"."</tr>";


				/*echo "<table><tr>".$oferta['nazwa']."Z ".
				$oferta['skad']."	Do ".$oferta['dokad']."Srodek transportu ".$oferta['srodekTransportu']."Rodzaj oferty ".$oferta['rodzaj']."</table>";*/
			}
			$contents =$contents."</table>";
			
			echo  $contents;

			$result->free();
		}

		$connect->close();
	}


?>

</body>
</html>