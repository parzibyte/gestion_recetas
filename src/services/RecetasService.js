import HttpService from "./HttpService";

const RecetasService = {
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