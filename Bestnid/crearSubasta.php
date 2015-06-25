<?php error_reporting(E_STRICT);
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

  $imagePath = '';
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



  $insertSQL = sprintf("INSERT INTO subastas (Titulo, Fecha, Fecha_venc, Estado, Comision, Descripcion, Imagen, idCategorias, idUsuarios) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Titulo'], "text"),
                       GetSQLValueString(date('Y-m-d'), "date"),
                       GetSQLValueString($_POST['Fecha_venc'], "date"),
                       GetSQLValueString('Pendiente', "text"),
                       GetSQLValueString(69, "int"),
                       GetSQLValueString($_POST['Descripcion'], "text"),
                       GetSQLValueString($imagePath, "text"),
                       GetSQLValueString($_POST['idCategorias'], "int"),
                       GetSQLValueString($_SESSION['MM_Id'] , "int"));

  mysql_select_db($database_best, $best);
  $Result1 = mysql_query($insertSQL, $best) or die(mysql_error());

  $insertGoTo = "ok-error/okCrearSub.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html>
<html lang="en">
<head>
<title>Crear Subasta</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<!--[if lt IE 9]>
<script type="text/javascript" src="http://info.template-help.com/files/ie6_warning/ie6_script_other.js"></script>
<script type="text/javascript" src="js/html5.js"></script>
<![endif]-->
</head>
<body id="page1">
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
						<h2>Crea tu subasta <span>Ingrese todos los datos para crear una nueva subasta. </span></h2>	
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
                          <table align="center">
                            <tr valign="baseline">
                              <td nowrap align="right">Titulo:</td>
                              <td><input type="text" name="Titulo" value="" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Fecha de vencimiento:</td>
                              <td><input type="date" name="Fecha_venc"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Descripcion:</td>
                              <td><textarea type="text" name="Descripcion" value="" size="32"></textarea></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Imagen:</td>
                              <td><input type="file" name="upfile" value="" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">Categorias:</td>
                               <td><select name="idCategorias">
                                  <option value="0">Seleccione categoria</option>
                                <?php
                                  $categorias = mysql_query("SELECT * FROM categorias ORDER BY Nombre");

                                  while($row = mysql_fetch_assoc($categorias)){
                                    echo '<option value="'.$row['idCategorias'].'">'.$row['Nombre'].'</option>';
                                  }
                                ?>
                                </select></td>
                              </td>
                                                    </tr>
                            <tr valign="baseline">
                              <td nowrap align="right">&nbsp;</td>
                              <td><input name="submit" type="submit" value="Crear subasta"></td>
                            </tr>
                          </table>
                          <input type="hidden" name="MM_insert" value="form1">
                        </form>                        
				  </div>
				</div>
			</header>
<!-- / header -->
<!-- content -->
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
</body>
</html>