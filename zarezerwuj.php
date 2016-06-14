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
	 
	if (!isset($_GET['wybierz'])) {
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		$pesel 		= $_SESSION['pesel'];
		$imie 		= $_SESSION['imie'];
		$nazwisko	= $_SESSION['nazwisko'];
		echo "<p>"."Witaj  ".$imie." ".$nazwisko."</p>";
		echo "<h5>"."Wybierz termin :"."</h5>" ;
		$resultOf = $connect->query('Select * from termin');
		if( $resultOf !=false) {
			$contents = "<table>";
			while($termin = $resultOf->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$termin['dataWyjazdu']."</td>"."<td>".$termin['dataPowrotu']."</td>"."<td>".$termin['miejsce']."<td>".$termin['cena'].
					"</td>"."<td>".$termin['numerOferty']."</td>"."<td>"."<form action = \"zarezerwuj.php\" method= \"get\"><input type = \"submit\" name=\"wybierz\" value=\"".$termin['numerOferty']."\"></form>"."</td>"."</tr>";		
			}
			$contents =$contents."</table>";	
			echo  $contents;
			$resultOf->free();
		}	
		$connect->close();
		
	} else {
		
		$numerOferty = $_GET['wybierz'];
		$_SESSION['nrOferty'] = $_GET['wybierz'];
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		$resultOf = $connect->query("SELECT * FROM typOferty, nocleg WHERE typOferty.nazwa = nocleg.nazwa and typOferty.numerOferty ='$numerOferty'");
		if( $resultOf !=false) {
			$contents = "<table>";
			while($nocleg = $resultOf->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$nocleg['nazwa']."</td>"."<td>".$nocleg['rodzaj']."</td>"."<td>".$nocleg['wyzywienie']."<td>".$nocleg['cena'].
					"</td>"."<td>".$nocleg['adres']."</td>"."<td>"."<form action=\"zarezerwuj.php\" method= \"get\"><input type = \"submit\" name=\"wybierz2\" value=\"".$nocleg['nazwa']."\"></form>"."</td>"."</tr>";		
			}
			$contents =$contents."</table>";	
			echo  $contents;
			$resultOf->free();
		}
		$connect->close();
		
	}
	
	if(isset($_GET['wybierz2'])){
		
		
		$nazwa  = $_GET['wybierz2'];
		$_SESSION['nazwa'];
		$_SESSION['wyjazd'];
		$numerOferty = $_SESSION['nrOferty'];
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		$result1 = $connect->query("SELECT * FROM nocleg WHERE nazwa= '$nazwa'");
		echo "<h5>"."Wybrales: "."</h5>" ;
		if( $result1 !=false) {
			$contents = "<table>";
			while($nocleg= $result1->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$nocleg['nazwa']."</td>"."<td>".$nocleg['rodzaj']."</td>"."<td>".$nocleg['wyzywienie']."<td>".$nocleg['cena'].
					"</td>"."<td>".$nocleg['adres']."</td>"."</tr>";	
				$_SESSION['nazwa'] += $nocleg['nazwa'];					
			}
		$contents =$contents."</table>";	
			echo  $contents;
			$result1->free();
		
		}
		
		$result2 = $connect->query("SELECT * FROM termin WHERE numerOferty= '$numerOferty'");
		if( $result2 !=false) {
			$contents = "<table>";
			while($termin= $result2->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$termin['dataWyjazdu']."</td>"."<td>".$termin['dataPowrotu']."</td>"."<td>".$termin['miejsce']."<td>".$termin['cena'].
					"</td>"."<td>".$termin['numerOferty']."</td>"."</tr>";	
				$_SESSION['wyjazd'] += $termin['dataWyjazdu'];
			}
		$contents =$contents."</table>";	
			echo  $contents;
			$result2->free();
		}
		
		 echo "<form action=\"zarezerwuj.php\" method= \"get\"><input type=\"submit\" name=\"zatwierdz\" value=\"zatwierdz\"></form>";
		 if(isset($_GET['zatwierdz']))
			/* $result=$connect->query("CALL dokonaj_zakupu('$numerOferty','$_SESSION['nazwa']','$_SESSION['wyjazd']','$_SESSION['pesel']')"); WYRZUCA BLAD*/ 
		$connect->close(); 
	}
	//echo $numerOferty;
	
	/*wyswietlanie najpierw terminow z ofertami.. po wybraniu terminu (z jedna dostenpna oferta) pojawienie sie dostepnych noclegow dla oferty*/
?>
</body>
</html>
