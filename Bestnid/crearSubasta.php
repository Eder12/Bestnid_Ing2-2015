<?php error_reporting(E_STRICT);
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO subastas (Titulo, Fecha, Fecha_venc, Estado, Comision, Descripcion, Imagen, idCategorias, idUsuarios) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Titulo'], "text"),
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Fecha_venc'], "date"),
                       GetSQLValueString($_POST['Estado'], "text"),
                       GetSQLValueString($_POST['Comision'], "int"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['Imagen'], "text"),
                       GetSQLValueString($_POST['idCategorias'], "int"),
                       GetSQLValueString($_POST['idUsuarios'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($insertSQL, $best) or die(mysql_error());

  $insertGoTo = "ok-error/okCrearSub.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Crear Subasta</title>
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
						<h2>Crea tu subasta <span>Ingrese todos los datos para crear una nueva subasta. </span></h2>	
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                          <table align="center">
                            <tr valign="baseline">
                              <td nowrap align="right">Titulo:</td>
                              <td><input type="text" name="Titulo" value="" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Fecha de vencimiento:</td>
                              <td><input type="text" name="Fecha_venc" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Descripcion:</td>
                              <td><textarea type="text" name="Descripcion" value="" size="32"></textarea></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Imagen:</td>
                              <td><input type="text" name="Imagen" value="" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Categorias:</td>
                              <!--<td><select name="idCategorias">
                                 <option value="menuitem1" <?php //if (!(strcmp("menuitem1", poner la id de la categoria primero que se vea una lista de las mismas))) {echo "SELECTED";} ?>>[ Etiqueta ]</option>
                                  <option value="menuitem2" <?php //if (!(strcmp("menuitem2", poner la id de la categoria primero que se vea una lista de las mismas))) {echo "SELECTED";} ?>>[ Etiqueta ]</option>
                                </select>-->
                              </td>
                                                    </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">&nbsp;</td>
                              <td><input name="submit" type="submit" value="Insertar registro"></td>
                            </tr>
                          </table>
                          <input type="hidden" name="idUsuarios" value="poner la id del usuario">
                          <input type="hidden" name="Fecha" value="poner la fecha actual">
                          <input type="hidden" name="Estado" value="Pendiente">
                          <input type="hidden" name="Comision" value="Que tenemos que poner?">
                          <input type="hidden" name="MM_insert" value="form1">
                        </form>                        
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