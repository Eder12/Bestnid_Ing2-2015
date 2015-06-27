<?php
error_reporting(E_STRICT);
require_once('Connections/best.php');
session_start(); 
mysql_select_db($database_best, $best);
$query_Preguntas = "SELECT * FROM preguntas WHERE idUsuarios = '{$_SESSION['MM_Id']}'";
$Preguntas = mysql_query($query_Preguntas, $best) or die(mysql_error());
$row_Preguntas = mysql_fetch_assoc($Preguntas);
$totalRows_Preguntas = mysql_num_rows($Preguntas);
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Mis preguntas</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<style type="text/css">
<!--
.Estilo1 {color: #0000FF}
.Estilo2 {
	color: #00CCFF;
	font-weight: bold;
}
.Estilo3 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
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
						<h2>Mis preguntas</h2>
						<table width="548" height="175" border="1">
						<?php do { ?>
                          <tr>
                            <td height="44"><p>___________________________________________________________________</p>
                              <p><span class="Estilo3">Titulo:</span> 
                                <?php 
						   $subasta_query = mysql_query("SELECT Titulo FROM subastas WHERE idSubastas = {$row_Preguntas['idSubastas']}");
                           $subasta = mysql_fetch_assoc($subasta_query);?>
                              <a href="DetalleSub.php?id=<?php echo $row_Preguntas['idSubastas']; ?>"> <?php echo $subasta['Titulo']; ?></a></p></td>
                          </tr>
						  <tr>
                            <td height="40"><span class="Estilo1"><strong>Pregunta:</strong></span> <?php echo $row_Preguntas['Pregunta']; ?></td>
                          </tr>
                           <?php if(isset($row_Preguntas['Respuesta'])){?>
						  <tr>						   
                            <td><span class="Estilo2">Respuesta:</span> <?php echo $row_Preguntas['Respuesta']; ?></td>
                          </tr>
						<?php }} while ($row_Preguntas = mysql_fetch_assoc($Preguntas)); ?>
					</table>
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
mysql_free_result($Preguntas);
?>