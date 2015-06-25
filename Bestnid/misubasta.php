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

mysql_select_db($database_best, $best);
$query_subastaver = "SELECT * FROM subastas WHERE idUsuarios = '{$_SESSION['MM_Id']}' ORDER BY Fecha DESC";
$subastaver = mysql_query($query_subastaver, $best) or die(mysql_error());
$row_subastaver = mysql_fetch_assoc($subastaver);

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
            <h2>Subastas <span>MIS SUBASTAS </span></h2>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
          </div>
        </div>
      </header>
<!-- / header -->
<!-- content -->
      <section id="content">
        <article class="col2">
          <h3>Todas las subastas.</h3>
            <form name="registro" id="registro">
                    <table width="890" height="136" border="1">
                      <tr>             
                        <td width="177">Imagen</td>
                        <td width="189">Titulo</td>
                        <td width="168">Categoria </td>
                        <td width="164">Fecha de creacion </td>                        
                        <td width="158">Fecha de vencimiento </td>                        
                        <td width="158">Acciones</td>                        
                      </tr>
                      <?php while ($row_subastaver = mysql_fetch_assoc($subastaver)){ ?>
                        <tr>                          
                          <td height="99"><img src="<?php echo $row_subastaver['Imagen']; ?>" width="126" height="116" /></td>
                          <td><?php echo $row_subastaver['Titulo']; ?></td>
                          <td><?php

                          $query_categ = sprintf("SELECT * FROM categorias WHERE idCategorias = %s", $row_subastaver['idCategorias']);
                          $categ = mysql_query($query_categ, $best) or die(mysql_error());
                          $row_categ = mysql_fetch_assoc($categ);

                           echo $row_categ['Nombre']; 

                           ?></td>
                          <td><?php echo $row_subastaver['Fecha']; ?></td>  
                          <td><?php echo $row_subastaver['Fecha_venc']; ?></td>             
                          <td>
                            <a href="detalleSub.php?id=<?php echo $row_subastaver['idSubastas']; ?>">Ver mas</a> -
                            <a href="modificarMiSub.php?idSubastas=<?php echo $row_subastaver['idSubastas']; ?>">Editar</a> -
                            <a href="elimMiSub.php?idSubastas=<?php echo $row_subastaver['idSubastas']; ?>">Eliminar</a>
                          </td>             
                      </tr>
                        <?php } ?>
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

mysql_free_result($categ);
?>
