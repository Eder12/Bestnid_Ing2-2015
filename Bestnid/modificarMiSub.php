<!--supuestamente esto anda solo falta pasar los parametros por url (poner nombre al parametro). y despues lo mismo lo de la img y lo de categoria.-->
<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE subastas SET Titulo=%s, Fecha_venc=%s, Descripcion=%s, idCategorias=%s, Imagen=%s WHERE idSubastas=%s",
                       GetSQLValueString($_POST['Titulo'], "text"),
                       GetSQLValueString($_POST['Fecha_venc'], "date"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['idCategorias'], "int"),
                       GetSQLValueString($_POST['Imagen'], "text"),
                       GetSQLValueString($_POST['idSubastas'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($updateSQL, $best) or die(mysql_error());

  $updateGoTo = "ok-error/okModificarSubasta.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_GET['idSubastas'])) && ($_GET['idSubastas'] != "")) {
  $deleteSQL = sprintf("DELETE FROM subastas WHERE idSubastas=%s",
                       GetSQLValueString($_GET['idSubastas'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($deleteSQL, $best) or die(mysql_error());

  $deleteGoTo = "dfg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Sub = "-1";
if (isset($_GET['idSubastas'])) {
  $colname_Sub = (get_magic_quotes_gpc()) ? $_GET['idSubastas'] : addslashes($_GET['idSubastas']);
}
mysql_select_db($database_best, $best);
$query_Sub = sprintf("SELECT * FROM subastas WHERE idSubastas = %s", $colname_Sub);
$Sub = mysql_query($query_Sub, $best) or die(mysql_error());
$row_Sub = mysql_fetch_assoc($Sub);
$totalRows_Sub = mysql_num_rows($Sub);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Modificar mi subasta</title>
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
						<h2>Modificar mi subasta </h2>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
		  <section id="content">
		    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
              <table align="center">
                <tr valign="baseline">
                  <td nowrap align="right">Titulo:</td>
                  <td><input type="text" name="Titulo" value="<?php echo $row_Sub['Titulo']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Fecha de vencimiento:</td>
                  <td><input type="text" name="Fecha_venc" value="<?php echo $row_Sub['Fecha_venc']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Descripcion:</td>
                  <td><input type="text" name="Descripcion" value="<?php echo $row_Sub['Descripcion']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Categorias:</td>
                  <td><!--<select name="idCategorias">
                    <option value="menuitem1" <?php //if (!(strcmp("menuitem1", <?php echo $row_Sub['idCategorias']; ?>))) {echo "selected";} ?>>[ Etiqueta ]</option>
                    <option value="menuitem2" <?php //if (!(strcmp("menuitem2", <?php echo $row_Sub['idCategorias']; ?>))) {echo "selected";} ?>>[ Etiqueta ]</option>
                  </select>--></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Imagen:</td>
                  <td><input type="text" name="Imagen" value="<?php //echo $row_Sub['Imagen']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td><input name="submit" type="submit" value="Actualizar registro"></td>
                </tr>
              </table>
		      <input type="hidden" name="MM_update" value="form1">
              <input type="hidden" name="idSubastas" value="<?php echo $row_Sub['idSubastas']; ?>">
            </form>
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
mysql_free_result($Sub);
?>