<?php

namespace Parzibyte;

use Parzibyte\BD;


class Recetas
{
	public static function actualizar($nombre, $descripcion, $porciones, $ingredientes, $pasos, $foto, $idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("UPDATE recetas SET nombre = ?, porciones = ?, descripcion = ? WHERE id = ?");
		$sentencia->execute([$nombre, $porciones, $descripcion, $idReceta]);
		self::guardarPasos($pasos, $idReceta);
		self::guardarIngredientes($ingredientes, $idReceta);
		if ($foto) {
			FotosRecetas::guardarFoto($foto, $idReceta);
		}
		return true;
	}
	public static function obtenerPorId($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("SELECT recetas.id, recetas.nombre, recetas.descripcion, recetas.porciones, fotos_recetas.foto FROM recetas INNER JOIN fotos_recetas ON recetas.id = fotos_recetas.id_receta WHERE recetas.id = ?");
		$sentencia->execute([$idReceta]);
		$receta = $sentencia->fetchObject();
		if (!$receta) {
			return null;
		}
		$receta->ingredientes = self::ingredientesDeReceta($receta->id);
		$receta->pasos = self::pasosDeReceta($receta->id);
		return $receta;
	}

	public static function ingredientesDeReceta($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("SELECT nombre, cantidad, unidad_medida as unidadMedida FROM ingredientes_recetas WHERE id_receta = ?");
		$sentencia->execute([$idReceta]);
		return $sentencia->fetchAll();
	}

	public static function pasosDeReceta($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("SELECT paso FROM pasos_recetas WHERE id_receta = ?");
		$sentencia->execute([$idReceta]);
		return $sentencia->fetchAll();
	}

	public static function eliminar($id)
	{
		FotosRecetas::eliminarFotos($id);
		$bd = BD::obtener();
		$sentencia = $bd->prepare("DELETE FROM recetas WHERE id = ?");
		return $sentencia->execute([$id]);
	}

	public static function obtener()
	{
		$bd = BD::obtener();
		$sentencia = $bd->query("SELECT recetas.id, recetas.nombre, recetas.descripcion, recetas.porciones, fotos_recetas.foto FROM recetas INNER JOIN fotos_recetas ON recetas.id = fotos_recetas.id_receta");
		return $sentencia->fetchAll();
	}

	public static function agregar($nombre, $descripcion, $porciones, $ingredientes, $pasos, $foto)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("INSERT INTO recetas(nombre, porciones, descripcion) VALUES (?, ?, ?)");
		$sentencia->execute([$nombre, $porciones, $descripcion]);
		$idReceta = $bd->lastInsertId();
		self::guardarPasos($pasos, $idReceta);
		self::guardarIngredientes($ingredientes, $idReceta);
		FotosRecetas::guardarFoto($foto, $idReceta);
		return true;
	}
	private static function eliminarPasosDeReceta($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("DELETE FROM pasos_recetas WHERE id_receta = ?");
		return $sentencia->execute([$idReceta]);
	}

	private static function eliminarIngredientesDeReceta($idReceta)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("DELETE FROM ingredientes_recetas WHERE id_receta = ?");
		return $sentencia->execute([$idReceta]);
	}

	private static function guardarPasos($pasos, $idReceta)
	{
		self::eliminarPasosDeReceta($idReceta);
		$bd = BD::obtener();
		$sentencia = $bd->prepare("INSERT INTO pasos_recetas(id_receta, paso) VALUES (?, ?)");
		foreach ($pasos as $paso) {
			$sentencia->execute([$idReceta, $paso]);
		}
	}

	private static function guardarIngredientes($ingredientes, $idReceta)
	{
		self::eliminarIngredientesDeReceta($idReceta);
		$bd = BD::obtener();
		$sentencia = $bd->prepare("INSERT INTO ingredientes_recetas(id_receta, nombre, cantidad, unidad_medida) VALUES (?, ?, ?, ?)");
		foreach ($ingredientes as $ingrediente) {
			$sentencia->execute([$idReceta, $ingrediente->nombre, $ingrediente->cantidad, $ingrediente->unidadMedida]);
		}
	}
}
