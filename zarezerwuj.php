<?php
	session_start();
	//czyszczenie session
	if(isset($_SESSION['errPesel'])) unset($_SESSION['errPesel']);
	if(isset($_SESSION['errImie'])) unset($_SESSION['errImie']);
	if(isset($_SESSION['errNazwisko'])) unset($_SESSION['errNazwisko']);
	if(isset($_SESSION['errAdres'])) unset($_SESSION['errAdres']);
	if(isset($_SESSION['errRegulamin'])) unset($_SESSION['errRegulamin']);
?> 
<link href="style.css" rel="stylesheet" type="text/css">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>INSANE TRAVEL</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="main">
        <div id="header">
            <h1>Insane Travel</h1>
        </div>
        <div id="menu">
          <ul>
                <li><a href="http://localhost/projekt_BD_biuro/index.html">Strona GŁÓwna</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/onas.php">O NAS</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/oferty.php">OFERTY</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/terminy.php">TERMINY</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/dane.php">ZAREZERWUJ WYJAZD</a></li>
            <li><a href="http://localhost/projekt_BD_biuro/kontakt.php">KONTAKT</a></li>
            </ul>
        </div>
        <div id="new">
        <center>
<?php
	require_once "danebazy.php";
	 
	 $pesel = $_SESSION['pesel'];
	 
	if (!isset($_POST['wybierz']) && (!isset($_POST['wybierz2']))) {
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		
		$imie 		= $_SESSION['imie'];
		$nazwisko	= $_SESSION['nazwisko'];
		echo "<br/>"."<hname>"."Witaj  ".$imie." ".$nazwisko."</hname>"."<br/>";
		echo "<h2>"."Wybierz termin :"."</h2>"."<br/>";
		$resultOf = $connect->query('Select * from termin');
		if( $resultOf !=false) {
			$contents = "<table>";
				$contents = $contents."<tr>".
			"<td>"."<h3>".'Data Wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Data Powrotu'."</h3>"."</td>".
			"<td>"."<h3>".'Miejsce'."</h3>"."</td>".
			"<td>"."<h3>".'Cena'."</h3>"."</td>".
			"<td>"."<h2>".'Wybierz'."</h2>"."</td>";
			while($termin = $resultOf->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$termin['dataWyjazdu']."</td>"."<td>".$termin['dataPowrotu']."</td>"."<td>".$termin['miejsce']."<td>".$termin['cena'].
					"</td>"."<td>"."<form action = \"zarezerwuj.php\" method= \"POST\"><input type = \"submit\" name=\"wybierz\" value=\"".$termin['numerOferty']."\" label=\"wybierz\"></form>"."</td>"."</tr>";		
			}
			$contents =$contents."</table>"."<br/>"."<br/>";;	
			echo  $contents;
			$resultOf->free();
		}	
		$connect->close();
		
	} else if(isset($_POST['wybierz'])) {
		echo "<br/>"."<h2>"."Wybierz termin :"."</h2>"."<br/>";
		$numerOferty = $_POST['wybierz'];
		$_SESSION['nrOferty'] = $_POST['wybierz'];
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		$resultOf = $connect->query("SELECT * FROM typOferty, nocleg WHERE typOferty.nazwa = nocleg.nazwa and typOferty.numerOferty ='$numerOferty'");
		if( $resultOf !=false) {
			$contents = "<table>";
			$contents = $contents."<tr>".
			"<td>"."<h3>".'Nazwa'."</h3>"."</td>".
			"<td>"."<h3>".'Rodzaj'."</h3>"."</td>".
			"<td>"."<h3>".'Wyżywienie'."</h3>"."</td>".
			"<td>"."<h3>".'Cena'."</h3>"."</td>".
			"<td>"."<h3>".'Adres'."</h3>"."</td>".
			"<td>"."<h2>".'Wybierz'."</h2>"."</td>";
			while($nocleg = $resultOf->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$nocleg['nazwa']."</td>"."<td>".$nocleg['rodzaj']."</td>"."<td>".$nocleg['wyzywienie']."<td>".$nocleg['cena'].
					"</td>"."<td>".$nocleg['adres']."</td>"."<td>"."<form action=\"zarezerwuj.php\" method= \"POST\"><input type = \"submit\" name=\"wybierz2\" value=\"".$nocleg['nazwa']."\"></form>"."</td>"."</tr>";		
			}
			$contents =$contents."</table>";	
			echo  $contents;
			$resultOf->free();
		}
		$connect->close();
		
	}
	if(isset($_SESSION['nrOferty']))
	$numerOferty = $_SESSION['nrOferty'];
	
	if(isset($_POST['wybierz2'])){
		
		$nazwa  = $_POST['wybierz2'];
		global $numerOferty;
		$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
		$result1 = $connect->query("SELECT * FROM nocleg WHERE nazwa= '$nazwa'");
		echo "<br/>"."<h2>"."Wybrałeś: "."</h2>"."<br/>";
		if( $result1 !=false) {
			$contents = "<table>";
			while($nocleg= $result1->fetch_array()) {
				$contents = $contents."<tr>"."<td>".$nocleg['nazwa']."</td>"."<td>".$nocleg['rodzaj']."</td>"."<td>".$nocleg['wyzywienie']."<td>".$nocleg['cena'].
					"</td>"."<td>".$nocleg['adres']."</td>"."</tr>";	
				$_SESSION['nazwa'] = $nocleg['nazwa'];					
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
				$_SESSION['wyjazd'] = $termin['dataWyjazdu'];
			}
		$contents =$contents."</table>";	
			echo  $contents;
			$result2->free();
		}
		
		 echo "<form action=\"zarezerwuj.php\" method= \"POST\"><input type=\"submit\" name=\"Zatwierdź\" value=\"Zatwierdź\"></form>";
		
		$connect->close(); 
	}
		if(isset($_SESSION['wyjazd']))
		$dataWyj = $_SESSION['wyjazd'];
		
		if(isset($_SESSION['nazwa']))
		$nazwaN = $_SESSION['nazwa'];
		
	 if(isset($_POST['Zatwierdź'])){
		 $connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
		$connect->query('SET NAMES utf8');
			 global $numerOferty; global $nazwaN; global $dataWyj; global $pesel;
			 echo "$numerOferty\n"; echo "$nazwaN\n"; echo "$dataWyj\n"; echo "$pesel\n";
			 $result=$connect->query("CALL dokonaj_zakupu('$numerOferty','$nazwaN','$dataWyj','$pesel')");  
			 $connect->close();
			 echo $_POST['pesel'];
			 header("Location: zakup.php");
			 }
			  	
	
	/*wyswietlanie najpierw terminow z ofertami.. po wybraniu terminu (z jedna dostenpna oferta) pojawienie sie dostepnych noclegow dla oferty*/
?>
<br />
<br />
 </center>
</div>

</body>
</html>
          <div class="clearing">&nbsp;</div>

        <div id="footer">
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.painthfolio.wordpress.com" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>
