<?php require_once('Connections/best.php'); ?>
<?php require_once('Connections/best.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "sesion.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_misubasta = 10;
$pageNum_misubasta = 0;
if (isset($_GET['pageNum_misubasta'])) {
  $pageNum_misubasta = $_GET['pageNum_misubasta'];
}
$startRow_misubasta = $pageNum_misubasta * $maxRows_misubasta;

$colname_misubasta = "-1";
if (isset($_GET['MM_username'])) {
  $colname_misubasta = $_GET['MM_username'];
}
mysql_select_db($database_best, $best);
$query_misubasta = sprintf("SELECT * FROM subastas INNER JOIN usuarios ON subastas.idUsuarios = usuarios.idUsuarios WHERE usuarios.Usuario = %s ORDER BY subastas.Titulo ASC ", GetSQLValueString($colname_misubasta, "text"));
$query_limit_misubasta = sprintf("%s LIMIT %d, %d", $query_misubasta, $startRow_misubasta, $maxRows_misubasta);
$misubasta = mysql_query($query_limit_misubasta, $best) or die(mysql_error());
$row_misubasta = mysql_fetch_assoc($misubasta);

if (isset($_GET['totalRows_misubasta'])) {
  $totalRows_misubasta = $_GET['totalRows_misubasta'];
} else {
  $all_misubasta = mysql_query($query_misubasta);
  $totalRows_misubasta = mysql_num_rows($all_misubasta);
}
$totalPages_misubasta = ceil($totalRows_misubasta/$maxRows_misubasta)-1;

$queryString_misubasta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_misubasta") == false && 
        stristr($param, "totalRows_misubasta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_misubasta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_misubasta = sprintf("&totalRows_misubasta=%d%s", $totalRows_misubasta, $queryString_misubasta);

$queryString_misubasta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_misubasta") == false && 
        stristr($param, "totalRows_misubasta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_misubasta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_misubasta = sprintf("&totalRows_misubasta=%d%s", $totalRows_misubasta, $queryString_misubasta);

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
?>
<!DOCTYPE html>
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
				<?php include("includes/menu_reg.php"); ?>
				</div>
				<div class="wrapper">
					<div class="col">
						<h2>Mis Subastas <span>Todas mis subastas publicada en Bestnid </span></h2>
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
			  <article class="col2">
					<h3>Todas mis subastas. </h3>
		          <table border="1" align="center">
			          <tr>
			            <td>Titulo</td>
			            <td>Fecha</td>
			            <td>Fecha_venc</td>
			            <td>Estado</td>
		            </tr>
			          <?php do { ?>
			          <tr>
			            <td><a href="detalle_misubasta.php?recordID=<?php echo $row_misubasta['idSubastas']; ?>"> <?php echo $row_misubasta['Titulo']; ?>&nbsp; </a></td>
			            <td><?php echo $row_misubasta['Fecha']; ?>&nbsp; </td>
			            <td><?php echo $row_misubasta['Fecha_venc']; ?>&nbsp; </td>
			            <td><?php echo $row_misubasta['Estado']; ?>&nbsp; </td>
		            </tr>
			          <?php } while ($row_misubasta = mysql_fetch_assoc($misubasta)); ?>
	            </table>
		          <table border="0">
		            <tr>
		              <td><?php if ($pageNum_misubasta > 0) { // Show if not first page ?>
		                <a href="<?php printf("%s?pageNum_misubasta=%d%s", $currentPage, 0, $queryString_misubasta); ?>">Primero</a>
		                <?php } // Show if not first page ?></td>
		              <td><?php if ($pageNum_misubasta > 0) { // Show if not first page ?>
		                <a href="<?php printf("%s?pageNum_misubasta=%d%s", $currentPage, max(0, $pageNum_misubasta - 1), $queryString_misubasta); ?>">Anterior</a>
		                <?php } // Show if not first page ?></td>
		              <td><?php if ($pageNum_misubasta < $totalPages_misubasta) { // Show if not last page ?>
		                <a href="<?php printf("%s?pageNum_misubasta=%d%s", $currentPage, min($totalPages_misubasta, $pageNum_misubasta + 1), $queryString_misubasta); ?>">Siguiente</a>
		                <?php } // Show if not last page ?></td>
		              <td><?php if ($pageNum_misubasta < $totalPages_misubasta) { // Show if not last page ?>
		                <a href="<?php printf("%s?pageNum_misubasta=%d%s", $currentPage, $totalPages_misubasta, $queryString_misubasta); ?>">Último</a>
		                <?php } // Show if not last page ?></td>
	                </tr>
	            </table>
		          <p>Registros <?php echo ($startRow_misubasta + 1) ?> a <?php echo min($startRow_misubasta + $maxRows_misubasta, $totalRows_misubasta) ?> de <?php echo $totalRows_misubasta ?> </p>
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
mysql_free_result($misubasta);

mysql_free_result($misubasta);
?>
