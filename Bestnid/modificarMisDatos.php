<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php');

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET DNI=%s, Nombre=%s, Apellido=%s, Usuario=%s, Clave=%s, Email=%s, Telefono=%s WHERE idUsuarios=%s",
                       GetSQLValueString($_POST['DNI'], "int"),
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['Apellido'], "text"),
                       GetSQLValueString($_POST['Usuario'], "text"),
                       GetSQLValueString($_POST['Clave'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Telefono'], "int"),
                       GetSQLValueString($_POST['idUsuarios'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($updateSQL, $best) or die(mysql_error());

  $updateGoTo = "ok-error/okModMisDatos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_best, $best);
$query_user = "SELECT * FROM usuarios WHERE idUsuarios = '{$_SESSION['MM_Id']}'";
$user = mysql_query($query_user, $best) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Modificar mis datos</title>
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
						<h2>Modificar mis datos</h2>
					  <p>&nbsp;</p>
				  
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                          <table align="center">
                            <tr valign="baseline">
                              <td width="60" align="right" nowrap>DNI:</td>
                              <td width="235"><input type="text" name="DNI" value="<?php echo $row_user['DNI']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Nombre:</td>
                              <td><input type="text" name="Nombre" value="<?php echo $row_user['Nombre']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Apellido:</td>
                              <td><input type="text" name="Apellido" value="<?php echo $row_user['Apellido']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Usuario:</td>
                              <td><input type="text" name="Usuario" value="<?php echo $row_user['Usuario']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Clave:</td>
                              <td><input type="password" name="Clave" value="" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Email:</td>
                              <td><input type="text" name="Email" value="<?php echo $row_user['Email']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Telefono:</td>
                              <td><input type="text" name="Telefono" value="<?php echo $row_user['Telefono']; ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td height="43" align="right" nowrap>&nbsp;</td>
                              <td><input type="submit" value="Modificar"></td>
                            </tr>
                          </table>
                          <input type="hidden" name="MM_update" value="form1">
                          <input type="hidden" name="idUsuarios" value="<?php echo $row_user['idUsuarios']; ?>">
                        </form>
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
mysql_free_result($user);
?>
