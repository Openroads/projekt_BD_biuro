<?php
	session_start();
	if(isset($_POST['pesel']))
	{
		//flaga dla walidacji danych
		$flag = true;

		$pesel = $_POST['pesel'];
		if(strlen($pesel) !=11)
		{
			$flag = false;
			$_SESSION['errPesel']="Nieprawidłowa dlugość peselu";
		}
		if(!is_numeric($pesel))
		{
			$flag=false;
			$_SESSION['errPesel']="Nieprawidłowy pesel - tylko liczby";
		}
		if(strlen($_POST['nazwisko'])<2)
		{
			$flag=false;
			$_SESSION['errNazwisko']="Nazwisko jest za krótkie";
		}
		
		if($flag==true)
		{
			require_once "danebazy.php";
			
			try
			{
					$connect = new mysqli($server_adress,$db_user,$db_password,$db_name);
					mysqli_report(MYSQLI_REPORT_STRICT);
					$connect->query('SET NAMES utf8');

					if($connect->errno)
					{
							throw new Exception(mysqli_connect_errno());
					}

					else
					{

						$pesel 		= 	$_POST['pesel'];
						$nazwisko 	= 	$_POST['nazwisko'];

						$klient_query ="SELECT pesel,nazwisko from klient where pesel='$pesel'";
						
						$result = $connect->query($klient_query);

						if($result!=false)
						{
							$klient = $result->fetch_array();
							if($result->num_rows > 0 && $nazwisko ==$klient['nazwisko'])
							{
								//przekieruj na strone zakup php z danymi klienta
								$_SESSION = $_POST;
								header('Location: http://localhost/projekt_BD_biuro/zakup.php');
								//exit;
						
							}else
							{
								$_SESSION['errBledneDane']="Podany pesel lub nazwisko są nie prawidłowe";
							}
							$result->free();
						}else
						{
							throw new Exception($connect->error);
						}

						$connect->close();
					}
			}
			catch(Exception $ex)
			{
				echo "Blad podczas połączenia z serwerem".$ex;
			}
		}
	}

	
?>
<link href="style.css" rel="stylesheet" type="text/css">
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//PL"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>INSANE TRAVEL - ZALOGUJ</title>
    <meta charstet="utf-8"/>
    <meta name="keywords" content="biuro, podrozy" />
    <meta name="description" content="Zarezerwuj wyprawę życia już dziś!" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta name="language" content="PL" />
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
                <li><a href="http://localhost/projekt_BD_biuro/konto.php">ZALOGUJ</a></li>
            </ul>
        </div>
        
        
        
        <div id="new">
            <center>
            <br/>
            <h2>ZALOGUJ</h2>
            <br />
            <div id="new">
        <center>
        <form method="post">
		<br /><h3> Wprowadź swoje dane</h3><br />
	
		Pesel</br>
			<input type="text" value="<?php
				if(isset($_POST['pesel']))
					{
						echo $_POST['pesel'];
					}
			?>" name="pesel" 	size=30>	</br>
			<?php
				if(isset($_SESSION['errPesel']))
					{
						echo '<div class="error">'.$_SESSION['errPesel'].'</div>'."</br>";
						unset($_SESSION['errPesel']);
					}
			?>
	
		Nazwisko </br>
			<input type="text" value="<?php
				if(isset($_POST['nazwisko']))
					{
						echo $_POST['nazwisko'];
					}
			?>" name="nazwisko" 		size=30>	</br>
			<?php
				if(isset($_SESSION['errNazwisko']))
					{
						echo '<div class="error">'.$_SESSION['errNazwisko'].'</div>'."</br>";
						unset($_SESSION['errNazwisko']);
					}
			?>
            <br/>
			<?php
				if(isset($_SESSION['errBledneDane']))
				{
					echo '<div class="error">'.$_SESSION['errBledneDane'].'</div>'."</br>";
					unset($_SESSION['errBledneDane']);
				}
			?>
            <input type="submit" name="zal" value="    Zaloguj    ">	</br><br />
			
            <br/>
        
      </div>
      
      
      
      
        <div id="footer">
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.FACEBOOK.COM/SZYMON.MATYSIK" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>
