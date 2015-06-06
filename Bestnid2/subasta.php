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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_subastas = 10;
$pageNum_subastas = 0;
if (isset($_GET['pageNum_subastas'])) {
  $pageNum_subastas = $_GET['pageNum_subastas'];
}
$startRow_subastas = $pageNum_subastas * $maxRows_subastas;

mysql_select_db($database_best, $best);
$query_subastas = "SELECT * FROM subastas ORDER BY Titulo ASC";
$query_limit_subastas = sprintf("%s LIMIT %d, %d", $query_subastas, $startRow_subastas, $maxRows_subastas);
$subastas = mysql_query($query_limit_subastas, $best) or die(mysql_error());
$row_subastas = mysql_fetch_assoc($subastas);

if (isset($_GET['totalRows_subastas'])) {
  $totalRows_subastas = $_GET['totalRows_subastas'];
} else {
  $all_subastas = mysql_query($query_subastas);
  $totalRows_subastas = mysql_num_rows($all_subastas);
}
$totalPages_subastas = ceil($totalRows_subastas/$maxRows_subastas)-1;

$queryString_subastas = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_subastas") == false && 
        stristr($param, "totalRows_subastas") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_subastas = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_subastas = sprintf("&totalRows_subastas=%d%s", $totalRows_subastas, $queryString_subastas);
 
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
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Subastas</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>
<body id="page2">
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
				<?php include("includes/menu.php"); ?>
				</div>
				<div class="wrapper">
					<div class="col">
						<h2>Subastas <span>Todas las subastas de Bestnid </span></h2>
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
			  <article class="col2">
					<h3>Todas las subastas. </h3>
					<table border="1" align="center">
					  <tr>
					    <td>Titulo</td>
					    <td>Fecha</td>
					    <td>Fecha_venc</td>
					    <td>Estado</td>
				      </tr>
					  <?php do { ?>
					  <tr>
					    <td><?php echo $row_subastas['Titulo']; ?>&nbsp; </a></td>
					    <td><?php echo $row_subastas['Fecha']; ?>&nbsp; </td>
					    <td><?php echo $row_subastas['Fecha_venc']; ?>&nbsp; </td>
					    <td><?php echo $row_subastas['Estado']; ?>&nbsp; </td>
				      </tr>
					  <?php } while ($row_subastas = mysql_fetch_assoc($subastas)); ?>
			    </table>
					<table border="0">
					  <tr>
					    <td><?php if ($pageNum_subastas > 0) { // Show if not first page ?>
					      <a href="<?php printf("%s?pageNum_subastas=%d%s", $currentPage, 0, $queryString_subastas); ?>">Primero</a>
					      <?php } // Show if not first page ?></td>
					    <td><?php if ($pageNum_subastas > 0) { // Show if not first page ?>
					      <a href="<?php printf("%s?pageNum_subastas=%d%s", $currentPage, max(0, $pageNum_subastas - 1), $queryString_subastas); ?>">Anterior</a>
					      <?php } // Show if not first page ?></td>
					    <td><?php if ($pageNum_subastas < $totalPages_subastas) { // Show if not last page ?>
					      <a href="<?php printf("%s?pageNum_subastas=%d%s", $currentPage, min($totalPages_subastas, $pageNum_subastas + 1), $queryString_subastas); ?>">Siguiente</a>
					      <?php } // Show if not last page ?></td>
					    <td><?php if ($pageNum_subastas < $totalPages_subastas) { // Show if not last page ?>
					      <a href="<?php printf("%s?pageNum_subastas=%d%s", $currentPage, $totalPages_subastas, $queryString_subastas); ?>">Último</a>
					      <?php } // Show if not last page ?></td>
				      </tr>
			    </table>
					<p>Registros <?php echo ($startRow_subastas + 1) ?> a <?php echo min($startRow_subastas + $maxRows_subastas, $totalRows_subastas) ?> de <?php echo $totalRows_subastas ?> </p>
			      <p>&nbsp;</p>
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
<br>
</body>
</html>
<?php
mysql_free_result($subastas);
?>
