<?php require_once('Connections/best.php'); 
error_reporting(E_STRICT);
session_start();
mysql_select_db($database_best, $best);
$query_Preguntas = "SELECT * FROM preguntas";
$Preguntas = mysql_query($query_Preguntas, $best) or die(mysql_error());
$row_Preguntas = mysql_fetch_assoc($Preguntas);
$totalRows_Preguntas = mysql_num_rows($Preguntas);


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Preguntar</title>
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
						<h2>Preguntar</h2>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
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
