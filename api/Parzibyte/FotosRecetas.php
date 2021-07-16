<?php

namespace Parzibyte;

class FotosRecetas
{
	const UBICACION_FOTOS = "fotos_recetas";
	static function existeFoto($nombreFoto)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("SELECT foto FROM fotos_recetas WHERE foto = ?");
		$sentencia->execute([$nombreFoto]);
		if ($sentencia->fetchObject()) {
			return true;
		} else {
			return false;
		}
	}
	public static function obtenerFotos($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("SELECT foto FROM fotos_recetas WHERE id_receta = ?");
		$sentencia->execute([$idReceta]);
		return $sentencia->fetchAll();
	}
	public static function eliminarFotosDeAlmacenamiento($idReceta)
	{
		$fotos = self::obtenerFotos($idReceta);
		foreach ($fotos as $foto) {
			unlink(self::obtenerRutaAbsolutaFoto($foto->foto));
		}
	}

	public static function obtenerRutaAbsolutaFoto($nombre)
	{

		return  self::UBICACION_FOTOS . DIRECTORY_SEPARATOR . $nombre;
	}

	public static function eliminarFotos($idReceta)
	{
		self::eliminarFotosDeAlmacenamiento($idReceta);
		$bd = BD::obtener();
		$sentencia = $bd->prepare("DELETE FROM fotos_recetas WHERE id_receta = ?");
		return $sentencia->execute([$idReceta]);
	}

	static function cadenaAleatoriaInsegura()
	{
		$caracteres = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		return substr(str_shuffle($caracteres), 0, 10);
	}
	static function obtenerNombreFotoNoRepetido($extensionArchivo)
	{
		do {
			$nombre = self::cadenaAleatoriaInsegura() . "." . $extensionArchivo;
		} while (self::existeFoto($nombre));
		return $nombre;
	}

	public static function fotoValida($ubicacionTemporal)
	{
		$mime = mime_content_type($ubicacionTemporal);
		if ($mime !== "image/jpeg" && $mime !== "image/png") return false;
		return true;
	}

	public static function guardarFoto($archivo, $idReceta)
	{
		$ubicacionTemporal = $archivo["tmp_name"];
		if (!self::fotoValida($ubicacionTemporal)) {
			return false;
		}
		// Hasta aquí podemos confiar en la extensión del archivo
		self::eliminarFotos($idReceta);
		$nombreArchivo = $archivo["name"];
		$extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
		$nombre = self::obtenerNombreFotoNoRepetido($extension);
		if (!file_exists(self::UBICACION_FOTOS)) {
			mkdir(self::UBICACION_FOTOS);
		}
		$nuevaUbicacion = self::obtenerRutaAbsolutaFoto($nombre);
		$movido = move_uploaded_file($ubicacionTemporal, $nuevaUbicacion);
		if (!$movido) {
			return false;
		}
		$bd = BD::obtener();
		$sentencia = $bd->prepare("INSERT INTO fotos_recetas(id_receta, foto) VALUES(?, ?)");
		return $sentencia->execute([$idReceta, $nombre]);
	}
}
