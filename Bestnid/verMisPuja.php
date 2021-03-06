<?php 
error_reporting(E_STRICT);
require_once('Connections/best.php'); 

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
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
  $insertSQL = sprintf("INSERT INTO pujas (Fecha, Estado, Monto, Descripcion, idSubastas, idUsuarios) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Fecha'], "date"),
                       GetSQLValueString($_POST['Estado'], "text"),
                       GetSQLValueString($_POST['Monto'], "int"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['idSubastas'], "int"),
                       GetSQLValueString($_POST['idUsuarios'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($insertSQL, $best) or die(mysql_error());
}

mysql_select_db($database_best, $best);
$query_subastaver = "SELECT * FROM pujas WHERE idUsuarios = '{$_SESSION['MM_Id']}' ORDER BY Fecha DESC";
$subastaver = mysql_query($query_subastaver, $best) or die(mysql_error());
$fecha = date_create($pujas['Fecha']);

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
          <?php include("includes/busca.php"); ?>
        </div>
        <div class="wrapper">
        <?php include("includes/menu.php"); ?>
        </div>
        <div class="wrapper">
          <div class="col">
            <h2>Pujas <span>Mis Pujas </span></h2>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </div>
        </div>
      </header>
<!-- / header -->
<!-- content -->
      <section id="content">
        <article class="col2">
          <h3>Todas mis pujas.</h3>
        <form name="registro" id="registro">
                    <table width="767" border="1">
                      <tr>             
                        <td width="65" height="31">Fecha</td>
                        <td width="65">Titulo</td>
                        <td width="59">Monto </td>
                        <td width="408">Descripcion </td>
                        <td width="136">Acciones</td>
					  </tr>
                      <?php while ($puja = mysql_fetch_assoc($subastaver)){ ?>
                        <tr>                          
							
                          <td height="28"><?php			
							echo date_format($fecha, 'd/m/Y'); ?></td>
                          <td><?php 
						  
						   $subasta_query = mysql_query("SELECT Titulo FROM subastas WHERE idSubastas = {$puja['idSubastas']}");
                           $subasta = mysql_fetch_assoc($subasta_query);
						   $fecha = date_create($puja['Fecha']);?>
						   <a href="DetalleSub.php?id=<?php echo $puja['idSubastas']; ?>"> <?php echo $subasta['Titulo']; ?></a>
						  </td>
                          <td><?php echo $puja['Monto']; ?></td>
						  <td><?php echo $puja['Descripcion']; ?></td>                          
						  <td><a href="modificarMisPujas.php?idPujas=<?php echo $puja['idPujas']; ?>">Editar</a>-
                          <a href="elimMiPuja.php?idPujas=<?php echo $puja['idPujas']; ?>" onClick="if (! confirm('¿Seguro que quieres eliminar su puja?')) return false;">Eliminar</a>-</td>                   
                          </tr>
                        <?php } ?>
            </table>
          </form>		  
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

mysql_free_result($categ);
?>
