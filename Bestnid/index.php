<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Inicio</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>
<body id="page1">
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
						<h2>Bienvenidos a Bestnid sitio de subastas </h2>
						<p class="pad_bot1"> Bestnid es considerado una subasta, pero un tanto particular. En Bestnid el bien subastado no se adjudica al postor que m&aacute;s dinero haya ofrecido por &eacute;l, sino por lo que cada postor comunica por qu&eacute; necesita dicho producto, y el subastador eligira lo necesita mas. </p>
						<p class="pad_bot1">&nbsp;</p>
					</div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
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
</body>
</html>