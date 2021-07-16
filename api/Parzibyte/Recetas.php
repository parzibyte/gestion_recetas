<?php

namespace Parzibyte;

use Parzibyte\BD;


class Recetas
{
	public static function agregar($nombre, $descripcion, $porciones, $ingredientes, $pasos)
	{
		$bd = BD::obtener();
		$sentencia = $bd->prepare("INSERT INTO recetas(nombre, porciones, descripcion) VALUES (?, ?, ?)");
		$sentencia->execute([$nombre, $porciones, $descripcion]);
		$idReceta = $bd->lastInsertId();
		self::guardarPasos($pasos, $idReceta);
		self::guardarIngredientes($ingredientes, $idReceta);
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
