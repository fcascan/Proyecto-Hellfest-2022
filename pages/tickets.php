<?php
    //Funcion para generar IDs aleatorios
    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
        ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    //Conexion a base de datos:
    $host = "localhost";
    $user = "root";
    $pass = "";
    $connection = mysqli_connect($host, $user, $pass);
    $dbName = "hellfestdb";  //nombre de la base de datos
    $db = mysqli_select_db($connection, $dbName); //seleccion de la base de datos

    //Obtencion de datos del form:
    $id = random_str(4, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') . random_str(9, '0123456789');   //4 letras mayusculas + 9 numeros
    $name = $_POST["name"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    // $phone = $_POST["phone"];
    $payment = $_POST["payment"];

    //Segun el Submit del fieldset:
    $error1 = "";
    if (isset($_POST["Submit1"])){
        //Fieldset izquierdo, fechas 17, 18, 19 June:
        $quantity = $_POST["quantity1"];
        $passType = $_POST["pass1"];
        $tacs = isset($_POST['tacsToggle1']);
    } else if (isset($_POST["Submit2"])){
        //Fieldset Derecho 23, 24, 25, 26 June:
        $quantity = $_POST["quantity2"];
        $passType = $_POST["pass2"];
        $tacs = isset($_POST['tacsToggle2']);
    } else {
        $error1 = "Error fetching data from forms!";
    }
	
	//Seleccion y Precio de pases:
    if(strcmp($passType, "4-day pass") == 0) {
        $passNum = 4;
        $price = 289;
    } else if (strcmp($passType, "3-day pass") == 0){
        $passNum = 3;
        $price = 215;
    } else {
        $passNum = 1;
        $price = 105;   //1-day pass
    }

    //Insercion de datos a la tabla de usuarios:
    $resultado = false;
    if($tacs == true) {
        $instruccion_SQL = "INSERT INTO tickets (`ID Compra`, `Tipo de Ticket` , `Cantidad de Tickets`, `Monto total en USD`, Nombre, Apellido, `Direccion de Mail`, `Metodo de pago`, `Pases Totales`) 
                        				 VALUES ('$id', '$passType', $quantity, $quantity * $price, '$name', '$fname', '$email', '$payment', $quantity * $passNum)";
   		$resultado = mysqli_query($connection, $instruccion_SQL);
    } else {
		//Generacion de errores:
		$error2 = ""; $error3 = ""; $error4 = ""; $error5 = ""; $error6 = "";
        if(strlen($name) < 1 || strlen($fname) < 1 || strlen($email) < 1) {$error2 = "Do not leave empty fields in the form!\n";};
        if($quantity <= 0) {$error3 = "Invalid number of tickets!\n";};
		if($passType != "4-day pass" && $passType != "3-day pass" && $passType != "1-day pass") {$error4 = "Wrong type of pass selected!\n";};
		if($tacs == false) {$error5 = "You didn't accepted the Terms and Conditions agreement!\n";};
		$errors = $error1 . $error2 . $error3 . $error4 . $error5 . $error6;
	}
    mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Tickets - HellFest 2022</title>
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
			<img src="../img/billets-1400x933.jpg" style="width: 100%;" alt="Billeterie" />
			<br>
			<span class="filledText" style="position: absolute; top: 82%; left: 2%; -webkit-text-stroke-width: 0.5px; -webkit-text-stroke-color: #28282a;">TICKETS</span>
			<br>
		</section>

        <!-------------->
		<!-- RESULT- --->
		<!-------------->
		<section class="formSection">
			<br><br>
			<div>
				<span class="ticketsSpan"><?php if(isset($errors)) echo $errors; ?></span><br>
				<span class="ticketsSpan"><?php echo ($resultado == true)? "Your ticket purchase request has been received successfully! The commercial team will contact you as soon as possible in the next few days." : "Error while creating buying request! Please try again."; ?></span>
			</div>
			<br><br>
            <a class="ticketsSpan" href="./tickets.html" style="font-size: larger; font-weight: bolder;">	← Back to Billetterie Screen.</span><br><br>
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
			<hr />
			<br /><br />
			<div>
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
					Web by fcascan Productions 2022. Made with tons of 🧉 and dedication.
				</span>
			</div>
			<br />
		</footer>
    </body>
</html>
