<?php require_once('Connections/best.php'); ?><?php
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

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysql_select_db($database_best, $best);
$query_DetailRS1 = sprintf("SELECT * FROM subastas  WHERE idSubastas = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysql_query($query_limit_DetailRS1, $best) or die(mysql_error());
$row_DetailRS1 = mysql_fetch_assoc($DetailRS1);

if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysql_query($query_DetailRS1);
  $totalRows_DetailRS1 = mysql_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;

$maxRows_DetailRS2 = 10;
$pageNum_DetailRS2 = 0;
if (isset($_GET['pageNum_DetailRS2'])) {
  $pageNum_DetailRS2 = $_GET['pageNum_DetailRS2'];
}
$startRow_DetailRS2 = $pageNum_DetailRS2 * $maxRows_DetailRS2;

$colname_DetailRS2 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS2 = $_GET['recordID'];
}
mysql_select_db($database_best, $best);
$query_DetailRS2 = sprintf("SELECT * FROM subastas INNER JOIN usuarios ON subastas.idUsuarios = usuarios.idUsuarios  WHERE idSubastas = %s", GetSQLValueString($colname_DetailRS2, "int"));
$query_limit_DetailRS2 = sprintf("%s LIMIT %d, %d", $query_DetailRS2, $startRow_DetailRS2, $maxRows_DetailRS2);
$DetailRS2 = mysql_query($query_limit_DetailRS2, $best) or die(mysql_error());
$row_DetailRS2 = mysql_fetch_assoc($DetailRS2);

if (isset($_GET['totalRows_DetailRS2'])) {
  $totalRows_DetailRS2 = $_GET['totalRows_DetailRS2'];
} else {
  $all_DetailRS2 = mysql_query($query_DetailRS2);
  $totalRows_DetailRS2 = mysql_num_rows($all_DetailRS2);
}
$totalPages_DetailRS2 = ceil($totalRows_DetailRS2/$maxRows_DetailRS2)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<table border="1" align="center">
  <tr>
    <td>idSubastas</td>
    <td><?php echo $row_DetailRS1['idSubastas']; ?></td>
  </tr>
  <tr>
    <td>Titulo</td>
    <td><?php echo $row_DetailRS1['Titulo']; ?></td>
  </tr>
  <tr>
    <td>Fecha</td>
    <td><?php echo $row_DetailRS1['Fecha']; ?></td>
  </tr>
  <tr>
    <td>Fecha_venc</td>
    <td><?php echo $row_DetailRS1['Fecha_venc']; ?></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><?php echo $row_DetailRS1['Estado']; ?></td>
  </tr>
  <tr>
    <td>Comision</td>
    <td><?php echo $row_DetailRS1['Comision']; ?></td>
  </tr>
  <tr>
    <td>Descripcion</td>
    <td><?php echo $row_DetailRS1['Descripcion']; ?></td>
  </tr>
  <tr>
    <td>Imagen</td>
    <td><?php echo $row_DetailRS1['Imagen']; ?></td>
  </tr>
  <tr>
    <td>idCategorias</td>
    <td><?php echo $row_DetailRS1['idCategorias']; ?></td>
  </tr>
  <tr>
    <td>idUsuarios</td>
    <td><?php echo $row_DetailRS1['idUsuarios']; ?></td>
  </tr>
</table>
<table border="1" align="center">
  <tr>
    <td>idSubastas</td>
    <td><?php echo $row_DetailRS2['idSubastas']; ?></td>
  </tr>
  <tr>
    <td>Titulo</td>
    <td><?php echo $row_DetailRS2['Titulo']; ?></td>
  </tr>
  <tr>
    <td>Fecha</td>
    <td><?php echo $row_DetailRS2['Fecha']; ?></td>
  </tr>
  <tr>
    <td>Fecha_venc</td>
    <td><?php echo $row_DetailRS2['Fecha_venc']; ?></td>
  </tr>
  <tr>
    <td>Estado</td>
    <td><?php echo $row_DetailRS2['Estado']; ?></td>
  </tr>
  <tr>
    <td>Comision</td>
    <td><?php echo $row_DetailRS2['Comision']; ?></td>
  </tr>
  <tr>
    <td>Descripcion</td>
    <td><?php echo $row_DetailRS2['Descripcion']; ?></td>
  </tr>
  <tr>
    <td>Imagen</td>
    <td><?php echo $row_DetailRS2['Imagen']; ?></td>
  </tr>
  <tr>
    <td>idCategorias</td>
    <td><?php echo $row_DetailRS2['idCategorias']; ?></td>
  </tr>
  <tr>
    <td>idUsuarios</td>
    <td><?php echo $row_DetailRS2['idUsuarios']; ?></td>
  </tr>
  <tr>
    <td>idUsuarios</td>
    <td><?php echo $row_DetailRS2['idUsuarios']; ?></td>
  </tr>
  <tr>
    <td>DNI</td>
    <td><?php echo $row_DetailRS2['DNI']; ?></td>
  </tr>
  <tr>
    <td>Usuario</td>
    <td><?php echo $row_DetailRS2['Usuario']; ?></td>
  </tr>
  <tr>
    <td>Clave</td>
    <td><?php echo $row_DetailRS2['Clave']; ?></td>
  </tr>
  <tr>
    <td>Nombre</td>
    <td><?php echo $row_DetailRS2['Nombre']; ?></td>
  </tr>
  <tr>
    <td>Apellido</td>
    <td><?php echo $row_DetailRS2['Apellido']; ?></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><?php echo $row_DetailRS2['Email']; ?></td>
  </tr>
  <tr>
    <td>Telefono</td>
    <td><?php echo $row_DetailRS2['Telefono']; ?></td>
  </tr>
  <tr>
    <td>Fecha_reg</td>
    <td><?php echo $row_DetailRS2['Fecha_reg']; ?></td>
  </tr>
  <tr>
    <td>Tipo_cuenta</td>
    <td><?php echo $row_DetailRS2['Tipo_cuenta']; ?></td>
  </tr>
  <tr>
    <td>idLocalidad</td>
    <td><?php echo $row_DetailRS2['idLocalidad']; ?></td>
  </tr>
</table>

</body>
</html><?php
mysql_free_result($DetailRS1);

mysql_free_result($DetailRS2);
?>