<link href="style.css" rel="stylesheet" type="text/css">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Through The Woods - Free Alpha Studio Web Template</title>
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
                <li><a href="#">Strona GŁÓwna</a></li>
                <li><a href="#">O NAS</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/oferty.php">OFERTY</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/terminy.php">TERMINY</a></li>
                <li><a href="http://localhost/projekt_BD_biuro/dane.php">ZAREZERWUJ WYJAZD</a></li>
            <li><a href="#">KONTAKT</a></li>
            </ul>
        </div>
        <div id="new">
        <center>
          
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
</center>
<div class="clearing">&nbsp;</div>
      </div>
        <div id="footer">
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.painthfolio.wordpress.com" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>
