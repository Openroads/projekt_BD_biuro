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
			$_SESSION['errPesel']="Nieprawidłowa wartosc peselu";
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

								$insert_client ="INSERT INTO klient VALUES ('{$_POST["Pesel"]}','{$_POST["Imie"]}','{$_POST["Nazwisko"]}','{$_POST["Adres"]}')";
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

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>Wprowadź dane</title>
		<style>
		.error
		{
			color:red;
			margin: 5px;
		}
		</style>
</head>
<body>

	<form method="post">
	<h3> Wprowadz swoje dane						</h3>
	
	Pesel 		</br>
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
	
	Imie 		</br>
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

	Nazwisko	</br>
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

	Adres 		</br>
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


	<input type="checkbox" name="Regulamin"/> <a href="regulamin.pdf" download> Akceptuje regulamin </a></br>
	<?php
	if(isset($_SESSION['errRegulamin']))
	{
		echo '<div class="error">'.$_SESSION['errRegulamin'].'</div>'."</br>";
		unset($_SESSION['errRegulamin']);
	}
	?>

	<input type="submit" name="dod" value="Dalej">	</br>
	
	</form>


</body>
</html>