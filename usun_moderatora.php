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
                <?php
                if (isset($_SESSION["admin"])) 
				{
                    $conn = new mysqli($host, $db_user, $db_password, $db_name);
                    $conn->set_charset("utf8");
                    if ($conn->connect_error)
					{
                        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                    }
                    $sql = "select * from moderatorzy";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) 
					{
                        echo '<table class="tablica" align="center">
						    <tr>
						        <th>Login</th><th></th><th>Usuń</th>
						    </tr>
						';
						while ($row = $result->fetch_assoc()) {
							
							echo '<tr>'
							. '<td>' . $row["login"] . '</td>'
							. '<td> </td>'
							. '<td><form method="post"><button type="submit" value="' . $row["id_moderatora"] . '" name="usun" ><strong>Usuń</strong></button></form></td>'
							. '</tr>';
							
						}
						echo '</tbody></table>';

                    } 
					else 
					{
                        echo "<h3>Na razie nie ma użytkowników</h3>";
                    }
                    if (isset($_POST["usun"])) {
                        $sql = "delete from moderatorzy where id_moderatora = " . $_POST["usun"];
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
                        Musisz zalogować jako administrator!
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            
        </div>
    </body>
</html>