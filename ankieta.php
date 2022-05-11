<!DOCTYPE html>
<?php
session_start(); 
require_once "config.php";
?>
<html lang="pl-PL">
    <head>
        <meta charset="UTF-8">
        <title>AISM</title>
        <link rel="Stylesheet" type="text/css" href="style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
        <script src="zegar.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="backimage">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <a href="index.php">
                        <img src="img/logo.png" class="logo" alt="Responsive image"> 
                    </a>
                </div>
            </div>
            <nav class="navbar navbar-light" style="background-color: #bbbbbb; margin-right: -15px; margin-left: -15px">
                <a class="nav-item nav-link active" href="index.php">Strona główna</a>
				<?php
					if((isset($_SESSION['user'])) && ($_SESSION['user']==true))
					{
						echo '
						<a href="kursy.php">Lekcje</a>
						<a href="ustawienia.php">Ustawienia</a>
						<a href="wyloguj.php">Wyloguj</a>	
						';
					}
					else if((isset($_SESSION['admin'])) && ($_SESSION['admin']==true))
					{
						echo '
						<a href="kursy.php">Lekcje</a>
						<a href="dodaj_mod.php">Dodaj moderatora</a>
						<a href="usun_moderatora.php">Moderatorzy</a>
						<a href="usun_uzytkownika.php">Użytkownicy</a>
						<a href="wyloguj.php">Wyloguj</a>
						';
					}
					else if((isset($_SESSION['mod'])) && ($_SESSION['mod']==true))
					{
						echo '
						<a href="dodaj_kurs.php">Dodaj lekcję</a>
						<a href="kursy.php">Moje lekcje</a>
						<a href="wyloguj.php">Wyloguj</a>
						';
					}
					else
					{
						echo '
						<a href="rejestracja.php">Rejestracja</a>	
						<a href="zaloguj.php">Zaloguj</a>
						';
					}
				?>
                <div id="czas"></div>
            </nav>
            <div class="row" style="background-color: #dddddd">
                <div id="col" style="margin-left:15%; text-align:left;">
				<br>
                    <h1 style="text-align:center;">Ankieta nr 1</h1>
					<br>
					<?php
					function drukuj_form(){
					?>
						<form method="POST">
							<p>1. Twoje wspomnienie to:</p>
							<fieldset id="group1">
							  <input type="radio" value="d" name="group1" required> dźwieki albo teledysk do piosenki <br>
							  <input type="radio" value="a" name="group1"> skojarzenie z dotykiem i ruchem <br>
							  <input type="radio" value="b" name="group1"> obrazy i dźwięki, najczęściej ruchome <br>
							</fieldset>
							<br>
							<p>2. Kiedy byłeś dzieciem to:</p>
							<fieldset id="group2">
							  <input type="radio" value="b" name="group2" required>  lubiłeś śpiewać <br>
							  <input type="radio" value="c" name="group2"> uwielbiałeś rysować <br>
							  <input type="radio" value="d" name="group2"> kochałeś skakać i tańczyć <br>
							</fieldset>
							<br>
							<p>3. Kiedy się uczysz, lubisz: </p>
							<fieldset id="group3">
							  <input type="radio" value="b" name="group3" required> czytać na głos podkreślony tekst <br>
							  <input type="radio" value="d" name="group3"> podrzucać coś nogami <br>
							  <input type="radio" value="a" name="group3"> przepisać tekst <br>
							</fieldset>
							<br>
							<p>4. Jak wpływa na Ciebie hałas?</p>
							<fieldset id="group4">
							  <input type="radio" value="d" name="group4" required> wyznacza rytm Twoich ruchów <br>
							  <input type="radio" value="b" name="group4"> przeszkadza Ci w nauce <br>
							  <input type="radio" value="a" name="group4"> nie przeszkadza Ci szczególnie <br> 
							</fieldset>
							<br>
							<p>5. Zrozumienie czegoś przychodzi Ci łatwiej, gdy: </p>
							<fieldset id="group5">
							  <input type="radio" value="a" name="group5" required> sam próbujesz danej rzeczy <br>
							  <input type="radio" value="b" name="group5"> ktoś opowie Ci o problemie <br>
							  <input type="radio" value="c" name="group5"> ktoś pokaże Ci rozwiązanie <br>
							</fieldset>
							<br>
							<p>6. Jak wpływa na Ciebie bałagan?</p>
							<fieldset id="group6">
							  <input type="radio" value="a" name="group6" required> wolisz, gdy go nie ma, jednak nie dezorganizuje ci on pracy <br>
							  <input type="radio" value="d" name="group6"> nie przeszkadza Ci szczególnie <br>
							  <input type="radio" value="b" name="group6"> nie pozwala ci się skupić<br>
							</fieldset>
							<br>
							<p>7. Zazwyczaj na wykładach:</p>
							<fieldset id="group7">
							  <input type="radio" value="a" name="group7" required> bawisz się przyborami i kręcisz na krześle <br>
							  <input type="radio" value="c" name="group7"> notujesz ważniejsze tezy <br>
							  <input type="radio" value="b" name="group7"> słuchasz dokładnie <br>
							</fieldset>
							<br>
							<p>8. Gdy myślisz o dniu wczorajszym, pierwszym skojarzeniem z nim związanym jest:</p>
							<fieldset id="group8">
							  <input type="radio" value="c" name="group8" required> obraz <br>
							  <input type="radio" value="a" name="group8"> wydarzenie <br>
							  <input type="radio" value="d" name="group8"> dźwięk <br>
							</fieldset>
							<br>
							<p>9. Gdy udzielasz rad, mówisz:</p>
							<fieldset id="group9">
							  <input type="radio" value="d" name="group9" required> wysłuchaj dobrych rad <br>
							  <input type="radio" value="c" name="group9"> przyjrzyjmy się temu problemowi <br>
							  <input type="radio" value="a" name="group9"> dotknijmy tego problemu <br>
							</fieldset>
							<br>
							<p>10. Gdy się na czymś skupiasz, przypominasz coś sobie, mówisz:</p>
							<fieldset id="group10">
							  <input type="radio" value="c" name="group10" required> czułem się już tak <br>
							  <input type="radio" value="a" name="group10"> widziałem to gdzieś <br>
							  <input type="radio" value="b" name="group10"> słyszałem już o tym <br>
							</fieldset>
							<br>
							<p>11. Zawsze lubiłeś:</p>
							<fieldset id="group11">
							  <input type="radio" value="a" name="group11" required> używać kolorowych długopisów <br>
							  <input type="radio" value="c" name="group11"> dużo się ruszać, biegać <br>
							  <input type="radio" value="d" name="group11"> słuchać muzyki przy każdej czynności, którą wykonujesz <br>
							</fieldset>
							<br>							
							<p>12. Jedną z twoich ulubionych metod nauki jest:</p>
							<fieldset id="group12">
							  <input type="radio" value="a" name="group12" required> rysowanie map myśli <br>
							  <input type="radio" value="d" name="group12"> opowiadanie historii na głos <br>
							  <input type="radio" value="c" name="group12"> rozwieszanie kolorowych karteczek <br>
							</fieldset>
							<br>
							<p>13. Słysząc o nowym pomyśle:</p>
							<fieldset id="group13">
							  <input type="radio" value="b" name="group13" required> pytasz znajomego czy "plan jest dobry" <br>
							  <input type="radio" value="d" name="group13"> sam rozmyślasz o wprowadzeniu go w życie <br>
							  <input type="radio" value="c" name="group13"> od razu wprowadzasz, aby zobaczyć czy "zda egzamin" <br>
							</fieldset>
							<br>
							<p>14. Gdy nie wiesz jak rozwiązać problem to:</p>
							<fieldset id="group14">
							  <input type="radio" value="b" name="group14" required> prosisz o pomoc znajomego <br>
							  <input type="radio" value="c" name="group14"> starasz się sam rozwiązać problem <br>
							  <input type="radio" value="d" name="group14"> szukasz gotowego rozwiązania <br>
							</fieldset>
							<br>
							<p>15. Rozwiązując działania matematyczne:</p>
							<fieldset id="group15">
							  <input type="radio" value="c" name="group15" required> działania rozwiązujesz w pamięci <br>
							  <input type="radio" value="b" name="group15"> działania rozwiązujesz na kalkulatorze, nawet jeśli są banalnie proste <br>
							  <input type="radio" value="d" name="group15"> działania rozwiązujesz samodzielnie, ewentualnie sprawdzając wynik <br>
							</fieldset>
							<br>							
							<p>16. Przygotowując się do testu:</p>
							<fieldset id="group16">
							  <input type="radio" value="a" name="group16" required> uczysz się z przygotowanych wcześniej materiałów <br>
							  <input type="radio" value="c" name="group16"> przygotowujesz materiały do nauki <br>
							  <input type="radio" value="b" name="group16"> uczysz się słuchając e-booki <br>
							</fieldset>
							<button type="submit" name="wyslij_ankiete">Potwierdź</button>
						  </form>
                    <?php
					}
					if (session_status() == PHP_SESSION_NONE)
					{
						session_start();
					}
					if (isset($_SESSION["user"])) 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
                        $conn->set_charset("utf8");
                        if ($conn->connect_error) 
						{
                            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                        }
						$sql = "select * from uzytkownicy WHERE login='".$_SESSION['user']."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) 
						{
							while ($row = $result->fetch_assoc()) 
							{
								$_SESSION["styl_uczenia"]= $row["styl"];
							}
							$conn->close();
						}
						else
						{
							echo "error";
						}
					}
					else
					{
						$_SESSION["styl_uczenia"]='0';
						if(isset($_SESSION["admin"])) 
						{
							echo "<h3>Jesteś zalogowany jako administrator</h3>";
							echo "<h3>Nie możesz wypełniać ankiety</h3>";
						}
						else if(isset($_SESSION["mod"])) 
						{
							echo "<h3>Jesteś zalogowany jako moderator</h3>";
							echo "<h3>Nie możesz wypełniać ankiety</h3>";
						}
						else
						{
							?>
							<span class="bigtitle"> Błąd dostępu!!!</span>
							<div class="dottedline"></div>
							<div id="panel">
								Musisz się zalogować aby móc wypełnić ankietę!
							</div>
							<?php
						}
					}
						

					if($_SESSION["styl_uczenia"] == '1')
					{
						if (isset($_POST['wyslij_ankiete'])) 
						{
							$ans1=$_POST['group1'];
							$ans2=$_POST['group2'];
							$ans3=$_POST['group3'];
							$ans4=$_POST['group4'];
							$ans5=$_POST['group5'];
							$ans6=$_POST['group6'];
							$ans7=$_POST['group7'];
							$ans8=$_POST['group8'];
							$ans9=$_POST['group9'];
							$ans10=$_POST['group10'];
							$ans11=$_POST['group11'];
							$ans12=$_POST['group12'];
							$ans13=$_POST['group13'];
							$ans14=$_POST['group14'];
							$ans15=$_POST['group15'];
							$ans16=$_POST['group16'];
							$All=$ans1 . $ans2 . $ans3 . $ans4 . $ans5 . $ans6 . $ans7 . $ans8 . $ans9 . $ans10 . $ans11 . $ans12 . $ans13 . $ans14 . $ans15 . $ans16;
							//a - pw (przyswajanie-wzrokowiec)     b - ps (przyswajanie-słuchowiec)    c - dw (działanie-wzrokowiec)     d - ds (działanie-słuchowiec)
							$AllA=substr_count($All, 'a');
							$AllB=substr_count($All, 'b');
							$AllC=substr_count($All, 'c');
							$AllD=substr_count($All, 'd');
							$A=$AllA;
							$B=$AllB;
							$C=$AllC;
							$D=$AllD;
							$ans=array($A,$B,$C,$D);
							$max=max($ans);
							if($max==$A)
							{
								$conn = new mysqli($host, $db_user, $db_password, $db_name);
								$conn->set_charset("utf8");
								if ($conn->connect_error) {
									die("Błąd połączenia z bazą danych: " . $conn->connect_error);
								}
								$sql="UPDATE uzytkownicy SET styl='2' WHERE login='".$_SESSION['user']."'";
								if ($conn->query($sql) === TRUE) 
								{
									$_SESSION["styl_uczenia"]='2';
									echo '<h2>Zostałeś zakwalifikowany jako "przyswajanie-wzrokowiec"<h2>';
									echo '<div class="dottedline"></div>';
								}
								else 
								{
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
							if($max==$B)
							{
								$conn = new mysqli($host, $db_user, $db_password, $db_name);
								$conn->set_charset("utf8");
								if ($conn->connect_error) {
									die("Błąd połączenia z bazą danych: " . $conn->connect_error);
								}
								$sql="UPDATE uzytkownicy SET styl='3' WHERE login='".$_SESSION['user']."'";
								if ($conn->query($sql) === TRUE) 
								{
									$_SESSION["styl_uczenia"]='3';
									echo '<h2>Zostałeś zakwalifikowany jako "przyswajanie-słuchowiec"<h2>';
									echo '<div class="dottedline"></div>';
								}
								else 
								{
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
							if($max==$C)
							{
								$conn = new mysqli($host, $db_user, $db_password, $db_name);
								$conn->set_charset("utf8");
								if ($conn->connect_error) {
									die("Błąd połączenia z bazą danych: " . $conn->connect_error);
								}
								$sql="UPDATE uzytkownicy SET styl='4' WHERE login='".$_SESSION['user']."'";
								if ($conn->query($sql) === TRUE) 
								{
									$_SESSION["styl_uczenia"]='4';
									echo '<h2>Zostałeś zakwalifikowany jako "działanie-wzrokowiec"<h2>';
									echo '<div class="dottedline"></div>';
								}
								else 
								{
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
							if($max==$D)
							{
								$conn = new mysqli($host, $db_user, $db_password, $db_name);
								$conn->set_charset("utf8");
								if ($conn->connect_error) {
									die("Błąd połączenia z bazą danych: " . $conn->connect_error);
								}
								$sql="UPDATE uzytkownicy SET styl='5' WHERE login='".$_SESSION['user']."'";
								if ($conn->query($sql) === TRUE) 
								{
									$_SESSION["styl_uczenia"]='5';
									echo '<h2>Zostałeś zakwalifikowany jako "działanie-słuchowiec"<h2>';
									echo '<div class="dottedline"></div>';
								}
								else 
								{
									echo "Error: " . $sql . "<br>" . $conn->error;
								}
							}
							$conn->close();
						}
						else
						{
							drukuj_form();
						}
                    } 
					else 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
                        $conn->set_charset("utf8");
                        if ($conn->connect_error) 
						{
                            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                        }
						$sql = "select * from style WHERE styl='".$_SESSION['styl_uczenia']."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) 
							{
								echo '<h2>Zostałeś zakwalifikowany jako '. $row["nazwa"] .'<h2>';
								echo '<div class="dottedline"></div>';
							}
						} else {
							if (isset($_SESSION["user"])) 
							{
								echo "<h3>Coś się popsuło</h3>";
							}
						}
						unset($_SESSION["styl_uczenia"]);
						$conn->close();
					}
                    ?> 
					
				</div>
            </div>
            <div class="row">
                <div class="card-body" style="background-color: #bbbbbb">
                    <blockquote class="blockquote mb-0">
                        <footer class="blockquote-footer" style="background-color: #bbbbbb; color: black">
                             Kulesza Dominik, Sawicki Damian & Zimnowodzki Igor Copyright &copy; 2019
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </body>
</html>