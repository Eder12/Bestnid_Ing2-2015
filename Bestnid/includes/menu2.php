<nav>
						<ul id="menu">
							<li><a href="../index.php">Inicio</a></li>
							<li><a href="../subasta.php">Subastas</a></li>
                            <?php if(isset($_SESSION['MM_Id'])){ ?>
                             <li><a href="../crearSubasta.php">Crear subasta</a></li>
							 <li><a href="../verMisPreguntas.php">Mis Preguntas</a></li>
							 <li><a href="../verMisPuja.php">Mis pujas</a></li>
                             <li><a href="../misubasta.php"><?php echo $_SESSION['MM_Username']; ?></a></li>
							 <?php if($_SESSION['Privilegios'] == 'Administrador'){ ?>
							 <li><a href="../estadisticas.php">Admin</a></li>
							 <?php }?>
                             <li><a href="../sesion.php?doLogout=true">Salir</a></li>
                            <?php }else{?>
							 <li><a href="../sesion.php">Ingresar</a></li>
							<li><a href="../registro.php">Registrarse</a></li>
                             <?php }?>
						</ul>
					</nav>					
					