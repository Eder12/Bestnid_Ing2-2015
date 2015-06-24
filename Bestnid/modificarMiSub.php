<!--supuestamente esto anda solo falta pasar los parametros por url (poner nombre al parametro). y despues lo mismo lo de la img y lo de categoria.-->
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {


 $imagePath = $_POST['imagen'];
    try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['upfile']['error']) ||
        is_array($_FILES['upfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES['upfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['upfile']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['upfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    $imagePath = sprintf('uploads/%s.%s',
            sha1_file($_FILES['upfile']['tmp_name']),
            $ext
        );
    if (!move_uploaded_file(
        $_FILES['upfile']['tmp_name'],
        $imagePath
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}




  $updateSQL = sprintf("UPDATE subastas SET Titulo=%s, Fecha_venc=%s, Descripcion=%s, idCategorias=%s, Imagen=%s WHERE idSubastas=%s",
                       GetSQLValueString($_POST['Titulo'], "text"),
                       GetSQLValueString($_POST['Fecha_venc'], "date"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($_POST['idCategorias'], "int"),
                       GetSQLValueString($imagePath, "text"),
                       GetSQLValueString($_POST['idSubastas'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($updateSQL, $best) or die(mysql_error());

  $updateGoTo = "ok-error/okModificarSubasta.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

/*if ((isset($_GET['idSubastas'])) && ($_GET['idSubastas'] != "")) {
  $deleteSQL = sprintf("DELETE FROM subastas WHERE idSubastas=%s",
                       GetSQLValueString($_GET['idSubastas'], "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($deleteSQL, $best) or die(mysql_error());

  $deleteGoTo = "dfg.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}*/

$colname_Sub = "-1";
if (isset($_GET['idSubastas'])) {
  $colname_Sub = (get_magic_quotes_gpc()) ? $_GET['idSubastas'] : addslashes($_GET['idSubastas']);
}
mysql_select_db($database_best, $best);
$query_Sub = sprintf("SELECT * FROM subastas WHERE idSubastas = %s", $colname_Sub);
$Sub = mysql_query($query_Sub, $best) or die(mysql_error());
$row_Sub = mysql_fetch_assoc($Sub);
$totalRows_Sub = mysql_num_rows($Sub);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Modificar mi subasta</title>
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
						<h2>Modificar mi subasta </h2>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
		  <section id="content">
		    <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
              <table align="center">
                <tr valign="baseline">
                  <td nowrap align="right">Titulo:</td>
                  <td><input type="text" name="Titulo" value="<?php echo $row_Sub['Titulo']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Fecha de vencimiento:</td>
                  <td><input type="date" name="Fecha_venc" value="<?php echo $row_Sub['Fecha_venc']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Descripcion:</td>
                  <td><input type="text" name="Descripcion" value="<?php echo $row_Sub['Descripcion']; ?>" size="32"></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Categorias:</td>
                  <td><select name="idCategorias">
                      <option value="0">Seleccione categoria</option>
                    <?php
                      $categorias = mysql_query("SELECT * FROM categorias ORDER BY Nombre");

                      while($row = mysql_fetch_assoc($categorias)){
                        echo '<option value="'.$row['idCategorias'].'" ';
                        if( $row['idCategorias'] == $row_Sub['idCategorias'] ) echo ' selected="selected" ';
                        echo'>'.$row['Nombre'].'</option>';
                      }
                    ?>
                    </select></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">Imagen:</td>
                  <td><input type="file" name="upfile" /></td>
                </tr>
                <tr valign="baseline">
                  <td nowrap align="right">&nbsp;</td>
                  <td><input name="submit" type="submit" value="Actualizar registro"></td>
                </tr>
              </table>
              <input type="hidden" name="MM_update" value="form1">
		          <input type="hidden" name="imagen" value="<?php echo $row_Sub['Imagen']; ?>">
              <input type="hidden" name="idSubastas" value="<?php echo $row_Sub['idSubastas']; ?>">
            </form>
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
mysql_free_result($Sub);
?>