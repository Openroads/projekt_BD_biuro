<link href="style.css" rel="stylesheet" type="text/css">
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Transitional//PL"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>INSANE TRAVEL - OFERTY</title>
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
        <br />
             <h2>Dostępne oferty</h2>
             <br />
             <div id="new">
             <br /><br />
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
                        
                        $i=0;
                        $contents = $contents."<tr>"."<td>"."<center>"."<h3>".'  Numer  '."</h3>"."</center>"."</td>".
                        "<td>"."<center>"."<h3>".'  Nazwa  '."</h3>"."</center>"."</td>".
                        "<td>"."<center>"."<h3>".'  Skąd  '."</h3>"."</center>"."</td>".
                        "<td>"."<center>"."<h3>".'  Dokąd  '."</h3>"."</center>"."</td>".
                        "<td>"."<center>"."<h3>".'  Środek Transportu  '."</h3>"."</center>"."</td>".
                        "<td>"."<center>"."<h3>".'  Rodzaj  '."</h3>"."</center>"."</td>"."</tr>";
                        while($oferta = $result->fetch_array())
                        {
                            $i=$i+1;
                            $contents = $contents."<tr>"."<td>"."<center>"."$i."."</center>"."</td>"."<td>".$oferta['nazwa']."</td>"."<td>".$oferta['skad']."<td>".$oferta['dokad'].
                            "</td>"."<td>".$oferta['srodekTransportu']."</td>"."<td>".$oferta['rodzaj']."</td>"."</tr>";
            
                        /*echo "<table><tr>".$oferta['nazwa']."Z ".
                            $oferta['skad']."	Do ".$oferta['dokad']."Srodek transportu ".$oferta['srodekTransportu']."Rodzaj oferty ".$oferta['rodzaj']."			                </table>";*/
                    }
                        $contents =$contents."</table>";		
                        echo  $contents;
                        $result->free();
                    }
                    $connect->close();
                }
            ?>
            <br />
            <br />
         	<h2>dowiedz się więcej...</h2>
      		<table>
            <br/><br/><tr><td>
            <a href="swiat.php"><img src="images/swiat.jpg"></a> </td><td>     
            <a href="karaiby.php"><img src="images/karaiby.jpg"></a></td><td>   
            <a href="kongo.php"><img src="images/kongo.jpg"></a></td></tr>
            </table>
            <table>
            <br/><br/><tr><td>
            <a href="wlochy.php"><img src="images/wlochy.jpg"></a></td><td>
            <a href="korea.php"><img src="images/korea.jpg"></a></td><td>
            <a href="kanion.php"><img src="images/kanion.jpg"></a></td></tr>
            </table>
               </center>
        <div id="footer">
            <p>Copyright &copy; GMMSZ, designed by <a href="http://www.facebook.com/szymon.matysik" target="_blank">PAINTHING</a></p>
        </div>
    </div>
</body>
</html>
