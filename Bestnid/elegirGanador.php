<?php
error_reporting(E_STRICT);
require_once('Connections/best.php');
session_start();

$query = mysql_query("SELECT * FROM subastas WHERE idSubastas = {$_GET['id']}");

if(!mysql_num_rows($query)){
    header("Location: index.php");
    die;
}

$subasta = mysql_fetch_assoc($query);

if( $subasta['idUsuarios'] != $_SESSION['MM_Id'] ){
    header("Location: index.php");
    die;
}


if(isset($_GET['ganador'])){
    mysql_query("UPDATE subastas SET Estado = 'Completada' , Ganador = {$_GET['ganador']} WHERE idSubastas = {$subasta['idSubastas']}");	
    header('Location: user.php?id='. $_GET['ganador']);
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Elegir ganador</title>
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
                      <h2>Elegir Ganador de mi subasta</h2>
                        <p>&nbsp;</p>
                        <?php
                            $pujas_query = mysql_query("SELECT * FROM pujas WHERE idSubastas = '{$subasta['idSubastas']}'");
                            if(!mysql_num_rows($pujas_query))
                                echo 'Esta subasta no tuvo ninguna puja';

                            while($puja=mysql_fetch_assoc($pujas_query)){?>
                            <p><?php echo $puja['Descripcion'];?> <a href="elegirGanador.php?id=<?php echo $_GET['id'] ?>&ganador=<?php echo $puja['idUsuarios'] ?>">Elegir esta oferta como ganadora.</a></p>
                            <p>
                              <?php } ?>
                            </p>
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
cd 