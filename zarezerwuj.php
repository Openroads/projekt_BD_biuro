<?php
	session_start();
	//czyszczenie session
	if(isset($_SESSION['errPesel'])) unset($_SESSION['errPesel']);
	if(isset($_SESSION['errImie'])) unset($_SESSION['errImie']);
	if(isset($_SESSION['errNazwisko'])) unset($_SESSION['errNazwisko']);
	if(isset($_SESSION['errAdres'])) unset($_SESSION['errAdres']);
	if(isset($_SESSION['errRegulamin'])) unset($_SESSION['errRegulamin']);
?> 
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Zarezerwuj wyjazd !</title>
</head>
<body>

<?php
	require_once "danebazy.php";
	$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
	$connect->query('SET NAMES utf8');
	
	$pesel 		= $_SESSION['pesel'];
	$imie 		= $_SESSION['imie'];
	$nazwisko	= $_SESSION['nazwisko'];


	echo "<p>"."Witaj  ".$imie." ".$nazwisko."</p>";
	echo "<h5>"."Wybierz termin :"."</h5>" 

	/*wyswietlanie najpierw terminow z ofertami.. po wybraniu terminu (z jedna dostenpna oferta) pojawienie sie dostepnych noclegow dla oferty*/
?>

</body>
</html>