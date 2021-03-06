<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pagina de control de manuales</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
    crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/imagenes_icon.css">
  <link rel="stylesheet" type="text/css" media="screen" href="../css/principal_admin.css" />
  <?php include_once '../var.php'; ?>

</head>

<body>
  <?php
session_start();
if ( isset($_SESSION["user"]) && isset($_SESSION["password"])  && $_SESSION["grupo"]=='Admin') {
  ?>

  <div class="container mt-4">



    <!-- Tab panes -->
    <div class="tab-content">


    <div class="container"><br>

      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">


                <ul class="nav nav-pills" role="tablist">

                  <?php include_once '../php_codigo/atras.php';?>

                  <?php include_once '../php_codigo/salir_sesion.php';?>
                </ul>

                <div class="tab-content">
                  <div class="container"><br>
                    <?php if (!isset($_POST["name"])): ?>

                    <?php
    //CREATING THE CONNECTION
    $connection1 = new mysqli($db_host, $db_user, $db_password, $db_name);
    $connection1->set_charset("utf8");

    //TESTING IF THE CONNECTION WAS RIGHT
    if ($connection1->connect_errno) {
        printf("Connection failed: %s\n", $connection->connect_error);
        exit();
    }
    $query1="select man.*,man.nombre as manual ,
    man.n_pag as paginas ,
    man.dificultad as dificult,
    man.enlace as enl
    from manuales man 
    join para par 
    on man.cod_manual = par.cod_manual 
    join sistema_operativo so 
    on par.cod_so = so.cod_so
    where man.cod_manual=$_GET[codma]
    group by man.nombre
    order by manual ASC;";
    if ($result1 = $connection1->query($query1)) {
      $obj = $result1->fetch_object();
      echo '<form method="post">';

    echo '<div class="form-group row">';

    echo '<label for="username" class="col-4 col-form-label">Nombre</label>';
    echo '<div class="col-8">';
    echo '<input id="name" name="name"  class="form-control here" type="text" value="' . $obj->nombre . '" maxlength="40" required>';
    echo '</div>';
    echo '</div>';




$mis_sistemas="select man.nombre as manual , so.nombre  as nomsi ,so.version as version  
    from manuales man 
    join para par 
    on man.cod_manual = par.cod_manual 
    join sistema_operativo so 
    on par.cod_so = so.cod_so
    where man.cod_manual=$_GET[codma]
    order by manual ASC";
    if ($result_mis_sistemas = $connection1->query($mis_sistemas)) {

      while ($obj100 = $result_mis_sistemas->fetch_object()) {
        
$so[]=$obj100->nomsi."";
$versi[]=$obj100->version."";
      }

  }

$consulta_sistemas="select cod_so,nombre , version from sistema_operativo";
if ($result_sistemas = $connection1->query($consulta_sistemas)) {
    echo '<div class="form-group row">';

    echo '<label for="soname" class="col-4 col-form-label">Sistema Operativo</label>';
    echo '<div class="col-8">';
    echo '<select id="soname" name="soname[]" class="form-control here" multiple required>';

    while ($obj99 = $result_sistemas->fetch_object()) {
        //PRINTING EACH ROW
        if (in_array($obj99->nombre, $so) && in_array($obj99->version, $versi)) {
        echo "<option selected value='$obj99->cod_so'> ".$obj99->nombre." ".$obj99->version."</option>";
        }
        else {

          echo "<option value='$obj99->cod_so'> ".$obj99->nombre." ".$obj99->version."</option>";


        }
      }
    echo '</select>';
    echo '</div>';
    
    echo '</div>';
}



    echo '<div class="form-group row">';

    echo '<label for="npag" class="col-4 col-form-label">Numero de paginas</label>';
    echo '<div class="col-8">';
    echo '<input id="npag" name="npag"  class="form-control here" type="number" min="1" max="999" value="' . $obj->paginas . '" required>';
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group row">';
    echo '<label for="dificult" class="col-4 col-form-label">Dificultad</label>';
    echo '<div class="col-8">';
    echo '<input id="dificult" name="dificult"  class="form-control here" type="text" value="' . $obj->dificult . '" maxlength="15" required>';
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group row">';
    echo '<label for="enlc" class="col-4 col-form-label">Enlace</label>';
    echo '<div class="col-8">';
    echo '<input id="enlc" name="enlc"  class="form-control here" type="text" value="' . $obj->enl. '" maxlength="200" required>';
    echo '</div>';
    echo '</div>';

    echo '<div class="form-group row">';
    echo '<div class="offset-4 col-8">';
    echo '<button name="registro" type="submit" class="btn btn-primary">Actualizar datos del manual ' . $obj->nombre . '</button>';
    echo '</div>';
    echo '</div>';

    echo '</form>';
  }

    ?>


                    <?php else: ?>

                    <?php
$vector_sistem=$_POST['soname'];
var_dump($vector_sistem);
echo $_GET['codma'];
    //CREATING THE CONNECTION
    $connection1 = new mysqli($db_host, $db_user, $db_password, $db_name);
    $connection1->set_charset("utf8");

    //TESTING IF THE CONNECTION WAS RIGHT
    if ($connection1->connect_errno) {
        printf("Connection failed: %s\n", $connection->connect_error);
        exit();
    }
    $query1 = "UPDATE manuales set nombre = '$_POST[name]',fecha_revisado = CURDATE(),n_pag = $_POST[npag],dificultad = '$_POST[dificult]', enlace = '$_POST[enlc]' where cod_manual = $_GET[codma]";
    if ($result1 = $connection1->query($query1)) {
      $query2="DELETE from para where cod_manual=$_GET[codma]";
      if ($result2 = $connection1->query($query2)) {

 
      for ($i=0; $i < sizeof($vector_sistem) ; $i++) { 
       echo  $vector_sistem[$i]." ";
       
       $query10="INSERT INTO para (cod_so,cod_manual) VALUES ($vector_sistem[$i],$_GET[codma])";
       if ($result10 = $connection1->query($query10)) {
   
        
       } 
   
   
   }
      
     header("Location: ../administrador/menu_manual.php");
      die();
  }
    }

    
    ?>

                    <?php endif?>
                  </div>

                </div>
                <hr>

  </div>
              </div>


            </div>
          </div>
        </div>


      </div>

    </div>
  </div>

  <?php
} else {
    session_destroy();
    header("Location: ../INICIO/index.php");
}

?>