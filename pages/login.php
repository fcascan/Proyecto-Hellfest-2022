<?php
    //Conexion a base de datos:
    $host = "localhost";
    $user = "root";
    $pass = "";
    $connection = mysqli_connect($host, $user, $pass);
    $dbName = "hellfestdb";  //nombre de la base de datos
    $db = mysqli_select_db($connection, $dbName); //seleccion de la base de datos

    //Obtencion de datos del form:
    $formEmail = $_POST["email"];
    $formPassword = $_POST["pass"];
    $formRole = $_POST["role"];
    
	//Consultas a la base de datos:
	$errorDB = "";
	$resultado = false; $userFound = false;
    if($db) {
		//Obtencion del usuario de la tabla de usuarios:
		$errorU1 = ""; $errorU2 = "";
		$name = "";	$fname = ""; $mail = ""; $role = "";
        $instruccion_SQL = "SELECT `Direccion de Mail`, Nombre, Apellido, Rol FROM usuarios
                            WHERE `Direccion de Mail` = '$formEmail' AND Password = '$formPassword' AND Rol = '$formRole'";
        $resultado = mysqli_query($connection, $instruccion_SQL);
		if($resultado) {
			$row = mysqli_fetch_assoc($resultado);
			if($row) {
				$name = $row["Nombre"];
				$fname = $row["Apellido"];
				$mail = $row["Direccion de Mail"];
				$role = $row["Rol"];
				$userFound = true;
			} else {
				$errorU1 = "User not found!\n";
			}
			mysqli_free_result($resultado);	//Liberacion de memoria de los resultados obtenidos
		} else {
			$errorU2 = "Error fetching data from server!\n";
		}

		//Obtencion de tickets:
		$errorT1 = ""; $errorT2 = "";
		$typeTicket = "";	$qTickets = ""; $amountTickets = ""; $paymentTickets = ""; $qPases = "";
		$instruccion_SQL = "SELECT `Tipo de Ticket`, `Cantidad de Tickets`, `Monto total en USD`, Nombre, Apellido, `Direccion de Mail`, `Metodo de pago`, `Pases Totales` FROM tickets WHERE `Direccion de Mail` = '$formEmail'";
		$resultado = mysqli_query($connection, $instruccion_SQL);
		if($resultado) {
			$row = mysqli_fetch_assoc($resultado);
			if($row) {
				$typeTicket = $row["Tipo de Ticket"];
				$qTickets = $row["Cantidad de Tickets"];
				$amountTickets = $row["Monto total en USD"];
				$paymentTickets = $row["Metodo de pago"];
				$qPases = $row["Pases Totales"];
			} else {
				$errorT1 = "Didn't found Tickets bought by this user!\n";
			}
			mysqli_free_result($resultado);
		} else {
			$errorT2 = "User not found!\n";	
		}

		//Obtencion de compras en tienda:
		$errorS1 = ""; $errorS2 = "";
		$product = "";	$size = ""; $qShop = ""; $amountShop = ""; $paymenShop = ""; $point = ""; $state = "";
		$instruccion_SQL = "SELECT Producto, Talle, Cantidad, Monto, Nombre, Apellido, `Direccion de mail`,`Metodo de pago`,`Lugar de Retiro`, Estado FROM tienda WHERE `Direccion de Mail` = '$formEmail';";
		$resultado = mysqli_query($connection, $instruccion_SQL);
		if($resultado) {
			$row = mysqli_fetch_assoc($resultado);
			if($row) {
				$product = $row["Producto"];
				$size = $row["Talle"]; if($size == "NULL") {$size = "";}
				$qShop = $row["Cantidad"];
				$amountShop = $row["Monto"];
				$paymenShop = $row["Metodo de pago"];
				$point = $row["Lugar de Retiro"];
				$state = $row["Estado"];
			} else {
				$errorS1 = "No shopping purchases found!\n";
			}
			mysqli_free_result($resultado);
		} else {
			$errorS2 = "User not found!\n";
		}
	} else {
		$errorDB = "Couldn't connect to the database!\n";
    }

    //Solo si es comprador: Obtencion de Compras en tienda: TODO

    //Solo si es un Proveedor: Informacion del servicio prestado: TODO

    //Solo para personal: Realizar consultas

	mysqli_close($connection);	//Cerrar la conexion
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>My Account - HellFest 2022</title>
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
			<a href="./discover.html">EXPERIENCE</a>
			<a href="../index.html#Infos">INFOS</a>
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
		<a href="./tickets.html" title="Buy your tickets now!"><img src="../img/svgexport-25.svg" alt="In Here! Buy your Tickets Now!" style="position: fixed; bottom: 2vh; right: 2vw; z-index: 100;"></a>

		<!-------------------->
		<!-- SECCION TITULO -->
		<!-------------------->
		<section class="titleSection" style="height: 100%;">
			<img src="../img/festival-4.jpg" style="width: 100%;" alt="Billeterie" />
			<br>
			<span class="filledText" style="position: absolute; top: 82%; left: 2%; -webkit-text-stroke-width: 0.5px; -webkit-text-stroke-color: #28282a; font-size: 85px;">LOGIN</span>
			<br>
		</section>
        
        <!------------------------>
		<!-- DESPLIEGUE DE INFO -->
		<!------------------------>
        <section>
            <div class="despliegueLogin" id="despliegueLogin" style="font-size: 18px; color: #28282a;">
				<?php if(!$db || !$userFound) : ?>
					<br><br>
					<h1 class="neufilegroteskDarkSmall"><?php echo $errorDB . $errorU1 . $errorU2; ?></h1><br>
				<?php else : ?>
					<br><br>
					<span class="microgrammaDarkFilled">WELCOME <?php echo strtoupper($name) ?></span><br>
					<div style="width: 75%;">
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall"><?php echo $errorU1 . $errorU2 ?></b></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">User name: </b><?php echo $name ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">User last name: </b><?php echo $fname ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">Email address: </b><?php echo $mail ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">Role: </b><?php echo $role ?></span><br><br><br><br>
					</div>
						<span class="microgrammaDarkFilled">TICKETS</span><br>
					<div style="width: 75%;">
					<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall"><?php echo $errorT1 . $errorT2 ?></b></span><br>
						<span class="neufilegroteskDarkSmall">You have <b class="neufilegroteskDarkSmall"><?php echo $qPases ?></b> passes corresponding to <b class="neufilegroteskDarkSmall"><?php echo $qTickets ?>x "<?php echo $typeTicket ?>"</b>.</span><br>
						<span class="neufilegroteskDarkSmall">The total amount of your purchase is <b class="neufilegroteskDarkSmall">$<?php echo $amountTickets ?></b> in <b class="neufilegroteskDarkSmall"><?php echo $paymentTickets ?></b>.</span><br><br><br><br>
					</div>
					<span class="microgrammaDarkFilled">SHOP</span><br>
					<div style="width: 75%;">
					<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall"><?php echo $errorS1 . $errorS2 ?></b></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">Product name: </b><?php echo $qShop ?>x <?php echo $product ?> <?php echo $size ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">Pickup point: </b><?php echo $point ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">Amount: </b>$<?php echo $amountShop ?> with <?php echo $paymenShop ?></span><br>
						<span class="neufilegroteskDarkSmall"><b class="neufilegroteskDarkSmall">State of purchase: </b><?php echo $state ?></span><br><br><br><br>
					</div>
				<?php endif; ?>
				<!-- 
					SOLO PARA PROVEEDORES:
					Servicio	Fecha de pago acordada	Monto a pagar en USD	Empresa a cargo	Mail Contacto	Persona referente

					SOLO PARA PERSONAL:
					Consultar LINEUP:::  Bandas/Artistas	Horario del Show	Dia del Show	Escenario	Monto a pagar en USD	Hotel de hospedaje	Contacto	Fecha de arribo	Realiza un sideshow?	Equipo adicional necesario
					Consultar Stands:::  Tipo de Stand	Descripcion	Tamaño de Stand	Localizacion en Mapa	Precio alquiler Total
					buscar ticket por ID de compra
					buscar merch por ID de compra
					consultar stock restante y precio de merch por nombre y Talle
				 -->
				<br><br>
				<a class="ticketsSpan" href="./login.html" style="font-size: larger; font-weight: bolder; color: #28282a;">	← Logout and got back to Login Screen.</span><br><br>
            </div>

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
    