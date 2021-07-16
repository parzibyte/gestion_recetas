<?php
include_once "cors.php";
echo json_encode(Parzibyte\Recetas::obtenerPorId($_GET["id"]));

