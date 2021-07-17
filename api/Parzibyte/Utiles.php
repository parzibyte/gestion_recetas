<?php
/*

  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
____________________________________
/ Si necesitas ayuda, contáctame en \
\ https://parzibyte.me               /
 ------------------------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
Creado por Parzibyte (https://parzibyte.me).
------------------------------------------------------------------------------------------------
            | IMPORTANTE |
Si vas a borrar este encabezado, considera:
Seguirme: https://parzibyte.me/blog/sigueme/
Y compartir mi blog con tus amigos
También tengo canal de YouTube: https://www.youtube.com/channel/UCroP4BTWjfM0CkGB6AFUoBg?sub_confirmation=1
Twitter: https://twitter.com/parzibyte
Facebook: https://facebook.com/parzibyte.fanpage
Instagram: https://instagram.com/parzibyte
Hacer una donación vía PayPal: https://paypal.me/LuisCabreraBenito
------------------------------------------------------------------------------------------------
*/ ?>
<?php

namespace Parzibyte;

use Exception;

class Utiles
{
    static function obtenerVariableDelEntorno($clave)
    {

        if (defined("_ENV_CACHE")) {
            $vars = _ENV_CACHE;
        } else {
            $archivo = "env.php";
            if (!file_exists($archivo)) {
                throw new Exception("El archivo de las variables de entorno ($archivo) no existe. Favor de crearlo");
            }
            $vars = parse_ini_file($archivo);
            define("_ENV_CACHE", $vars);
        }
        if (isset($vars[$clave])) {
            return $vars[$clave];
        } else {
            throw new Exception("La clave especificada (" . $clave . ") no existe en el archivo de las variables de entorno");
        }
    }
}