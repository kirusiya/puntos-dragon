<?php

class cDragon{
	
	function puntos_usuarios(){

		$csql="		
		SELECT * FROM puntos_usuarios
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function buscarTempYear($year_temporada){

		$csql="		
		SELECT * FROM temporadas
		WHERE year_temporada = '$year_temporada'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function desactivarTemporadas(){
		$csql = "

		UPDATE temporadas 
		SET  
		estado_temporada = '0'
		
		where estado_temporada = 1

		";

		$obc=new conexion();

		return $obc->consultar($csql);

	}
	
	function insertarTemporada($primer_inicio, $primer_fin, $segunda_inicio, $segunda_fin, $year_temporada, $estado_temporada, $nom_temporada){

		$csql="		
		INSERT INTO temporadas 
		(primer_inicio, primer_fin, segunda_inicio, segunda_fin, year_temporada, estado_temporada, nom_temporada)
		
		VALUES 
		('$primer_inicio', '$primer_fin', '$segunda_inicio', '$segunda_fin', '$year_temporada', '$estado_temporada', '$nom_temporada')
		";

		$obc=new conexion();
		return $obc->consultar($csql);

	}
	
	function verTemporadas(){

		$csql="		
		SELECT * FROM temporadas
		order by cod_temporada DESC
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function eliminarTemporada($cod_temporada){
		$csql="		
		DELETE FROM temporadas 
		WHERE cod_temporada = '$cod_temporada';
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function verCodTemporada($cod_temporada){

		$csql="		
		SELECT * FROM temporadas
		WHERE cod_temporada = '$cod_temporada'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function temporadaActiva(){

		$csql="		
		SELECT * FROM temporadas
		WHERE estado_temporada = 1
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function insertarRegistro($cod_user, $cod_transferido, $puntos_transfer, $nom_temporada, $modo_trans, $temporada, $fecha_transfer, $hora_transfer){

		$csql="		
		INSERT INTO registro_puntos 
		(cod_user, cod_transferido, puntos_transfer, nom_temporada, modo_trans, temporada, fecha_transfer, hora_transfer)
		
		VALUES 
		('$cod_user', '$cod_transferido', '$puntos_transfer', '$nom_temporada', '$modo_trans', '$temporada', '$fecha_transfer', '$hora_transfer')
		";

		$obc=new conexion();
		return $obc->consultar($csql);

	}
	
	
	function puntosPorAdmin(){

		$csql="		
		SELECT * FROM registro_puntos
		WHERE modo_trans = 'Por Admin'
		
		order by cod_reg desc
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function insertarPuntosUsuarios($cod_user, $puntos, $temporada){

		$csql="		
		INSERT INTO puntos_usuarios 
		(cod_user, puntos, temporada)
		
		VALUES 
		('$cod_user', '$puntos', '$temporada')
		";

		$obc=new conexion();
		return $obc->consultar($csql);

	}
	
	
	function quitarPuntosUsuarios($cod_user, $puntos){
		$csql="		
		DELETE FROM puntos_usuarios 
		WHERE cod_user = '$cod_user' and puntos = '$puntos'
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function quitarPuntosRegistro($cod_reg){
		$csql="		
		DELETE FROM registro_puntos 
		WHERE cod_reg = '$cod_reg'
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function eliminarPuntosTrans($cod_user){
		$csql="		
		DELETE FROM puntos_usuarios 
		WHERE cod_user = '$cod_user';
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function verCreditosEnviados($cod_transferido){
		$csql="		
		SELECT * FROM registro_puntos 
		WHERE cod_transferido = '$cod_transferido' and modo_trans = 'Traspaso' 
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function verPuntosTrans($cod_user, $temporada){
		$csql="		
		SELECT * FROM puntos_usuarios 
		WHERE cod_user = '$cod_user' and temporada = '$temporada'
		ORDER BY cod_punto ASC
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function eliminarPuntosCod($cod_punto){
		$csql="		
		DELETE FROM puntos_usuarios 
		WHERE cod_punto = '$cod_punto';
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function actualizarPuntosCod($cod_punto, $puntos){
		$csql = "

		UPDATE puntos_usuarios 
		SET  
		puntos = '$puntos'
		
		WHERE cod_punto = '$cod_punto'
		";

		$obc=new conexion();

		return $obc->consultar($csql);

	}
	
	
	function desactivarCodTemp($cod_temporada){
		$csql = "

		UPDATE temporadas 
		SET  
		estado_temporada = '0'
		
		where cod_temporada = '$cod_temporada'

		";

		$obc=new conexion();

		return $obc->consultar($csql);

	}
	
	function activarCodTemp($cod_temporada){
		$csql = "

		UPDATE temporadas 
		SET  
		estado_temporada = '1'
		
		where cod_temporada = '$cod_temporada'

		";

		$obc=new conexion();

		return $obc->consultar($csql);

	}
	
	
	function verTempBorrada($nom_temporada){

		$csql="		
		SELECT * FROM fechas_borradas
		WHERE nom_temporada = '$nom_temporada' and estado = '1'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	function insertarTempBorrar($nom_temporada, $year_temporada){
		$csql="		
		INSERT INTO fechas_borradas 
		(nom_temporada, year_temporada, estado)
		
		VALUES 
		('$nom_temporada', '$year_temporada', '1')
		";

		$obc=new conexion();
		return $obc->consultar($csql);

	}
	
	function borrarPuntosTemp($temporada){
		$csql="		
		DELETE FROM puntos_usuarios 
		WHERE temporada = '$temporada';
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function verPartidaCod($cod_partida){

		$csql="		
		SELECT * FROM partidas
		WHERE cod_partida = '$cod_partida'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function eliminarPartida($cod_partida){
		$csql="		
		DELETE FROM partidas 
		WHERE cod_partida = '$cod_partida'
		
		";
		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function verificarPartidaLimite($cod_partida){

		$csql="		
		SELECT * FROM partida_players
		WHERE cod_partida = '$cod_partida'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	function unirsePartida($cod_partida, $cod_player){
		$csql="		
		INSERT INTO partida_players 
		(cod_partida, cod_player)
		
		VALUES 
		('$cod_partida', '$cod_player')
		";

		$obc=new conexion();
		return $obc->consultar($csql);

	}
	
	function verUserPartida($cod_player, $cod_partida){

		$csql="		
		SELECT * FROM partida_players
		WHERE cod_partida = '$cod_partida' and cod_player = '$cod_player'
		";

		$obc=new conexion();
		return $obc->consultar($csql);
	}
	
	
	
	/*******************************************/
	
 

	

}