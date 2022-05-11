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
				function drukuj_form(){
				?>
                    <h2>Pytanie Kontrolne</h2>
					<p style="margin-left:25%; width:50%">Do każdego testu przyda się pytanie kontrolne, sprawdzające, czy użytkownik przeczytał kurs. Aby dodać pytanie wpisz jego treść oraz uzupełnij odpowiedzi.
					Zaznaczenie radiobutton obok odpowiedzi oznacza, że wybrana odpowiedź jest poprawna.</p>
					<form action="dodaj_pytanie.php"  method="POST">
						<label for="tytul">Treść pytania:</label><br>
						<input type="text" id="tytul" name="tytul" style=" width:50%"><br>
						<label>Odpowiedzi:</label><br>
						<fieldset id="group1">
							a: <input type="radio" value="a" name="group1" required><input type="text" id="odp1" name="odp1" style=" width:15%">
							b: <input type="radio" value="b" name="group1"><input type="text" id="odp2" name="odp2" style=" width:15%">
							c: <input type="radio" value="c" name="group1"><input type="text" id="odp3" name="odp3" style=" width:15%">
						</fieldset>
						<br>
						<input type="submit" name="dodaj_pytanie" value="wyślij">
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
					if (isset($_POST["dodaj_pytanie"])) 
					{		
						$conn = new mysqli($host, $db_user, $db_password, $db_name);
						$conn->set_charset("utf8");
						if ($conn->connect_error)
						{
							die("Błąd połączenia z bazą danych: " . $conn->connect_error);
						}				
						if(strlen($_POST['tytul'])<3 || strlen($_POST['odp1'])<1 || strlen($_POST['odp2'])<1 || strlen($_POST['odp3'])<1)
						{
							echo '<h6 style="color:red;">Błąd: Tytuł oraz treści odpowiedzi muszą posiadać przynajmniej 3 znaki!</h6>';
							drukuj_form();
						}
						else
						{
							$sql = "insert into pytanietresc values ('".$_SESSION["lekcja"]."','".$_POST["tytul"]."')";
							if ($conn->query($sql) === TRUE) 
							{
								$ans=$_POST['group1'];
								if($ans=='a')
								{
									if ($conn->query("INSERT INTO odpowiedz VALUES ("."NULL,'".$_POST["odp1"]."','1')") === TRUE) 
									{
										$result1 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
										if ($result1->num_rows == 1) 
										{
											while ($row = $result1->fetch_assoc()) 
											{
												$id_odp = $row["id_odpowiedzi"];
											}
											if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp')") === TRUE) 
											{
												if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp2"]."','0')") === TRUE) 
												{
													$result2 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
													if ($result2->num_rows == 1) 
													{
														while ($row = $result2->fetch_assoc()) 
														{
															$id_odp2 = $row["id_odpowiedzi"];
														}
														if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp2')") === TRUE) 
														{
															if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp3"]."','0')") === TRUE) 
															{
																$result3 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
																if ($result3->num_rows == 1) 
																{
																	while ($row = $result3->fetch_assoc()) 
																	{
																		$id_odp3 = $row["id_odpowiedzi"];
																	}
																	if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp3')") === TRUE) 
																	{
																		unset($_SESSION["lekcja"]);
																		header('Location: kursy.php');
																	}
																	else
																	{
																		echo 'błąd przy linkowaniu odpowiedzi';
																	}
																}
															}
														}
														else
														{
															echo 'błąd przy linkowaniu odpowiedzi';
														}
													}
												}
											}
											else
											{
												echo 'błąd przy linkowaniu odpowiedzi';
											}
										}
									}
									else
									{
										echo 'błąd przy dodawaniu odpowiedzi';
									}
								}
								else if($ans=='b')
								{
									if ($conn->query("INSERT INTO odpowiedz VALUES ("."NULL,'".$_POST["odp1"]."','0')") === TRUE) 
									{
										$result1 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
										if ($result1->num_rows == 1) 
										{
											while ($row = $result1->fetch_assoc()) 
											{
												$id_odp = $row["id_odpowiedzi"];
											}
											if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp')") === TRUE) 
											{
												if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp2"]."','1')") === TRUE) 
												{
													$result2 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
													if ($result2->num_rows == 1) 
													{
														while ($row = $result2->fetch_assoc()) 
														{
															$id_odp2 = $row["id_odpowiedzi"];
														}
														if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp2')") === TRUE) 
														{
															if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp3"]."','0')") === TRUE) 
															{
																$result3 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
																if ($result3->num_rows == 1) 
																{
																	while ($row = $result3->fetch_assoc()) 
																	{
																		$id_odp3 = $row["id_odpowiedzi"];
																	}
																	if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp3')") === TRUE) 
																	{
																		unset($_SESSION["lekcja"]);
																		header('Location: kursy.php');
																	}
																	else
																	{
																		echo 'błąd przy linkowaniu odpowiedzi';
																	}
																}
															}
														}
														else
														{
															echo 'błąd przy linkowaniu odpowiedzi';
														}
													}
												}
											}
											else
											{
												echo 'błąd przy linkowaniu odpowiedzi';
											}
										}
									}
									else
									{
										echo 'błąd przy dodawaniu odpowiedzi';
									}
								}
								else if($ans=='c')
								{
									if ($conn->query("INSERT INTO odpowiedz VALUES ("."NULL,'".$_POST["odp1"]."','0')") === TRUE) 
									{
										$result1 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
										if ($result1->num_rows == 1) 
										{
											while ($row = $result1->fetch_assoc()) 
											{
												$id_odp = $row["id_odpowiedzi"];
											}
											if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp')") === TRUE) 
											{
												if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp2"]."','0')") === TRUE) 
												{
													$result2 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
													if ($result2->num_rows == 1) 
													{
														while ($row = $result2->fetch_assoc()) 
														{
															$id_odp2 = $row["id_odpowiedzi"];
														}
														if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp2')") === TRUE) 
														{
															if ($conn->query("insert into odpowiedz values (NULL,'".$_POST["odp3"]."','1')") === TRUE) 
															{
																$result3 = $conn->query("SELECT * FROM odpowiedz ORDER BY id_odpowiedzi DESC LIMIT 1");
																if ($result3->num_rows == 1) 
																{
																	while ($row = $result3->fetch_assoc()) 
																	{
																		$id_odp3 = $row["id_odpowiedzi"];
																	}
																	if ($conn->query("insert into pytaniekontrolne values (NULL,'".$_SESSION["lekcja"]."','$id_odp3')") === TRUE) 
																	{
																		unset($_SESSION["lekcja"]);
																		header('Location: index.php');
																	}
																	else
																	{
																		echo 'błąd przy linkowaniu odpowiedzi';
																	}
																}
															}
														}
														else
														{
															echo 'błąd przy linkowaniu odpowiedzi';
														}
													}
												}
											}
											else
											{
												echo 'błąd przy linkowaniu odpowiedzi';
											}
										}
									}
									else
									{
										echo 'błąd przy dodawaniu odpowiedzi';
									}
								}
								else
								{
									echo 'Jakiś błąd';
								}
								
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
					?>
                </div>
            </div>
           
        </div>
    </body>
</html>