<?php
    //Conexion a base de datos:
    $host = "localhost";
    $user = "root";
    $pass = "";
    $connection = mysqli_connect($host, $user, $pass);
    $dbName = "hellfestdb";  //nombre de la base de datos
    $db = mysqli_select_db($connection, $dbName); //seleccion de la base de datos

    //Obtencion de datos del form:
    $id = random_int(0, PHP_INT_MAX);   //20 digitos en 64bits
    $name = $_POST["name"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $passRepeat = $_POST["passRepeat"];
    $role = $_POST["role"];
    
	//Insercion de datos a la tabla de usuarios:
	$resultado = false;
    if($password == $passRepeat) {
        $instruccion_SQL = "INSERT INTO usuarios (`ID User`, Password, `Direccion de Mail`, Nombre, Apellido, Rol) 
                        				  VALUES ($id, '$password', '$email', '$name', '$fname', '$role')";
   		$resultado = mysqli_query($connection, $instruccion_SQL);
    } else {
		//Generacion de errores:
		$error1 = ""; $error2 = ""; $error3 = ""; $error4 = ""; $error5 = "";
		if($connection == false) {$error1 = "Couldn't connect to server!\n";};
		if($db == false) {$error2 = "Couldn't connect to the database!\n";};
		if(strlen($name) < 1 || strlen($fname) < 1 || strlen($email) < 1) {$error3 = "Do not leave empty fields in the form!\n";};
		if($password != $passRepeat) {$error4 = "Passwords mismatch!\n";};
		if(strlen($password) < 6 || strlen($password) > 16) {$error5 = "Password must contain between 6 and 16 alphanumeric characters!\n";};
		$errors = $error1 . $error2 . $error3 . $error4 . $error5;
	}
	mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Registration - HellFest 2022</title>
		<link rel="stylesheet" href="../css/estilos.css" />
	</head>
	<body>
        <!------------> 
		<!-- NAVBAR -->
		<!------------>
		<div class="navbarDiv">
			<a href="../index.html">
				<img
					class="hellfestLogoImg"
					src="../img/svgexport-2.svg"
					alt="logo"
					style="width: 100px; height: 100px"
					title="Home"
					href="../index.html"
				/>
			</a>
			<div></div>
			<div></div>
			<div></div>
			<a href="./lineup.html">LINE UP</a>
			<a href="#Experience">EXPERIENCE</a>
			<a href="#Infos">INFOS</a>
			<!-- <a href="#hamburguer" class="hamIcon"><img src="../img/svgexport-3.svg"/></a> -->
			<input id="hamburguer-toggle" type="checkbox" />
    		<label class='hamburguer-button-container' for="hamburguer-toggle">
				<img src="../img/svgexport-3.svg"/>
   	 			<div class='hamburguer-button'></div>
			</label>
			<ul class="hamburguer">
				<li class="hamLi"><a class="filledText" href="./lineup.html">LINE UP</a></li>
				<li class="hamLi"><a class="filledText" href="./experience.html">EXPERIENCE</a></li>
				<li class="hamLi"><a class="filledText" href="./faq.html">FAQ</a></li>
				<li class="hamLi"><a class="filledText" href="https://www.hellfest.fr/en/news">NEWS</a></li>
				<li class="hamLi"><a class="filledText" href="./login.html">LOGIN</a></li>
				<li class="hamLi"></li>
			</ul>
			<div></div>
		</div>

		<!-------------------->
		<!-- SECCION TITULO -->
		<!-------------------->
		<section class="titleSection" style="height: 100%;">
			<img src="../img/festival-4.jpg" style="width: 100%;" alt="Billeterie" />
			<br>
			<span class="filledText" style="position: absolute; top: 82%; left: 2%; -webkit-text-stroke-width: 0.5px; -webkit-text-stroke-color: #28282a; font-size: 85px;">REGISTER</span>
			<br>
		</section>

        <!-------------->
		<!-- RESULT- --->
		<!-------------->
		<section class="formSection">
			<br><br>
			<div>
				<span class="ticketsSpan"><?php if(isset($errors)) echo $errors; ?></span><br>
				<span class="ticketsSpan"><?php echo ($resultado == true)? "User created succesfully! Now try to login." : "Error while creating new user! Please try again."; ?></span>
			</div>
			<br><br>
            <a class="ticketsSpan" href="./login.html" style="font-size: larger; font-weight: bolder;">	← Back to Login Screen.</span><br><br>
            <a class="ticketsSpan" href="./register.html" style="font-size: larger; font-weight: bolder;">	← Back to Register Screen.</span><br><br>
        </section>

        <!------------>
		<!-- FOOTER -->
		<!------------>
		<footer>
			<br /><br />
			<div class="sponsorsDiv">
				<img src="../img/7b5bfc.webp" class="sponsorImg" alt="Weezevent" />
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<img src="../img/f92e58.webp" class="sponsorImg" alt="Arte Concert" />
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<img src="../img/258426.webp" class="sponsorImg" alt="Zégut Radio" />
				<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				<img src="../img/1b2e8b.webp" class="sponsorImg" alt="Crédit Mutuel" />
			</div>
			<br /><br />
			<div class="neufilegroteskSmall">
				<a href="mailto:info@hellfest.fr">Contact</a>
				<span
					>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span
				>
				<a href="./tac.html">Term and conditions</a>
				<span
					>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span
				>
				<a href="./partners.html">Partners</a>
			</div>
			<br />
			<div>
				<span class="saludoFooter">
					Web by <a href="https://github.com/fcascan"><b>fcascan</b></a> Productions 2022. Made with tons of 🧉 and dedication.
				</span>
			</div>
			<br />
		</footer>
    </body>
</html>
