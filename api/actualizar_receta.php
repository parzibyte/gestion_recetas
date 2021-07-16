<?php
include_once "cors.php";
$receta = json_decode($_POST["receta"]);
$foto = null;
if (isset($_FILES["foto"])) {
	$foto = $_FILES["foto"];
}
$respuesta = Parzibyte\Recetas::actualizar($receta->nombre, $receta->descripcion, $receta->porciones, $receta->ingredientes, $receta->pasos, $foto,$receta->id);
echo json_encode($respuesta);
