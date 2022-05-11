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
				<h2> Logowanie</h2>
				<br>
				<?php
                function drukuj_form() {
                    ?>
                    
                        <form method="post">
                            <br>
							<br>
							Login:
							<br>
                            <input type="text" name="username" required><br>
							<br>
                            Hasło:
							<br>
                            <input type="password" name="psw" required><br><br>
                            <input type="submit" name="zaloguj">
							<br><br>
							<a href="pomoc.php">Zapomniałem hasła</a>

                        </form>
                        <?php
                    }

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION["user"]) || isset($_SESSION["admin"]) || isset($_SESSION["mod"])) {
                        ?>
							<div id="panel">
							   <?php echo 'Jesteś zalogowany!' ?>
							</div>
                        <?php
                    } else {
                        if (isset($_POST["zaloguj"])) 
						{
                            $conn = new mysqli($host, $db_user, $db_password, $db_name);
                            $conn->set_charset("utf8");
                            if ($conn->connect_error) 
							{
                                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                            }
                            if (!isset($_POST["username"]) || !isset($_POST["psw"])) 
							{
                                echo '<h2>Nie wszystkie pola formularza zostały wypełnione!</h2>';
                                echo '<div class="dottedline"></div>';
                                drukuj_form();
                            } 
							else 
							{
                                $sql = "select * from uzytkownicy where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) 
								{
                                    $_SESSION["user"] = $_POST["username"];
									while ($row = $result->fetch_assoc()) 
									{
										$_SESSION["styl_uczenia"]= $row["styl"];
									}
                                    echo '<h2>Zalogowano użytkownika ' . $_POST["username"] . '</h2>';
									if($_SESSION["styl_uczenia"]=='1')
									{
										header('Location: ankieta.php');
									}
									else
									{
										header('Location: index.php');
									}
                                } 
								else 
								{
									$sql = "select * from administratorzy where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) 
									{
										$_SESSION["admin"] = $_POST["username"];
										$_SESSION["styl_uczenia"]='0';
										echo '<h2>Zalogowano administratora ' . $_POST["username"] . '</h2>';
										header('Location: index.php');
									}
									else
									{
										$sql = "select * from moderatorzy where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
										$result = $conn->query($sql);
										if ($result->num_rows > 0) 
										{
											$_SESSION["mod"] = $_POST["username"];
											$_SESSION["styl_uczenia"]='0';
											echo '<h2>Zalogowano moderatora ' . $_POST["username"] . '</h2>';
											header('Location: index.php');
										}
										else
										{
											echo '<h2>Podano złe dane! Spróbuj ponownie.</h2>';
										}
									}
                                }
                            }
                            $conn->close();
                        }
						else 
						{
                            ?>
                            <span class="bigtitle"> Zalogować się możesz tylko po wcześniejszej rejestracji. </span>
                            <?php
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