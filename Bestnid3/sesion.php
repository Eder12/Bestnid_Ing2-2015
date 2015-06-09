<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); 
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['textfield2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "okSesion.php";
  $MM_redirectLoginFailed = "errorSesion.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_best, $best);
  
  $LoginRS__query=sprintf("SELECT Usuario, Clave FROM usuarios WHERE Usuario='%s' AND Clave='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $best) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Sesión</title>
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
<style type="text/css">
<!--
.Estilo2 {font-size: 18px}
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
						<h2>Sesión <span>Para ingresar a su cuenta, por favor ingrese su Nombre de Usuario y su contraseña. </span></h2>
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
				<p>&nbsp;</p>
				<article class="col2">
					<h3>Iniciar Sesión </h3>					      
								<table width="288" border="1">
  <tr>
    <td width="278" height="34">
      <form name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
        <span id="sprytextfield1">
        <label> <span class="Estilo2">Usuario:</span>
          <input type="text" name="textfield">
        </label>
        <span class="textfieldRequiredMsg">Ingrese su nombre de usuario.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 25.</span><span class="textfieldMinCharsMsg">El mínimo de caracteres requerido es de 4.</span></span>
        <hr/>
        <span id="sprytextfield2">
        <label> <span class="Estilo2">Contraseña:</span>
          <input type="password" name="textfield2">
        </label>
        </span>
        <p><span>          </span><span><span class="textfieldRequiredMsg">Ingrese su clave de usuario.</span><span class="textfieldMinCharsMsg">El mínimo de caracteres requerido es de 4.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 25.</span></span>        </p>
        <p>
          <input name="submit" type="submit" class="button" value="Iniciar Sesión">
        </p>
      </form>
	  
      </td>
  </tr>
</table>
				</article>
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
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {maxChars:25, minChars:4});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {minChars:4, maxChars:25});
</script>
</body>
</html>
