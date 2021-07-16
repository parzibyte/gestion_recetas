<?php
include_once "cors.php";
echo json_encode(Parzibyte\Recetas::buscar(urlencode($_GET["busqueda"])));
