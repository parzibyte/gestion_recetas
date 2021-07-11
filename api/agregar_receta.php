<?php
include_once "cors.php";
$receta = json_decode(file_get_contents("php://input"));
$respuesta = Parzibyte\Recetas::agregar($receta->nombre, $receta->descripcion, $receta->porciones, $receta->ingredientes, $receta->pasos);
echo json_encode($respuesta);
