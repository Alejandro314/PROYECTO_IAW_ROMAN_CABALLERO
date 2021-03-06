<?php


//CREATING THE CONNECTION
$connection3 = new mysqli($db_host, $db_user, $db_password, $db_name);
$connection3->set_charset("utf8");

//TESTING IF THE CONNECTION WAS RIGHT
if ($connection3->connect_errno) {
    printf("Connection failed: %s\n", $connection->connect_error);
    exit();
}

//MAKING A SELECT QUERY
/* Consultas de selección que devuelven un conjunto de resultados */

$query="select id ,man.nombre as nombre,com.fecha_publicacion as fech_pub,comentario,so.nombre as nombreso,so.version as versionso
from usuarios  usu join comentarios com 
on usu.cod_usuario = com.cod_usuario 
join manuales man 
on com.cod_manual = man.cod_manual
join para par
on man.cod_manual = par.cod_manual
join sistema_operativo so
on par.cod_so = so.cod_so where id='$_SESSION[user]'";


if ($result3 = $connection3->query($query)) {
    ?>

    <!-- PRINT THE TABLE AND THE HEADER -->
    <table class="table"  >
        
    <thead>
        <tr>
        <th scope="row">Usuario</th>
        <th scope="row">Manual</th>
        <th scope="row">Sistema Operativo</th>
        <th scope="row">Version</th>
        <th scope="row">Fecha_publicacion</th>
        <th scope="row">Comentario</th>
       


       </tr>
    </thead>

<?php

    //FETCHING OBJECTS FROM THE RESULT SET
    //THE LOOP CONTINUES WHILE WE HAVE ANY OBJECT (Query Row) LEFT
    while ($obj3 = $result3->fetch_object()) {
        //PRINTING EACH ROW
        echo "<tr>";
        echo "<td>".$obj3->id."</td>";
        echo "<td>".$obj3->nombre."</td>";
        echo "<td>".$obj3->nombreso."</td>";
        echo "<td>".$obj3->versionso."</td>";
        echo "<td>".$obj3->fech_pub."</td>";
        echo "<td>".$obj3->comentario."</td>";
        echo "</tr>";
    }

//Free the result. Avoid High Memory Usages
$result3->close();
unset($obj3);
unset($query);
unset($connection3);
} //END OF THE IF CHECKING IF THE QUERY WAS RIGHT
echo "</table>";

?>
