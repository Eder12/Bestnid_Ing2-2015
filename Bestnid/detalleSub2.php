<!--Lo mismo que subasta. falta que cuando le dan a detalle le mande la que toca, falta los link a pregunta (que las pueden ver todos), modificar (solo quien la creo), etc-->
<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); 
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
}

$maxRows_subastaver = 10;
$pageNum_subastaver = 0;
if (isset($_GET['pageNum_subastaver'])) {
  $pageNum_subastaver = $_GET['pageNum_subastaver'];
}
$startRow_subastaver = $pageNum_subastaver * $maxRows_subastaver;

mysql_select_db($database_best, $best);
$query_subastaver = "SELECT * FROM subastas ORDER BY Titulo ASC";
$query_limit_subastaver = sprintf("%s LIMIT %d, %d", $query_subastaver, $startRow_subastaver, $maxRows_subastaver);
$subastaver = mysql_query($query_limit_subastaver, $best) or die(mysql_error());
$row_subastaver = mysql_fetch_assoc($subastaver);

if (isset($_GET['totalRows_subastaver'])) {
  $totalRows_subastaver = $_GET['totalRows_subastaver'];
} else {
  $all_subastaver = mysql_query($query_subastaver);
  $totalRows_subastaver = mysql_num_rows($all_subastaver);
}
$totalPages_subastaver = ceil($totalRows_subastaver/$maxRows_subastaver)-1;

$colname_categ = "-1";
if (isset($_POST['idCategorias'])) {
  $colname_categ = (get_magic_quotes_gpc()) ? $_POST['idCategorias'] : addslashes($_POST['idCategorias']);
}
mysql_select_db($database_best, $best);
$query_categ = sprintf("SELECT * FROM categorias WHERE idCategorias = %s ORDER BY Nombre ASC", $colname_categ);
$categ = mysql_query($query_categ, $best) or die(mysql_error());
$row_categ = mysql_fetch_assoc($categ);
$totalRows_categ = mysql_num_rows($categ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Detalle</title>
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
						<h2>Detalle</h2>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
		  <section id="content">
<article class="col2">
				  <table width="886" height="233" border="1">
                      <tr>
                        <td width="235" height="42">Imagen</td>
                        <td width="145">Titulo</td>
                        <td width="127">Categoria</td>
                        <td width="152">Fecha de creacion</td>
                        <td width="193">Fecha de vencimiento </td>
                    </tr>
                      <tr>
                        <td rowspan="3"><?php //echo $row_subastaver['Imagen']; ?></td>
                        <td><?php echo $row_subastaver['Titulo']; ?></td>
                        <td><?php echo $row_categ['Nombre']; ?></td>
                        <td><?php echo $row_subastaver['Fecha']; ?></td>
                        <td><?php echo $row_subastaver['Fecha_venc']; ?></td>
                      </tr>
                      <tr>
                        <td height="40" colspan="4">Descripcion</td>
                      </tr>
                      <tr>
                        <td height="84" colspan="4"><?php echo $row_subastaver['Descripcion']; ?></td>
                      </tr>
                    </table>
		    <p>&nbsp;</p>
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
</body>
</html>