<!DOCTYPE html>
<?php
session_start(); 
require_once "config.php";
$_SESSION['kurs']=$_POST['kurs'];
?>
<html lang="pl-PL">
    <head>
        <meta charset="UTF-8">
        <title>AISM</title>
		<link rel="Stylesheet" type="text/css" href="style.css" />
        <link rel="Stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
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
						if($_SESSION["styl_uczenia"]=='1')
						{
							header('Location: ankieta.php');
						}
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
                <div class="col">
					<?php
					if (isset($_SESSION["user"]) || isset($_SESSION["admin"]) || isset($_SESSION["mod"])) 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
						$conn->set_charset("utf8");
						if ($conn->connect_error)
						{
							die("Błąd połączenia z bazą danych: " . $conn->connect_error);
						}										
						$sql = "select * from lekcja WHERE id_lekcji='".$_SESSION["kurs"]."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) 
						{
							while ($row = $result->fetch_assoc()) 
							{
								
								echo '
								<br><br>
								<h2>'. $row["tytul"].'</h2>
								<br><br>
								<p>'. $row["tresc"].'</p>
								<br><br>
								<div style="margin-left:20%; text-align:left;">
									<h3>Materiały:</h3>';
									
								
							}
							$sql2 = "select * from linki INNER JOIN lekcjalink WHERE linki.id_linku=lekcjalink.id_linku AND lekcjalink.id_lekcji='".$_SESSION["kurs"]."'";
							$result2 = $conn->query($sql2);
							if ($result2->num_rows > 0) 
							{
								while ($row = $result2->fetch_assoc()) 
								{
									$pliczeq=$row['link'];
									$rozszerzenie = explode ( '.' , $pliczeq );
									if ($rozszerzenie[1] == "mp4" || $rozszerzenie[1] == "mpeg" || $rozszerzenie[1] == "avi" || $rozszerzenie[1] == "wmv")
									{
										?>
										<div class="embed-responsive embed-responsive-16by9" style="width:50%">
											<video width="192" height="240" controls>
												<source  src="linki/<?php echo $row['link'];?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
												<a href="coinmarketcap.mp4">Pobierz plik</a>
											</video>
										</div>
										<br>
										<br>
										<?php
									}
									else if($rozszerzenie[1]=='pdf')
									{
										echo '
										<br>
										<h6>'.$row['tytul'].'
										<a href="linki/'.$row['link'].'" target="_blank">Otwórz</a>
										</h6>
										<br>
										';
									}
								}
							}
							else
							{
								echo'Brak materiałów';
							}
							echo '
							</div>
							<div style="height:20px; size:1px; border-top: 1px solid #A9A9A9";></div>
							';
							//pytanie kontrolne
							if ($result3 = $conn->query("SELECT * FROM pytanietresc WHERE id_lekcji='".$_SESSION["kurs"]."'")) 
							{
								if ($result3->num_rows > 0) 
								{
									while ($row = $result3->fetch_assoc()) 
									{
									echo '
									<h2>'.$row['tresc'].'</h2><br>
									';
									}
									echo '<form action="test.php" method="POST">
									<fieldset id="group">';
									if ($result4 = $conn->query("SELECT * FROM pytaniekontrolne INNER JOIN odpowiedz WHERE pytaniekontrolne.id_lekcji='".$_SESSION["kurs"]."' and pytaniekontrolne.id_odpowiedzi=odpowiedz.id_odpowiedzi")) 
									{
										while ($row = $result4->fetch_assoc()) 
										{
											if ($result4->num_rows > 0) 
											{
												echo '<input type="radio" value="'.$row['czy_poprawna'].'" name="group" required>'.$row['odpowiedz'].'';
											}
										}
										echo '</fieldset>';
										if(isset($_SESSION["admin"]) || isset($_SESSION["mod"]))
										{
											
										}
										else
										{
											echo '<button type="submit" value="odpowiedz" name="odpowiedz"><strong>Odpowiedz</strong></button><br>';
										}
										echo '</form>';
										
									}
									else
									{
										echo 'Nie mozna odczytać';
									}
								}
							}
							else
							{
								echo 'Nie mozna odczytać';
							}
							
						} 
						else 
						{
							echo "<h3>Nie znaleziono w bazie danych</h3>";
						}
						$conn->close();
					} else {
						?>
						<span class="bigtitle"> Błąd dostępu </span>
						<div class="dottedline"></div>
						<div id="panel">
							
						</div>
						<?php
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