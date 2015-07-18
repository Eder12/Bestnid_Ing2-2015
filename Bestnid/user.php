<?php

error_reporting(E_STRICT);
require_once('Connections/best.php');
session_start();

?><!DOCTYPE html>
<html lang="en">
<head>
<title>Ganador</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>
<body id="page4">
<div class="body1">
    <div class="body2">
      <div class="main">
<!-- header -->
            <header>
                <div class="wrapper">
                    <h1><a href="index.php" id="logo">Bestnid</a></h1>
                    <?php include("includes/busca.php"); ?>
                </div>
                <div class="wrapper">
                <?php include("includes/menu.php"); ?>
                </div>
                <div class="wrapper">
                    <div class="col">
                        <h2>Datos del ganador</h2>
                        <?php
                            $ganadores = mysql_query("SELECT * FROM usuarios WHERE idUsuarios = {$_GET['id']} ");
                            $user = mysql_fetch_assoc($ganadores);
                        ?>
                        <ul>
                            <li>Nombre: <?php echo $user['Nombre'] ?></li>
                            <li>Apellido: <?php echo $user['Apellido'] ?></li>							
                            <li>Correo: <?php echo $user['Email'] ?></li>
							<?php 
							$query_mon = sprintf("SELECT * FROM pujas WHERE idUsuarios = %s", $user['idUsuarios']);
                            $mon = mysql_query($query_mon, $best) or die(mysql_error());
                            $row_mon = mysql_fetch_assoc($mon);
														
							$a= $row_mon['Monto'];											
							$cuenta= $a*70/100;										
							?>							
                            <li>Monto: <?php echo $cuenta; ?></li>
                        </ul>
                    </div>
                </div>
            </header>
<!-- / header -->
<!-- content -->
          <section id="content">
<article class="col2"></article>
          </section>
        </div>
    </div>
</div>
<div class="body3">
    <div class="main">
<!-- / content -->
<!-- footer -->
        <footer>
            <?php include("includes/pie.php"); ?>
            <?php include("includes/nombres.php"); ?>
        </footer>
<!-- / footer -->
  </div>
</div>
</body>
</html>
