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
<center> <h2>Dostępne terminy</h2> </center>
 <br />

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
            $i=0;
			$contents = $contents."<tr>".
			"<td>"."<h3>".'Numer'."</h3>"."</td>".
			"<td>"."<h3>".'Data Wyjazdu'."</h3>"."</td>".
			"<td>"."<h3>".'Nazwa'."</h3>"."</td>".
			"<td>"."<h3>".'Skąd'."</h3>"."</td>".
			"<td>"."<h3>".'Dokąd'."</h3>"."</td>".
			"<td>"."<h3>".'Środek Transportu'."</h3>"."</td>".
			"<td>"."<h3>".'Rodzaj'."</h3>"."</td>"."</tr>";
			while($oferta = $resultOf->fetch_array())
			{
                $i=$i+1;
				$contents = $contents."<tr>"."<td>"."$i. "."</td>"."<td>".$oferta['dataWyjazdu']."</td>"."<td>".$oferta['nazwa']."</td>"."<td>".$oferta['skad']."<td>".$oferta['dokad'].
				"</td>"."<td>".$oferta['srodekTransportu']."</td>"."<td>".$oferta['rodzaj']."</td>"."</tr>";
				
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