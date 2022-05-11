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
				    <h2> Rejestracja</h2>
					<br>
					<?php
					function drukuj_form(){
					?>
                        <form method="post">
                            Login:<br>
                            <input type="text" name="username" required><br><br>
                            Hasło:<br>
                            <input type="password" name="psw" required><br><br>
                            Potwierdź Hasło:<br>
                            <input type="password" name="psw1" required><br><br>
                            Adres  email:<br>
                            <input type="email" name="mail" required><br><br>
                            <input type="submit" name="rejestruj"><br>
                        </form>
                    <?php
					}
					if (session_status() == PHP_SESSION_NONE){
						session_start();
					}
					if (isset($_SESSION["user"])) {
                    ?>
						<span class="bigtitle"> Błąd dostępu </span>
						<div class="dottedline"></div>
						<div id="panel">
							Musisz wylogować się przez zakładaniem nowego konta!
						</div>
                    <?php
					} 
					else 
					{
						if (isset($_POST["rejestruj"])) 
						{
							$conn = new mysqli($host, $db_user, $db_password, $db_name);
							$conn->set_charset("utf8");
							if ($conn->connect_error) {
								die("Błąd połączenia z bazą danych: " . $conn->connect_error);
							}
							if (!isset($_POST["username"]) || !isset($_POST["psw"]) || !isset($_POST["psw1"]) || !isset($_POST["mail"])) {
								echo '<h2>Nie wszystkie pola formularza zostały wypełnione!</h2>';
								echo '<div class="dottedline"></div>';
								drukuj_form();
							} else {
								$sql = "select * from uzytkownicy where login = '" . $_POST["username"] . "'";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									echo '<h2>Login musi być unikalny!</h2>';
									echo '<div class="dottedline"></div>';
									drukuj_form();
								} else {
									if ($_POST["psw"] !== $_POST["psw1"]) {
										echo '<h2>Wprowadzone hasła są różne!</h2>';
										echo '<div class="dottedline"></div>';
										drukuj_form();
									} else {
										$sql = "insert into uzytkownicy values ("."NULL,'".$_POST["username"]."','".hash('sha256', $_POST["psw"])."','".$_POST["mail"]."','1')";
												
										if ($conn->query($sql) === TRUE) {
											echo "<h2>Użytkownik został zarejestrowany. Proszę zalogować się </h2>";
											echo '<div class="dottedline"></div>';
										} else {
											echo "Error: " . $sql . "<br>" . $conn->error;
										}
									}
								}
							}
							$conn->close();
						} 
						else 
						{
							drukuj_form();
							
						}
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