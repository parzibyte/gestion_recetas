import HttpService from "./HttpService";

const RecetasService = {
	async obtenerRecetas() {
		return await HttpService.get("/obtener_recetas.php");
	},
	async eliminarReceta(id) {
		return await HttpService.post("/eliminar_receta.php", id);
	},
};
export default RecetasService;