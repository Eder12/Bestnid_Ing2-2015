<?php require_once('Connections/best.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}

error_reporting(E_STRICT);
require_once('Connections/best.php'); ?>
<?php
$maxRows_buscador = 10;
$pageNum_buscador = 0;
if (isset($_GET['pageNum_buscador'])) {
  $pageNum_buscador = $_GET['pageNum_buscador'];
}
$startRow_buscador = $pageNum_buscador * $maxRows_buscador;

$colname_buscador = "-1";
if (isset($_GET['bu'])) {
  $colname_buscador = $_GET['bu'];
}
mysql_select_db($database_best, $best);
$query_buscador = sprintf("SELECT * FROM subastas WHERE Titulo LIKE %s ORDER BY Titulo DESC", GetSQLValueString("%" . $colname_buscador . "%", "text"));
$query_limit_buscador = sprintf("%s LIMIT %d, %d", $query_buscador, $startRow_buscador, $maxRows_buscador);
$buscador = mysql_query($query_limit_buscador, $best) or die(mysql_error());
$row_buscador = mysql_fetch_assoc($buscador);

if (isset($_GET['totalRows_buscador'])) {
  $totalRows_buscador = $_GET['totalRows_buscador'];
} else {
  $all_buscador = mysql_query($query_buscador);
  $totalRows_buscador = mysql_num_rows($all_buscador);
}
$totalPages_buscador = ceil($totalRows_buscador/$maxRows_buscador)-1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Buscador</title>
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
						<h2>Buscador <span>Resultados de la buscada </span></h2>
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
				<article class="col2">
					<h3>Resultados:</h3>
				<table width="805" height="77" border="1">
  <tr>
    <td width="165">Titulo</td>
    <td width="113">Fecha</td>
    <td width="167">Fecha de finalizaci&oacute;n</td>
    <td width="71">Estado</td>
    <td width="255">Descripcion</td>
  </tr>
  <tr>
    <?php do { ?>
      <td><?php echo $row_buscador['Titulo']; ?></td>
      <td><?php echo $row_buscador['Fecha']; ?></td>
      <td><?php echo $row_buscador['Fecha_venc']; ?></td>
      <td><?php echo $row_buscador['Estado']; ?></td>
      <td><?php echo nl2br($row_buscador['Descripcion']); ?></td>
      </tr>
	  <tr><?php } while ($row_buscador = mysql_fetch_assoc($buscador)); ?></tr>
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
			<div class="pad">
				 Website template designed by <a href="http://www.templatemonster.com/" target="_blank" rel="nofollow">www.templatemonster.com</a><br>
				 3D Models provided by <a href="http://www.templates.com/product/3d-models/" target="_blank" rel="nofollow">www.templates.com</a>
			</div>
		</footer>
<!-- / footer -->
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($buscador);
?>

