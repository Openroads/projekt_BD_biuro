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
		if(strlen($_POST['imie'])<2)
		{
			$flag=false;
			$_SESSION['errImie']="Imie jest za krótkie";
		}
		if(strlen($_POST['nazwisko'])<2)
		{
			$flag=false;
			$_SESSION['errNazwisko']="Nazwisko jest za krótkie";
		}
		if(strlen($_POST['adres'])<2)
		{
			$flag=false;
			$_SESSION['errAdres']="Adres jest za krótki";
		}
		if(!isset($_POST['Regulamin']))
		{
			$flag=false;
			$_SESSION['errRegulamin'] = "Zatwierdzenie regulaminu jest obowiązkowe";
		}


		if($flag ==true )
		{

			//sprawdzenie czy uzytkownik o takim peselu jest w bazie 
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
						$imie 		=  	$_POST['imie'];
						$nazwisko 	= 	$_POST['nazwisko'];
						$adres 		= 	$_POST['adres'];

						$klient_query ="SELECT * from klient where pesel='$pesel'";
						
						$result = $connect->query($klient_query);

						if($result!=false)
						{
							$klient = $result->fetch_array();
							if($result->num_rows > 0 && $imie ==$klient['imie'] && $nazwisko ==$klient['nazwisko'] && $adres==$klient['adres'])
							{
								//przekieruj na strone zarezerwuj php z danymi klienta
								$_SESSION = $_POST;
								header('Location: http://localhost/projekt_BD_biuro/zarezerwuj.php');
								//exit;
						
							}else if($result->num_rows==0)
							{

								$insert_client ="INSERT INTO klient VALUES ('{$_POST["pesel"]}','{$_POST["imie"]}','{$_POST["nazwisko"]}','{$_POST["adres"]}')";
								if($connect->query($insert_client))
								{
										////przekieruj na strone zarezerwuj php z danymi klienta
									$_SESSION = $_POST;
								header('Location: http://localhost/projekt_BD_biuro/zarezerwuj.php');
								//exit;
								}
								else
								{
									throw new Exception($connect->error);
								}
								
							}//sytuacja gdy dane wprowadzone nie pasuja do peselu ktory jest juz w bazie danych
							else
							{
								$_SESSION['errPesel']="Uzytkownik o takim peselu juz istnieje- sprawdz czy dane sa poprawne";
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
    <title>INSANE TRAVEL - ZAREZERWUJ</title>
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
        
        
        
        <div id="new"><br />
        <center><br /><h3> Wprowadź swoje dane</h3><br/></center>
        
                <div id="new">
                <center>
                <form method="post">
                
            
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
            
                Imię </br>
                    <input type="text" value="<?php
                        if(isset($_POST['imie']))
                            {
                                echo $_POST['imie'];
                            }
                    ?>" name="imie" 		size=30>	</br>
                    <?php
                        if(isset($_SESSION['errImie']))
                            {
                                echo '<div class="error">'.$_SESSION['errImie'].'</div>'."</br>";
                                unset($_SESSION['errImie']);
                            }
                    ?>
        
                Nazwisko</br>
                    <input type="text" value="<?php
                        if(isset($_POST['nazwisko']))
                            {
                                echo $_POST['nazwisko'];
                            }
                    ?>" name="nazwisko" 	size=30>	</br>
                    <?php
                        if(isset($_SESSION['errNazwisko']))
                            {
                                echo '<div class="error">'.$_SESSION['errNazwisko'].'</div>'."</br>";
                                unset($_SESSION['errNazwisko']);
                            }
                    ?>
        
                    Adres</br>
                    <input type="text" value="<?php
                        if(isset($_POST['adres']))
                            {
                                echo $_POST['adres'];
                            }
                    ?>" name="adres" 	size=30>	</br>
                    <?php
                        if(isset($_SESSION['errAdres']))
                            {
                                echo '<div class="error">'.$_SESSION['errAdres'].'</div>'."</br>";
                                unset($_SESSION['errAdres']);
                            }
                    ?>
        
        <br/>
        
        
                <input type="checkbox" name="Regulamin"/> <a href="regulamin.pdf" download>Akceptuję regulamin</a></br>
                    <?php
                        if(isset($_SESSION['errRegulamin']))
                            {
                                echo '<div class="error">'.$_SESSION['errRegulamin'].'</div>'."</br>";
                                unset($_SESSION['errRegulamin']);
                            }
                    ?>
        <br/> 
        
         
                <input type="submit" name="dod" value="   Dalej    ">	</br><br />
                </form>
                </center>
		</div>	
<br />
<br />
<br />
</div>
<br />



     <div id="footer"><br /><br />       
        	<center><script type="text/javascript" src="http://100widgets.com/js_data.php?id=255"></script></center>
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.facebook.com/szymon.matysik" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>


	