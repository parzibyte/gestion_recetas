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
*/
import HttpService from "./HttpService";
import Constantes from "../Constantes";

const RecetasService = {
	async buscarRecetas(busqueda) {
		return await HttpService.get("/buscar_recetas.php?busqueda=" + encodeURIComponent(busqueda));
	},
	async actualizarReceta(receta, foto) {
		const formdata = new FormData();
		if (foto) {
			formdata.append("foto", foto);
		}
		formdata.append("receta", JSON.stringify(receta));
		return await HttpService.formdata("/actualizar_receta.php", formdata);
	},
	async obtenerRecetaPorId(id) {
		return await HttpService.get("/obtener_receta.php?id=" + id);
	},
	ubicacionFoto(nombre) {
		// Por defecto se sirven con Apache
		const NOMBRE_DIRECTORIO_FOTOS = "fotos_recetas";
		return Constantes.URL_SERVIDOR + "/" + NOMBRE_DIRECTORIO_FOTOS + "/" + nombre;
	},
	async obtenerRecetas() {
		return await HttpService.get("/obtener_recetas.php");
	},
	async eliminarReceta(id) {
		return await HttpService.post("/eliminar_receta.php", id);
	},
	async agregarReceta(receta, foto) {
		const formdata = new FormData();
		formdata.append("foto", foto);
		formdata.append("receta", JSON.stringify(receta));
		return await HttpService.formdata("/agregar_receta.php", formdata);
	},
};
export default RecetasService;