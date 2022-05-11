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
				function drukuj_form(){
				?>
                    <h2>Dodawanie materiałów</h2>
					<p style="margin-left:25%; width:50%">Do każdego kursu poza treścią przydały by się także jakieś materiały, na przykład w formie plików PDF, z których użytkownik mógłby się uczyć.
					Pamiętaj aby podpisać co zostanie zlinkowanie w materiałach oraz aby wybrać odpowiedni plik. Aby dodać więcej materiałów do lekcji wypełnij ponownie formularz.</p>
					<form enctype="multipart/form-data" action="dodaj_link.php"  method="POST">
						<label for="tytul">Tytuł:</label>
							<input type="text" id="tytul" name="tytul" style=" width:50%">
						<br>
						<input type="hidden" name="MAX_FILE_SIZE" value="500000000" /> 
						<input name="plik" type="file" />
						<br>
						<input type="submit" name="dodaj_link" value="wyślij">
						<br>
						<br>
					</form>
					<div style="position: relative; left:20%;">
						<a href="dodaj_pytanie.php"><input type="button" value="Dodaj pytanie kontrolne" name="pytanie" ></a>
					</div>
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
						if (isset($_POST["dodaj_link"])) 
						{	
							$plik_tmp=$_FILES['plik']['tmp_name'];
							if(file_exists($_FILES['plik']['tmp_name']))
							{
								$plik_nazwa = rand(1, 10000).$_FILES['plik']['name'];
							}
							else
							{
								$plik_nazwa=$_FILES['plik']['name'];
							}
							if(empty($_FILES['plik']))
							{	
								echo 'brak pliku';
							}
							else
							{
								if(strlen($_POST['tytul'])<3)
								{
									echo '<h6 style="color:red;">Błąd: Tytuł musi posiadać przynajmniej 3 znaki!</h6>';
									drukuj_form();
								}
								else
								{
									$sql = "SELECT * FROM lekcja ORDER BY id_lekcji DESC LIMIT 1";
									$result = $conn->query($sql);
									if ($result->num_rows == 1) 
									{
										while ($row = $result->fetch_assoc()) 
										{
											$_SESSION["lekcja"] = $row["id_lekcji"];
										}
										$sql2 = "INSERT INTO linki VALUES (NULL,'".$_POST["tytul"]."','$plik_nazwa')";
										if ($conn->query($sql2) === TRUE) 
										{
											$sql3 = "SELECT * FROM linki ORDER BY id_linku DESC LIMIT 1";
											$result3 = $conn->query($sql3);
											if ($result3->num_rows == 1) 
											{
												while ($row = $result3->fetch_assoc()) 
												{
													$v_id_linku = $row["id_linku"];
												}
												$sql4 = "INSERT INTO lekcjalink VALUES (NULL,'".$_SESSION["lekcja"]."','$v_id_linku')";
												if ($conn->query($sql4) === TRUE) 
												{
													if(is_uploaded_file($plik_tmp))
													{
														move_uploaded_file($plik_tmp, "linki/$plik_nazwa");
														echo 'Wrzucono! Wypełnij formularz ponownie aby dodać więcej materiałów do lekcji';
														$conn->close();
														drukuj_form();
													}
													else
													{
														$conn->close();
														echo 'nima pliku';
													}
												}
												else
												{
													$conn->close();
													echo 'nie linkuje';
												}
											}
										} 
										else 
										{
											$conn->close();
											echo "Błąd dodawania materiałów!!!";
										}
									}
									else
									{
										echo "Błąd odczytu z bazy danych!";
									}
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
						$conn->close();
						echo "Coś się popsuło i nie było mnie słychać!!!";
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