<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IngresodeMaterias</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/f955c68031.js" crossorigin="Anonymous"></script>
    <link href="ejercicio2Maqueta.css" rel="stylesheet" type="text/css"/>
</head>
<body class="fondos">
    
    <nav class="navbar navbar-expand-sm">
        <!-- logo -->
        <a class="navbar-brand" href="ejercicio3Maqueta.html">
            <i class="fas fa-school"></i>
        </a>

        <div class="container-fluid navbar-right">
            <div class="navbar-header">
              <h1>Instituto San Jose A-355<h1>
                <p class="header"><sup>Obra Don Guanella</sup></p>
            </div>
        </div>
        <!-- Links -->
           <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">Institucional</a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="ejercicio3Maqueta.html">Inicio</a>
                      <a class="dropdown-item" href="autoridades.html">Autoridades</a>
                      <a class="dropdown-item" href="Administracion.html">Administración</a>
                      <a class="dropdown-item" href="Solicitud_vacante.html">Solicitud de vacante</a>
                      <a class="dropdown-item" href="Historia.html">Historia</a>
                    </div>
                  </li>
                <li class="nav-item"><a class="nav-link" href="inicial.html">Inicial</a>
               </li>
               <li class="nav-item"><a class="nav-link" href="primario.html">Primario</a>
                </li>
               <li class="nav-item"><a class="nav-link" href="secundario.html">Secundario</a>
                <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a>
                  <li class="nav-item"><a class="nav-link" href="login.html">Login</a>
                  </li>
              </li>
            </ul>
           
        </nav>



        <div class="card-body">
            <h3>Materias</h3>
            <form id="matter" action="matter.php" method="post" name="matter-form">
            <div class="form-group">
                <label for="materia">Materias:</label>
                <input type="text" class="form-control" name="name" placeholder="Ingrese el nombre de la Materia" id="materia">
            </div>
            <label for="nivelacion">Nivelación: </label>
            <select class="form-control" name="nivelacion">
            <?php 
                          try {
                            include_once 'config/db.php';
                            $stmt = "SELECT * FROM nivelacion";
                            $resultado = $conn->query($stmt);
                          } catch (Exception $e) {
                            $error =$e->getMessage();
                            echo $error;
                          }
                          while($nivelacion = $resultado->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $nivelacion['id_nivelacion']; ?>"><?php echo $nivelacion['nivelacion_name']; ?></option>

                        <?php } ?>
            </select>
            <br><br>
            <input type="hidden" name="matter-form" value="add">
            <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
        <br><br><br><br><br>
        <br><br><br><br><br>

        <footer class="text-white py-4">
            <div class="container-fluid">
              <nav class="row">
                <!--menu-->
                <ul class="col-3 list-unstyled tifo">
                  <li class="font-weight-bold text-uppercase">Direcciones</li>
                  <li class="text-reset columnas1">Copyright© 2007-2021 </li>
                  <li class="text-reset columnas1">Diseño y Diagramación: Gustavo Rivero</li>
                </ul>
                
                <ul class="col-3 list-unstyled columnas">
                  <li class="text-reset">Primaria:Murguiondo 1065</li>
                  <li class="text-reset">Inicial: Murguiondo 1065</li>
                  <li class="text-reset">Secundario: Murguiondo 1029</li>
                </ul>
        
                <!--REDES SOCIALES-->
                <ul class="col-3 list-unstyled">
                  <li class="d-flex justify-content-between">
                    <!--FACEBOOK-->
                    <a href="#" class="text-reset redes"><i class="fab fa-facebook-square"></i></a>
                    <!--INSTAGRAM-->
                    <a href="#" class="text-reset redes"><i class="fab fa-instagram"></i></a>
                    <!--TWITER-->
                    <a href="#" class="text-reset redes"><i class="fab fa-twitter-square"></i></a>
                  </li>
                </ul>
            </nav>
            </div>
        </footer>
</body>
</html>