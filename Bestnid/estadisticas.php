<?php
error_reporting(E_STRICT);
require_once('Connections/best.php');
session_start(); 


if($_SESSION['Privilegios'] != 'Administrador'){
	header('Location: index.php');
	die;
}

mysql_select_db($database_best);

function getUsers( $from, $to ){
    $query = mysql_query("SELECT * FROM usuarios WHERE Fecha_reg BETWEEN '{$from}' AND '{$to}'");
    $res=array();
    while($row=mysql_fetch_assoc($query)){
        $res[]=array(
            'Nombre' => $row['Nombre'].','.$row['Apellido'],
            'Telefono' => $row['Telefono'],
            'DNI' => $row['DNI'],
        );
    }
    return $res;
}

function getSubs( $from, $to ){
    $query = mysql_query("SELECT * FROM subastas WHERE Fecha BETWEEN '{$from}' AND '{$to}'");
    $res=array();
    while($row=mysql_fetch_assoc($query)){
        $res[]=array(
            'Título' => $row['Titulo'],
            'Fecha' => $row['Fecha']
        );
    }
    return $res;
}

if(isset($_GET['tipo'])){
    switch ($_GET['tipo']) {
        case 'users':
            $stats = getUsers($_GET['fecha_ini'],$_GET['fecha_fin']);
            break;

        case 'subs':
            $stats = getSubs($_GET['fecha_ini'],$_GET['fecha_fin']);
            break;
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
<title>Estadisticas</title>
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
                        <h2>Estadísticas del sitio</h2>
                        <?php
                            if(isset($stats)){
                                echo '<b> ';
                                echo count($stats);
                                echo ($_GET['tipo']=='users')?' Usuarios':' Subastas';
                                echo ' desde el '. $_GET['fecha_ini'];
                                echo ' hasta el '. $_GET['fecha_fin'];
                                echo '</b> <a href="estadisticas.php">Volver</a>';
                                echo '<br />';
                                echo '<br />';
                                echo '<table style="width:100%">';
                                foreach ($stats as $stat) {
                                    echo '<tr>';
                                    foreach ($stat as $value) {
                                        echo '<td>'.$value.'</td>';
                                    }
                                    if($_GET['tipo']=='subs')
                                        echo '<td><a href="detalleSub.php?id='.$stat['id'].'">Ver más</a></td>';
                                    echo '</tr>';
                                }
                                echo '</table>';
                            }else{?>
                                <form action="estadisticas.php" method="GET">
                                    <fieldset>
                                        <legend>Seleccione que estadísticas desea ver</legend>
                                        <input type="radio" name="tipo" value="users" id="tipousers" checked="checked" />
                                        <label for="tipousers">Usuarios</label><br>
                                        <input type="radio" name="tipo" value="subs" id="tiposubs" />
                                        <label for="tiposubs">Subastas</label><br>
                                    </fieldset>
                                    <fieldset>
                                        <legend>Rango de tiempo</legend>
                                        <input type="date" name="fecha_ini" />
                                        <input type="date" name="fecha_fin" />
                                    </fieldset>
                                    <input type="submit" value="Ver estadísticas" />
                                </form>
                            <?php } ?>
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
