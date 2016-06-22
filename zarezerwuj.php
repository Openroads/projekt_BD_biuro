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
        
        
        
        
        
        
        
        <div id="new">
        <br /><br /><br />
        <center>
        	<div id="new">
				<?php
                    require_once "danebazy.php";
                     
                     $pesel = $_SESSION['pesel'];
					 $dataWyj;
                     
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
                            "<td>"."<h2>".'numerOferty'."</h2>"."</td>".
							"<td>"."<h2>".'Wybierz'."</h2>"."</td>";
                            while($termin = $resultOf->fetch_array()) {
                                $contents = $contents."<tr>".
								"<td>".$termin['dataWyjazdu']."</td>".
								"<td>".$termin['dataPowrotu']."</td>".
								"<td>".$termin['miejsce']."</td>".
								"<td>".$termin['cena']."</td>".
								"<td>".$termin['numerOferty']."</td>".
								"<td>"."<form action = \"zarezerwuj.php\" method= \"POST\"><input type = \"submit\" name=\"wybierz\" value=\"".$termin['dataWyjazdu']."\" label=\"wybierz\"></form>".
								"</td>"."</tr>";		
                            }
                            $contents =$contents."</table>"."<br/>"."<br/>";;	
                            echo  $contents;
                            $resultOf->free();
                        }	
                        $connect->close();
                        
                    } else if(isset($_POST['wybierz'])) {
                        echo "<br/>"."<h2>"."Wybierz nocleg:"."</h2>"."<br/>";
						global $dataWyj;
                        $dataWyj = $_POST['wybierz'];
                        $_SESSION['dataWyj'] = $_POST['wybierz'];
						$connect2 = new mysqli($server_adress,$db_user,$db_password,$db_name);
                        $connect2->query('SET NAMES utf8');
                        $resultOf2 = $connect2->query("SELECT numerOferty FROM termin WHERE dataWyjazdu='$dataWyj'");
						if($resultOf2 != false){
							while($numery=$resultOf2->fetch_array()){
								$_SESSION['nrOferty']=$numery['numerOferty'];
								}
							}
							
							$numerOferty=$_SESSION['nrOferty'];
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
                                $contents = $contents."<tr>".
								"<td>".$nocleg['nazwa']."</td>".
								"<td>".$nocleg['rodzaj']."</td>".
								"<td>".$nocleg['wyzywienie']."</td>".
								"<td>".$nocleg['cena']."</td>".
								"<td>".$nocleg['adres']."</td>".
								"<td>"."<form action=\"zarezerwuj.php\" method= \"POST\"><input type = \"submit\" name=\"wybierz2\" value=\"".$nocleg['nazwa']."\"></form>".
								"</td>"."</tr>";		
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
                    	$dataWyj=$_SESSION['dataWyj'];
                        $result2 = $connect->query("SELECT * FROM termin WHERE dataWyjazdu= '$dataWyj'");
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
                             $result=$connect->query("CALL dokonaj_zakupu('$numerOferty','$nazwaN','$dataWyj','$pesel')");
                             $connect->close();
			echo "<h2>".'Dokup jeszcze jeden termin lub kliknij Do kasy aby przejść dalej'."</h2>";
			echo "<hlink>"."<br />"."<a href='http://localhost/projekt_BD_biuro/zakup.php' target='_self'>Do Kasy</a>"."</hlink>";			 
                             }   
                ?>
              
              
            <br />
            <br />
            </center>
             <br /><br /><br />
            </div>
           
	</body>
</html>
         <BR />
       </div>
       
       <br />
     <div id="footer"><br /><br />       
        	<center><script type="text/javascript" src="http://100widgets.com/js_data.php?id=255"></script></center>
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.facebook.com/szymon.matysik" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>
