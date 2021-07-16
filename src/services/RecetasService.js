import HttpService from "./HttpService";
import Constantes from "../Constantes";

const RecetasService = {
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