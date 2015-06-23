<!--ver linea 106 mas o menos,. el comentario.-->
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

$MM_restrictGoTo = "ok-error/accesoDenegado.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_IdLogin= "SELECT idUsuarios FROM usuarios WHERE (Usuario= 'nico')";                                       //faltaria poner el usuario que toca, pero no se.
$query_limit_IdLogin= sprintf($query_IdLogin);
$SIdLogin = mysql_query($query_limit_IdLogin, $best) or die(mysql_error());
$row_IdLogin = mysql_fetch_assoc($SIdLogin); 
$IdLogin= $row_IdLogin['idUsuarios'];
$query_subastaver = "SELECT * FROM subastas WHERE (idUsuarios = '$IdLogin') ORDER BY Titulo ASC";  
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
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Mi subastas</title>
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
					<?php include("includes/busca.php"); ?>
				</div>
				<div class="wrapper">
				<?php include("includes/menu.php"); ?>
				</div>
				<div class="wrapper">
					<div class="col">					
						<h2>Mis Subastas<span>Todas mis subastas publicada en Bestnid.
						</span></h2> 
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
			<section id="content">
			  <article class="col2">
					<h3>Todas mis subastas.</h3>
				    <form name="registro" id="registro">
                    <table width="890" height="136" border="1">
                      <tr>             
                        <td width="177">Imagen</td>
                        <td width="189">Titulo</td>
                        <td width="168">Categoria </td>
                        <td width="164">Fecha de creacion </td>                        
                        <td width="158">Fecha de vencimiento </td>                        
                      </tr>
                      <?php do { ?>
                        <tr>                          
                          <td height="99"><?php //echo $row_subastaver['Imagen']; ?></td>
                          <td><?php echo $row_subastaver['Titulo']; ?></td>
                          <td><?php echo $row_subastaver['idCategorias']; ?></td>
                          <td><?php echo $row_subastaver['Fecha']; ?></td>  
						  <td><?php echo $row_subastaver['Fecha_venc']; ?></td>             
                      </tr>
                        <?php } while ($row_subastaver = mysql_fetch_assoc($subastaver)); ?>
                    </table>
				  </form>
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
<?php
mysql_free_result($subastaver);
?>
