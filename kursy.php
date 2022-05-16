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
                    <a href="index.php" id="link">
                        <img src="img/logo.png" class="logo" alt="Responsive image"> 
                    </a>
                </div>
            </div>
            <nav class="navbar navbar-light" style="background-color: #44c99b; margin-right: -15px; margin-left: -15px">
                <a class="nav-item nav-link active" href="index.php" id="link">Strona główna</a>
				<?php
					if((isset($_SESSION['user'])) && ($_SESSION['user']==true))
					{
						if($_SESSION["styl_uczenia"]=='1')
						{
							header('Location: ankieta.php');
						}
						echo '
						<a href="kursy.php" id="link">Lekcje</a>
						<a href="ustawienia.php" id="link">Ustawienia</a>
						<a href="wyloguj.php" id="link">Wyloguj</a>	
						';
					}
					else if((isset($_SESSION['admin'])) && ($_SESSION['admin']==true))
					{
						echo '
						<a href="kursy.php" id="link">Lekcje</a>
						<a href="dodaj_mod.php" id="link">Dodaj moderatora</a>
						<a href="usun_moderatora.php" id="link">Moderatorzy</a>
						<a href="usun_uzytkownika.php" id="link">Użytkownicy</a>
						<a href="wyloguj.php" id="link">Wyloguj</a>
						';
					}
					else if((isset($_SESSION['mod'])) && ($_SESSION['mod']==true))
					{
						echo '
						<a href="dodaj_kurs.php" id="link">Dodaj lekcję</a>
						<a href="kursy.php" id="link">Moje lekcje</a>
						<a href="wyloguj.php" id="link">Wyloguj</a>
						';
					}
					else
					{
						echo '
						<a href="rejestracja.php" id="link">Rejestracja</a>	
						<a href="zaloguj.php id="link"Zaloguj</a>
						';
					}
				?>
                <div id="czas"></div>
            </nav>
            <div class="row" style="background-color: #a2f5d8; height:100%;">
                <div id="col" style="margin-left:15%; text-align:left;">
					<?php
					if(isset($_SESSION["user"])) 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
						$conn->set_charset("utf8");
						if ($conn->connect_error)
						{
							die("Błąd połączenia z bazą danych: " . $conn->connect_error);
						}
						$sql = "select * from lekcja WHERE styl='". $_SESSION["styl_uczenia"] ."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) 
						{
							echo '<br><h2>Lekcje wybrane dla Ciebie:<h2><br>';
							while ($row = $result->fetch_assoc()) {
								
								echo '
								<form action="kurs.php" method="POST">
									<button type="submit" value="'.$row["id_lekcji"].'" name="kurs" style="border: none; margin: 0; padding: 0; width: auto; overflow: visible; color: blue; font-size: 24px;">
									<strong>'. $row["tytul"].'</strong>
									</button>
								</form>
								<br>
								<div style="height:20px; size:1px; border-top: 1px solid #A9A9A9";></div>
								';
							}
						}
						else 
						{
							echo "<h3>Brak kursów</h3>";
						}
						$conn->close();
					}
					else if(isset($_SESSION["admin"]) || isset($_SESSION["admin"])) 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
						$conn->set_charset("utf8");
						if ($conn->connect_error)
						{
							die("Błąd połączenia z bazą danych: " . $conn->connect_error);
						}
						$sql = "select * from lekcja";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) 
						{
							echo '<br><h2>Wszystkie lekcje:<h2><br>';
							while ($row = $result->fetch_assoc()) {
								
								echo '
								<form action="kurs.php" method="POST">
									<button type="submit" value="'.$row["id_lekcji"].'" name="kurs" style="border: none; margin: 0; padding: 0; width: auto; overflow: visible; color: blue; font-size: 24px;">
									<strong>'. $row["tytul"].'</strong>
									</button>
								</form>
								<form method="POST">
									<button type="submit" value="'.$row["id_lekcji"].'" name="usun" style="margin-top:5px; margin-bottom:10px;">
									<strong>Usuń</strong>
									</button>
								</form>
								<div style="height:10px; size:1px; border-top: 1px solid #A9A9A9";></div>
								';
							}	
						}
						else 
						{
							echo "<h3>Brak kursów</h3>";
						}
						if (isset($_POST["usun"])) 
							{
								$sql = "delete from lekcja where id_lekcji=".$_POST["usun"];
								if ($conn->query($sql) === TRUE) 
								{
									header("Refresh:0");
								}
							}
						$conn->close();
					}
					else if(isset($_SESSION["mod"]) || isset($_SESSION["mod"])) 
					{
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
						$conn->set_charset("utf8");
						if ($conn->connect_error)
						{
							die("Błąd połączenia z bazą danych: " . $conn->connect_error);
						}
						$sql = "SELECT * FROM lekcja INNER JOIN moderatorzy WHERE lekcja.id_moderatora=moderatorzy.id_moderatora AND moderatorzy.login='".$_SESSION["mod"]."'";
						$result = $conn->query($sql);
						if ($result->num_rows > 0) 
						{
							echo '<br><h2>Twoje lekcje:<h2><br>';
							while ($row = $result->fetch_assoc()) {
								
								echo '
								<form action="kurs.php" method="POST">
									<button type="submit" value="'.$row["id_lekcji"].'" name="kurs" style="border: none; margin: 0; padding: 0; width: auto; overflow: visible; color: blue; font-size: 24px;">
									<strong>'. $row["tytul"].'</strong>
									</button>
								</form>
								
								<form method="POST">
									<button type="submit" value="'.$row["id_lekcji"].'" name="usun" style="margin-top:5px; margin-bottom:10px;">
									<strong>Usuń</strong>
									</button>
								</form>
								<div style="height:20px; size:1px; border-top: 1px solid #A9A9A9";></div>
								';
								//<form method="POST">
								//	<button type="submit" value="'.$row["id_lekcji"].'" name="edytuj" style="margin-top:5px; margin-bottom:5px;">
								//	<strong>Edytuj</strong>
								//	</button>
								//</form>
							}	
						}
						else 
						{
							echo "<h3>Brak kursów</h3>";
						}
						if (isset($_POST["usun"])) 
						{
							if ($conn->query("delete from pytanietresc where id_lekcji='".$_POST["usun"]."'"))
							{
								//echo ' usunieto tresc <br>';
							}
							else{
								//echo 'nie moszna usunać treści pytania';
							}
							$result = $conn->query("SELECT * FROM odpowiedz INNER JOIN pytaniekontrolne WHERE odpowiedz.id_odpowiedzi=pytaniekontrolne.id_odpowiedzi AND pytaniekontrolne.id_lekcji='".$_POST["usun"]."'");
							if ($conn->query("delete from pytaniekontrolne where id_lekcji='".$_POST["usun"]."'"))
							{
								//echo ' usunieto link pytania z lekcją <br>';
							}
							if ($result->num_rows > 0) 
							{
								while ($row = $result->fetch_assoc()) 
								{
									$sql = "delete from odpowiedz where id_odpowiedzi='".$row["id_odpowiedzi"]."'";
									if ($conn->query($sql))
									{
										//echo'usunieto odpowiedzi';
									}
									else
									{
										//echo 'nie moszna usunać treści odpowiedzi';
									}
								}
							}
							else
							{
								//echo 'nie moszna usunać treści pytania kontrolnego';
							}
								
							$result2 = $conn->query("SELECT * FROM lekcjalink INNER JOIN linki WHERE lekcjalink.id_linku=linki.id_linku AND lekcjalink.id_lekcji='".$_POST["usun"]."'");
							if ($conn->query("delete from lekcjalink where id_lekcji=".$_POST["usun"])) 
							{
								//echo ' usunieto linkowanie lekcji z materiałami <br>';
							}
							if ($result2->num_rows > 0) 
							{
								while ($row = $result2->fetch_assoc()) 
								{
									unlink('linki/'.$row['link']);
									$sql = "delete from linki where id_linku='".$row["id_linku"]."'";
									if ($conn->query($sql))
									{
										//echo'usunieto materialy';
										
									}else{
										//echo'Nie moszna usunąć linku';
									}
								}
							}
							if ($conn->query("delete from lekcja where id_lekcji=".$_POST["usun"])) 
							{
								//echo ' usunieto lekcję <br>';
								
							}else{
								//echo 'nie moszna usunać lekcji';
							}
							$conn->close();
							header("Refresh:0");
						}
						
						$conn->close();
					}
					else 
					{
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
           
        </div>
    </body>
</html>