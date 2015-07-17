<?php
error_reporting(E_STRICT);
require_once('Connections/best.php');
session_start(); 
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

mysql_select_db($database_best, $best);
$query_cate = "SELECT * FROM categorias";
$cate = mysql_query($query_cate, $best) or die(mysql_error());
$row_cate = mysql_fetch_assoc($cate);
$totalRows_cate = mysql_num_rows($cate);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Categorias</title>
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
                    <h2>Categorias</h2>
                    <a href="crearCategoria.php">Crear categoria</a>
                    <p>Categorias:</p>
                    <?php do { ?>
                    <table width="297" height="29" border="1">
                      <tr>
                        <td width="116">-<?php echo $row_cate['Nombre']; ?></td>
                        <td width="63"><a href="modificarCategoria.php?idCategorias=<?php echo $row_cate['idCategorias']; ?>"> Modificar</a></td>
                        <td width="66"><a href="elimCategoria.php?idCategorias=<?php echo $row_cate['idCategorias']; ?>"> Eliminar</a></td>
                      </tr>
                    </table>
                    <?php } while ($row_cate = mysql_fetch_assoc($cate)); ?>
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
mysql_free_result($cate);
?>
