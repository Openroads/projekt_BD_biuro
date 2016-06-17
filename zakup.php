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
		$resultOf = $connect->query($zakupKlientQuery);

		if( $resultOf !=false)
		{
			$contents = "<table>";
			$contents = $contents."<tr>".
			"<td>"."<h3>".'Imię'."</h3>"."</td>".
			"<td>"."<h3>".'Nazwisko'."</h3>"."</td>".
			"<td>"."<h3>".'PESEL'."</h3>"."</td>".
			"<td>"."<h3>".'Suma'."</h3>"."</td>"."</td>";
			while($zakupKlient = $resultOf->fetch_array())
			{
				$contents = $contents."<tr>"."<td>".$zakupKlient['imie']."</td>"."<td>".$zakupKlient['nazwisko']."</td>"."<td>".$zakupKlient['pesel']."</td>".$zakupKlient['suma']."</td>"."</tr>";
				
			}
			$contents =$contents."</table>";
			
			echo  $contents;

			$resultOf->free();
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