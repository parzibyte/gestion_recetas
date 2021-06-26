<?php
include_once "vendor/autoload.php";

use Parzibyte\BD;

echo json_encode(BD::obtener()->query("SELECT * FROM a"));
