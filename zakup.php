<?php
	session_start();
	if(isset($_SESSION['nrOferty'])) unset($_SESSION['nrOferty']);
	if(isset($_SESSION['nazwa'])) unset($_SESSION['nazwa']);
	if(isset($_SESSION['wyjazd'])) unset($_SESSION['wyjazd']);
	if(isset($_SESSION['imie'])) unset($_SESSION['imie']);
	if(isset($_SESSION['nazwisko'])) unset($_SESSION['nazwisko']);
		
?>
<link href="style.css" rel="stylesheet" type="text/css">
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//PL"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>INSANE TRAVEL - KONTO</title>
    <meta charstet="utf-8"/>
    <meta name="keywords" content="biuro, podrozy" />
    <meta name="description" content="Zarezerwuj wyprawę życia już dziś!" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="language" content="PL" />
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="main">
    <div id="language"><center><script type="text/javascript" src="http://100widgets.com/js_data.php?id=142"></script></center></div>
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
                <li><a href="http://localhost/projekt_BD_biuro/konto.php">ZALOGUJ</a></li>
            </ul>
        </div>
        
        
        
        
        <div id="new">
        	</center>  
       		<br/>
			<center> <h2>Twoje konto</h2> </center>
 			<br/>
				<div id="new">
                <br /><br />

<?php
	require_once "danebazy.php";
	$pesel = $_SESSION['pesel'];
	$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
	$connect->query('SET NAMES utf8');
	if($connect->errno)
	{
		echo $connect->connect_errno;
	}
	else{
		$zakupKlientQuery = "SELECT * from klient join zakup on zakup.pesel = klient.pesel where klient.pesel = '$pesel'";
		$resultOfKlient = $connect->query($zakupKlientQuery);
		
		if( $resultOfKlient !=false)
		{
			$contents = "<table>";
			$contents = $contents."<tr>".
			"<td>"."<h3>".'Imię'."</h3>"."</td>".
			"<td>"."<h3>".'Nazwisko'."</h3>"."</td>".
			"<td>"."<h3>".'PESEL'."</h3>"."</td>"."</tr>";

			if($zakupKlient=$resultOfKlient->fetch_array())
			{
				$contents = $contents."<tr>"."<td>".$zakupKlient['imie']."</td>"."<td>".$zakupKlient['nazwisko']."</td>"."<td>".$zakupKlient['pesel']."</td>"."<tr>"."</table>"."</br>"."</br>";
			}


			$contents=$contents."<table>"."<tr>"."<td>"."<h3>".'Suma'."</h3>"."</td>".
			"<td>"."<h3>".'Data wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Data powrotu'."</h3>"."</td>".
			"<td>"."<h3>".'Miejsce wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Cena terminu'."</h3>"."</td>".
			"<td>"."<h3>".'Nazwa Oferty'."</h3>"."</td>".
			"<td>"."<h3>".'Skad'."</h3>"."</td>".
			"<td>"."<h3>".'Dokad'."</h3>"."</td>".
			"<td>"."<h3>".'Srodek Transportu'."</h3>"."</td>".
			"<td>"."<h3>".'Nazwa noclegu'."</h3>"."</td>".
			"<td>"."<h3>".'Rodzaj'."</h3>"."</td>".
			"<td>"."<h3>".'Cena noclegu'."</h3>"."</td>"."</tr>";
			do
			{
				$contents=$contents."<td>".$zakupKlient['suma']." zł"."</td>";
				
				$nrZakupu = $zakupKlient['numerZakupu'];
				$zakupTerminQuery = "SELECT * from zakupTermin join termin on zakupTermin.dataWyjazdu = termin.dataWyjazdu where zakupTermin.numerZakupu = '$nrZakupu'";
				
				$resultOfTermin = $connect->query($zakupTerminQuery);
				if( $resultOfTermin !=false)
				{
				
					if($zakupTermin = $resultOfTermin->fetch_array())
					{
						$dataWyjazdu = $zakupTermin['dataWyjazdu'];
						//$contents = $contents."<td>".$dataWyjazdu;
						
						if($dataWyjazdu > date("Y-m-d"))
						{
								 $contents=$contents."<td>"."<font color='green'>$dataWyjazdu</font>"."</br>"."<form method='post'> <input type='submit' name='anuluj' value='Anuluj' /></form>";
								 
						}
						else
						{
							 $contents=$contents."<td>"."<font color='red'>$dataWyjazdu</font>"."</br>"."Odbyla sie";
						}
						
						$contents=$contents."</td>"."<td>".$zakupTermin['dataPowrotu']."</td>".
						"<td>".$zakupTermin['miejsce']."</td>".
						"<td>".$zakupTermin['cena']." zł"."</td>";
						$nrOferty =$zakupTermin['numerOferty'];
						$ofertaQuery = "SELECT * from oferta where oferta.numerOferty = '$nrOferty'";
						$resultOfOferta = $connect->query($ofertaQuery);
						if($resultOfOferta !=false)
						{
							if($zakupionaOferta = $resultOfOferta->fetch_array())
							{
								$contents = $contents."<td>".$zakupionaOferta['nazwa']."</td>".
								"<td>".$zakupionaOferta['skad']."</td>".
								"<td>".$zakupionaOferta['dokad']."</td>".
								"<td>".$zakupionaOferta['srodekTransportu']."</td>";
							}
						}else{
						echo"error";
						}
					}
				
				}

				$zakupTypOfertyQuery="SELECT nocleg.nazwa,nocleg.rodzaj,nocleg.cena from zakupTypOferty join nocleg on zakupTypOferty.nazwa=nocleg.nazwa where zakupTypOferty.numerZakupu = '$nrZakupu'";

				$resultOfNocleg=$connect->query($zakupTypOfertyQuery); 

				if($resultOfNocleg !=false)
				{
				
					if($zakupNocleg = $resultOfNocleg->fetch_array())
					{
						$contents=$contents."<td>".$zakupNocleg['nazwa']."</td>".
						"<td>".$zakupNocleg['rodzaj']."</td>".
						"<td>".$zakupNocleg['cena']." zł"."</td>"."</tr>";
					}
				}
				
				
				
			}while($zakupKlient = $resultOfKlient->fetch_array());

			$contents =$contents."</table>";
			
			echo  "<center>".$contents."</center>";
			$resultOfKlient->free();
			$resultOfTermin->free();
			$resultOfOferta->free();
			$resultOfNocleg->free();
		}
		$connect->close();
	}
?>
<br/>
<br/>
</div>
</div>
<br />



     <div id="footer"><br /><br />       
        	<center><script type="text/javascript" src="http://100widgets.com/js_data.php?id=255"></script></center>
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.facebook.com/szymon.matysik" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>