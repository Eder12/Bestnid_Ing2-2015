<!DOCTYPE html>
<html lang="en">
<head>
<title>recuperar contrase&ntilde;a </title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
						<h2>Recuperar contrase&ntilde;a <span>Ingrese su email. </span></h2>									
                        <form name="form1" method="POST" action="ok-error/okRecuperar.php">
						  <p><span id="sprytextfield1">
                          <input type="text" name="Email" value="" size="32">
                          <span class="textfieldRequiredMsg">Ingrese su email.</span><span class="textfieldInvalidFormatMsg">Formato ejemplo@mail.com</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 50.</span></span></p>
</form>
				  </div>
				</div>
			    <p>&nbsp;</p>
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
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email", {maxChars:50});
</script>
</body>
</html>
</body>
</html>