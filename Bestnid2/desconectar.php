<?php
// *** Logout the current user.
$logoutGoTo = "index.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Ok Sesión</title>
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
					<form id="search" method="post">
						<div>
							<input type="submit" class="submit" value="">
							<input type="text" class="input">
						</div>
					</form>
				</div>
				<div class="wrapper">
					<?php include("includes/menu_desconectar.php"); ?>
				</div>
				<div class="wrapper">
					<div class="col">
						<h2>Usted a cerrado sesión.</h2>
						<p class="pad_bot1"> Muchas gracias.</p>
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