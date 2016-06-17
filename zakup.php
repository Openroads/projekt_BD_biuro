<?php
	session_start();
	if(isset($_SESSION['nrOferty'])) unset($_SESSION['nrOferty']);
	if(isset($_SESSION['nazwa'])) unset($_SESSION['nazwa']);
	if(isset($_SESSION['wyjazd'])) unset($_SESSION['wyjazd']);
	if(isset($_SESSION['imie'])) unset($_SESSION['imie']);
	if(isset($_SESSION['nazwisko'])) unset($_SESSION['nazwisko']);
		
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
        </center>  
       <br />
<center> <h2>Twoje konto</h2> </center>
 <br />

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
			"<td>"."<h3>".'PESEL'."</h3>"."</td>".
			"<td>"."<h3>".'Suma'."</h3>"."</td>".
			"<td>"."<h3>".'Data wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Data powrotu'."</h3>"."</td>".
			"<td>"."<h3>".'Miejsce wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Cena '."</h3>"."</td>".
			"<td>"."<h3>".'Nazwa Oferty'."</h3>"."</td>".
			"<td>"."<h3>".'Skad'."</h3>"."</td>".
			"<td>"."<h3>".'Dokad'."</h3>"."</td>"."</tr>";
			while($zakupKlient = $resultOfKlient->fetch_array())
			{
				$contents = $contents."<tr>"."<td>".$zakupKlient['imie']."</td>"."<td>".$zakupKlient['nazwisko']."</td>"."<td>".$zakupKlient['pesel']."</td>"."<td>".$zakupKlient['suma']."</td>";
				//."</tr>";
				
				$nrZakupu = $zakupKlient['numerZakupu'];

				$zakupTerminQuery = "SELECT * from zakupTermin join termin on zakupTermin.dataWyjazdu = termin.dataWyjazdu where zakupTermin.numerZakupu = '$nrZakupu'";
				
				$resultOfTermin = $connect->query($zakupTerminQuery);
				if( $resultOfTermin !=false)
				{
				
					if($zakupTermin = $resultOfTermin->fetch_array())
					{
						$contents = $contents."<td>".$zakupTermin['dataWyjazdu']."</td>"."<td>".$zakupTermin['dataPowrotu']."</td>"."<td>".$zakupTermin['miejsce']."</td>"."<td>".$zakupTermin['cena']."</td>";
						$nrOferty =$zakupTermin['numerOferty'];
						echo $nrOferty;
						$ofertaQuery = "SELECT * from oferta where oferta.numerOferty = '$nrOferty'";
						$resultOfOferta = $connect->query($ofertaQuery);
						if($resultOfOferta !=false)
						{
							if($zakupionaOferta = $resultOfOferta->fetch_array())
							{
								$contents = $contents."<td>".$zakupionaOferta['nazwa']."</td>"."<td>".$zakupionaOferta['skad']."</td>"."<td>".$zakupionaOferta['dokad']."</td>"."</tr>";
							}
						}else{
						echo"error";
						}
					}
					
				}
				
				
				
			}
			$contents =$contents."</table>";
			
			echo  $contents;

			$resultOfKlient->free();
			$resultOfTermin->free();
			$resultOfOferta->free();
		}

		$connect->close();
	}


?><br />
<br  />
<div class="clearing">&nbsp;</div>
      </div>
        <div id="footer">
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.painthfolio.wordpress.com" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>