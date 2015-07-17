<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); 

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

mysql_select_db($database_best, $best);
$query_user = "SELECT * FROM usuarios WHERE idUsuarios = '{$_SESSION['MM_Id']}'";
$user = mysql_query($query_user, $best) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Mis datos</title>
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
						<h2>Mis datos</h2>
					  <table width="313" height="308" border="1">
                          <tr>
                            <td>DNI</td>
                            <td><?php echo $row_user['DNI']; ?></td>
                          </tr>
                          <tr>
                            <td>Nombre</td>
                            <td><?php echo $row_user['Nombre']; ?></td>
                          </tr>
                          <tr>
                            <td>Apellido</td>
                            <td><?php echo $row_user['Apellido']; ?></td>
                          </tr>
                          <tr>
                            <td>Usuario</td>
                            <td><?php echo $row_user['Usuario']; ?></td>
                          </tr>
                          <tr>
                            <td>Fecha de registro </td>
                            <td><?php echo $row_user['Fecha_reg']; ?></td>
                          </tr>
                          <tr>
                            <td>Email</td>
                            <td><?php echo $row_user['Email']; ?></td>
                          </tr>
                          <tr>
                            <td>Telefono</td>
                            <td><?php echo $row_user['Telefono']; ?></td>
                          </tr>
                        </table>
						<a href="modificarMisDatos.php">Editar</a> -						
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
<?php
mysql_free_result($user);
?>

