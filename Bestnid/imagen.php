<?php
error_reporting(E_STRICT);
require_once('Connections/best.php'); 

$id = mysqli_real_escape_string($best,$_GET['idSubastas']);

if( empty($id) or !is_numeric($id) )
		throw new Exception("ID invalido");

$result	=	mysqli_query($best,	"SELECT imagen FROM subastas WHERE idSubastas = '{$id}'");

if( !$result->num_rows )
		throw new Exception("ID no encontrado");

$img	=	mysqli_fetch_array($result,	MYSQLI_ASSOC);

mysqli_free_result($result);

header("Content-type: image");

echo $img['imagen'];

?>