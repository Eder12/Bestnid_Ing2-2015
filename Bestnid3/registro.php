<?php 
error_reporting(E_STRICT);
require_once('connections/best.php');
 ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios (Usuario, Clave, Nombre, Apellido, DNI, Email, Telefono, Tipo_cuenta, idLocalidad, Fecha_reg) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"),
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Apellido'], "text"),
                       GetSQLValueString($_POST['DNI'], "int"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Telefono'], "int"),
                       GetSQLValueString($_POST['Tipo_cuenta'], "text"),
                       GetSQLValueString($_POST['idLocalidad'], "int"),
                       GetSQLValueString($_POST['Fecha_reg'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($insertSQL, $best) or die(mysql_error());

  $insertGoTo = "okRegistro.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Registro</title>
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
<body id="page3">
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
						<h2>Regístrate <span>Complete todos los capas.</span></h2>
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
				<article class="col2">
					<h3>Registro</h3>
					<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="353" height="219" align="center">
    <tr valign="baseline">
      <td width="75" align="right" nowrap>Usuario:</td>
      <td width="266"><span id="sprytextfield1">
      <input name="Usuario" type="text" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese un nombre de usuario. Entre 4 y 25 caracteres.</span><span class="textfieldMinCharsMsg">El mínimo de caracteres requerido es de 4.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 25.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Clave:</td>
      <td><span id="sprytextfield3">
      <input type="password" name="Clave" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese un clave de usuario. Entre 4 y 25 caracteres.</span><span class="textfieldMinCharsMsg">El mínimo de caracteres requerido es de 4.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 25.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nombre:</td>
      <td><span id="sprytextfield4">
      <input type="text" name="Nombre" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese su nombre.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 50.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Apellido:</td>
      <td><span id="sprytextfield5">
      <input type="text" name="Apellido" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese su apellido.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 50.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">DNI:</td>
      <td><span id="sprytextfield6">
      <input type="text" name="DNI" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese su DNI.</span><span class="textfieldMinCharsMsg">Ingresé los 8 caracteres del DNI sin puntos ni guiones.</span><span class="textfieldMaxCharsMsg">Ingrese los 8 caracteres del DNI sin puntos ni guiones.</span><span class="textfieldInvalidFormatMsg">Ingrese los numeros de su DNI.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td><span id="sprytextfield2">
      <input type="text" name="Email" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese su email.</span><span class="textfieldInvalidFormatMsg">Formato ejemplo@mail.com.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 50.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Telefono:</td>
      <td><span id="sprytextfield7">
      <input type="text" name="Telefono" value="" size="32">
      <span class="textfieldRequiredMsg">Ingrese su telefono.</span><span class="textfieldInvalidFormatMsg">Formato: 00001234567. Sin puntos, guiones o paréntesis.</span><span class="textfieldMaxCharsMsg">El número máximo de caracteres es de 15.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td height="24" align="right" nowrap>&nbsp;</td>
      <td><input type="submit" value="Enviar"></td>
    </tr>
  </table>
  <input type="hidden" name="Tipo_cuenta" value="Usuario">
  <input type="hidden" name="idLocalidad" value="1">
  <input type="hidden" name="Fecha_reg" value="2012-12-12">
  <input type="hidden" name="MM_insert" value="form1">
</form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {minChars:4, maxChars:25});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "email", {maxChars:50});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {minChars:4, maxChars:25});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {maxChars:50});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {maxChars:50});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "integer", {minChars:8, maxChars:8});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "integer", {maxChars:15});
</script>
</body>
</html>
