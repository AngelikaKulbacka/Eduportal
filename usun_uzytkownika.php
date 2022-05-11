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
                <?php
                if (isset($_SESSION["admin"])) 
				{
                    $conn = new mysqli($host, $db_user, $db_password, $db_name);
                    $conn->set_charset("utf8");
                    if ($conn->connect_error)
					{
                        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                    }
                    $sql = "select * from uzytkownicy";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo '<table class="tablica" align="center">
						    <tr>
						        <th>Login</th><th>Email</th><th> </th><th>Usuń</th>
						    </tr>
						';
						while ($row = $result->fetch_assoc()) {
							
							echo '<tr>'
							. '<td>' . $row["login"] . '</td>'
							. '<td>' . $row["email"] . '</td>'
							. '<td> </td>'
							. '<td><form method="post"><button type="submit" value="' . $row["id_uzytkownika"] . '" name="usun" ><strong>Usuń</strong></button></form></td>'
							. '</tr>';
							
						}
						echo '</tbody></table>';

                    } else {
                        echo "<h3>Na razie nie ma użytkowników</h3>";
                    }
                    if (isset($_POST["usun"])) {
                        $sql = "delete from uzytkownicy where id_uzytkownika = " . $_POST["usun"];
                        if ($conn->query($sql) === TRUE) {
                            header("Refresh:0");
                        }
                    }
                    $conn->close();
                } else {
                    ?>
                    <span class="bigtitle"> Błąd dostępu </span>
                    <div class="dottedline"></div>
                    <div id="panel">
                        Musisz zalogować się jako administrator!
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