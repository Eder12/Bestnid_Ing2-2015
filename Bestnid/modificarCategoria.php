<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); 

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE categorias SET Nombre=%s WHERE idCategorias=%s",
                       GetSQLValueString($_POST['Nombre'], "text"),
                       GetSQLValueString($_POST['idCategorias'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($updateSQL, $best) or die(mysql_error());

  $updateGoTo = "ok-error/okModCate.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Puja = "-1";
if (isset($_GET['idCategorias'])) {
  $colname_Puja = $_GET['idCategorias'];
}

mysql_select_db($database_best, $best);
$query_cate = sprintf("SELECT * FROM categorias WHERE idCategorias = %s", GetSQLValueString($colname_Puja, "int"));
$cate = mysql_query($query_cate, $best) or die(mysql_error());
$row_cate = mysql_fetch_assoc($cate);
$totalRows_cate = mysql_num_rows($cate);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Modificar categoria</title>
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
						<h2>Modificar categoria.</h2>
						<p>&nbsp;</p>
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                          <table align="center">
                            <tr valign="baseline">
                              <td nowrap align="right">Nombre:</td>
                              <td><input type="text" name="Nombre" value="<?php echo htmlentities($row_cate['Nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">&nbsp;</td>
                              <td><input type="submit" value="Modificar"></td>
                            </tr>
                          </table>
                          <input type="hidden" name="MM_update" value="form1">
                          <input type="hidden" name="idCategorias" value="<?php echo $row_cate['idCategorias']; ?>">
                        </form>
                        <p>&nbsp;</p>
<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div>
				</div>
				<?php include("includes/nombres.php"); ?>
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
		</footer>
<!-- / footer -->
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($cate);
?>
