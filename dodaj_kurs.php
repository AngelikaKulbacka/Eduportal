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
                    <a href="index.php"  id="link">
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
						<a href="zaloguj.php" id="link">Zaloguj</a>
						';
					}
				?>
                <div id="czas"></div>
            </nav>
            <div class="row" style="background-color: #a2f5d8">
                <div class="col">
				<?php
				function drukuj_form(){
				?>
                    <h2>Dodawanie lekcji</h2>
					<form enctype="multipart/form-data" method="POST">
						<label for="typy">Wybierz styl:</label>
						<select name="wybrany_styl">
							<option select value="2">przyswajanie-wzrokowiec</option>
							<option value="3">przyswajanie-słuchowiec</option>
							<option value="4">działanie-wzrokowiec</option>
							<option value="5">działanie-słuchowiec</option>
						</select>
						<br>
						<label for="tytul">Tytuł:</label>
							<input type="text" id="tytul" name="tytul" style=" width:50%">
						<br>
						<label for="tresc">Tresć:</label>
							<textarea id="tresc" rows="10" name="tresc" style=" width:50%"></textarea>
						<br>
						<input type="submit" name="dodaj_kurs" value="wyślij">
						<br>
						<br>
					</form>
				<?php
				}
				if (session_status() == PHP_SESSION_NONE)
				{
					session_start();
				}
				if (isset($_SESSION["user"]) || isset($_SESSION["admin"])) 
				{
					?>
						<span class="bigtitle"> Błąd dostępu </span>
						<div class="dottedline"></div>
						<div id="panel">
							Brak uprawnień aby dodawać lekcje!
						</div>
                    <?php
				}
				else if(isset($_SESSION["mod"]))
				{
					$conn = new mysqli($host, $db_user, $db_password, $db_name);
					$conn->set_charset("utf8");
					if ($conn->connect_error)
					{
						die("Błąd połączenia z bazą danych: " . $conn->connect_error);
					}
					$sql = "SELECT id_moderatora FROM moderatorzy WHERE moderatorzy.login='".$_SESSION["mod"]."'";
					$result = $conn->query($sql);
					if ($result->num_rows > 0) 
					{
						while ($row = $result->fetch_assoc()) 
						{
							$_SESSION["mod_id"]=$row["id_moderatora"];
						}
						if (isset($_POST["dodaj_kurs"])) 
						{						
							if(strlen($_POST['tytul'])<3 || strlen($_POST['tresc'])<3)
							{
								echo '<h6 style="color:red;">Błąd: Tytuł oraz treść muszą posiadać przynajmniej 3 znaki!</h6>';
								drukuj_form();
							}
							else
							{
								$sql = "insert into lekcja values ("."NULL,'".$_SESSION["mod_id"]."','".$_POST["tytul"]."','".$_POST["tresc"]."','".$_POST["wybrany_styl"]."')";
								if ($conn->query($sql) === TRUE) 
								{
									header('Location: dodaj_link.php');
								} 
								else 
								{
									echo "Coś się popsuło!!!";
								}
							}
						}
						else
						{
							drukuj_form();
						}
					}
					else
					{
						echo "Coś się popsuło i nie było mnie słychać!!!";
					}
				}
					?>
                </div>
            </div>
           
        </div>
    </body>
</html>