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
						<a href="zaloguj.php" id="link">Zaloguj</a>
						';
					}
				?>
                <div id="czas"></div>
            </nav>
            <div class="row" style="background-color: #a2f5d8">
                <div class="col">
                    
					

                </div>
            </div>

        </div>
    </body>
</html>