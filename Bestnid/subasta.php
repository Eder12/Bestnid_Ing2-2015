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
				    <form name="registro" id="registro">
                    <table width="872" height="68" border="1">
                      <tr>             
                        <td width="126">Titulo</td>
                        <td width="132">Fecha</td>
                        <td width="172">Fecha de finalización</td>
                        <td width="136">Estado</td>                        
                        <td width="272">Descripcion</td>                        
                      </tr>
                      <?php do { ?>
                        <tr>                          
                          <td><?php echo $row_subastaver['Titulo']; ?></td>
                          <td><?php echo $row_subastaver['Fecha']; ?></td>
                          <td><?php echo $row_subastaver['Fecha_venc']; ?></td>
                          <td><?php echo $row_subastaver['Estado']; ?></td>  
						  <td><?php echo $row_subastaver['Descripcion']; ?></td>             
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
