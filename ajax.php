<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once('includes/conex.php');
include_once('includes/clases.php');


if(isset($_POST['action']) and $_POST['action']==='traspaso'){
	
	
	$cod_user = $_POST['cod_user'];
	$cod_transferido = $_POST['cod_transferido'];
	$puntos_transfer = $_POST['monto'];
	
	$puntos = $_POST['nuevoMontoCredito'];
	
	
	/*verificar creditos enviados*/
	
	$dia = date('Y-m-d');
	
	$cont_10 = 0;
	$cont_25 = 0;
	$cont_50 = 0;
	
	$totalEnviado = 0;
	
	$ob_ce = new cDragon();
	$matriz_ce = $ob_ce -> verCreditosEnviados($cod_transferido);
	$fila_ce = mysqli_fetch_array($matriz_ce);
	
	if(isset($fila_ce['cod_reg']) and $fila_ce['cod_reg']!=""){
		
		do{
			
			$fecha_transfer = $fila_ce['fecha_transfer'];
			$timestamp = strtotime($fecha_transfer);
			$fecha_transfer_last = date('Y-m-d', $timestamp);
			
			if($fecha_transfer_last === $dia){
				
				$puntos_transfer_ = $fila_ce['puntos_transfer'];
				
				$totalEnviado += $puntos_transfer_;
				
				if($puntos_transfer_==10){
					
					$cont_10++;
					
				}elseif($puntos_transfer_==25){
					
					$cont_25++;
					
				}elseif($puntos_transfer_==50){
					
					$cont_50++;
					
				}
				
				
			}
			
			
		}while($fila_ce = mysqli_fetch_array($matriz_ce));
		
		
		//echo "\n".$cont_10;
		//echo "\n".$cont_25;
		//echo "\n".$cont_50;
		
		//echo "\n".$totalEnviado;
		
		//echo "\n------------";
		
		if($cont_10==5){
			echo "limite";
			exit();
		}elseif($cont_25==4){
			echo "limite";
			exit();
		}elseif($cont_50==2){
			echo "limite";
			exit();
		}else{
			
			$nuevoEnvio = $totalEnviado + $puntos_transfer;
			
			if($nuevoEnvio>100){
				
				echo "limite";
				exit();
			}
			
			
		}
		
		
	}
	//exit();
	
	/*verificar creditos enviados*/
	
	
	
	
	/*temporada actual*/
	$ob_v = new cDragon();
	$matriz_v = $ob_v -> temporadaActiva();
	$fila_v = mysqli_fetch_array($matriz_v);

	if(isset($fila_v['cod_temporada']) and $fila_v['cod_temporada']!=""){

		$fecha_actual = date('Y-m-d');

		$temporada1_inicio = $fila_v['primer_inicio'];
		$temporada1_fin = $fila_v['primer_fin'];

		$temporada2_inicio = $fila_v['segunda_inicio'];
		$temporada2_fin = $fila_v['segunda_fin'];	

		$year_temporada = $fila_v['year_temporada'];
		$temporada = $fila_v['year_temporada'];
		
		$modo_trans = 'Traspaso';
		$fecha_transfer = date('Y-m-d H:s');
		$hora_transfer = date('H:s');
			
		// Comprobar si la fecha actual está dentro de la Temporada 1
		if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
			
			
			
			
			//echo "La fecha actual está en la Temporada 1.";
			$errorTransfer = 0;
				
			/*insertar en los registros*/
			$nom_temporada = "Temporada 1 del ".$year_temporada;
			$ob_v = new cDragon();
			$matriz_v = $ob_v -> insertarRegistro($cod_user, $cod_transferido, $puntos_transfer, $nom_temporada, $modo_trans, $temporada, $fecha_transfer, $hora_transfer);
			/*insertar en los registros*/
				
			/*insertar puntos usuarios*/
			$ob_v = new cDragon();
			$matriz_v = $ob_v -> insertarPuntosUsuarios($cod_user, $puntos_transfer, $nom_temporada);
			/*insertar puntos usuarios*/
			
			/*eliminar todos los creditos del usuairo transferidor*/
			$ob_v = new cDragon();
			$matriz_v = $ob_v -> eliminarPuntosTrans($cod_transferido);
			/*eliminar todos los creditos del usuairo transferidor*/
			
			/*insertar total de creditos del trasnferidor*/
			$ob_v = new cDragon();
			$matriz_v = $ob_v -> insertarPuntosUsuarios($cod_transferido, $puntos, $nom_temporada);
			/*insertar total de creditos del trasnferidor*/
			
			echo "ok";
				
				
		}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
				//echo "La fecha actual está en la Temporada 2.";
				$errorTransfer = 0;
				
				/*insertar en los registros*/
				$nom_temporada = "Temporada 2 del ".$year_temporada;
				$ob_v = new cDragon();
				$matriz_v = $ob_v -> insertarRegistro($cod_user, $cod_transferido, $puntos_transfer, $nom_temporada, $modo_trans, $temporada, $fecha_transfer, $hora_transfer);
				/*insertar en los registros*/
				
				/*insertar puntos usuarios*/
				$ob_v = new cDragon();
				$matriz_v = $ob_v -> insertarPuntosUsuarios($cod_user, $puntos_transfer, $nom_temporada);
				/*insertar puntos usuarios*/
			
				/*eliminar todos los creditos del usuairo transferidor*/
				$ob_v = new cDragon();
				$matriz_v = $ob_v -> eliminarPuntosTrans($cod_transferido);
			
				/*eliminar todos los creditos del usuairo transferidor*/

				/*insertar total de creditos del trasnferidor*/ 
				$ob_v = new cDragon();
				$matriz_v = $ob_v -> insertarPuntosUsuarios($cod_transferido, $puntos, $nom_temporada);
				/*insertar total de creditos del trasnferidor*/	
			
				echo "ok";
				
				
			}else {
				//echo "La fecha actual no está en ninguna temporada conocida.";
				$errorTransfer = 2;
				echo "bad";
			}



		}else{
			$errorTransfer = 1;
			echo "bad";
		}		
		
		/*temporada actual*/
	
	
}


if(isset($_POST['action']) and $_POST['action']==='verPartidasEpicas'){ 
	
	
	$cod_partida = $_POST['cod_partida'];
	
	$ob_v = new cDragon();
	$matriz_v = $ob_v -> verPartidaCod($cod_partida);
	$fila_v = mysqli_fetch_array($matriz_v);
	
	if(isset($fila_v['cod_partida']) and $fila_v['cod_partida']!=""){
		
		
		$nom_partida = $fila_v['nom_partida'];
		$cant_players = $fila_v['cant_players'];
		$lugar_partida = $fila_v['lugar_partida'];
		
		$fecha_partida = $fila_v['fecha_partida'];
		$hora_partida = $fila_v['hora_partida'];
		$link = $fila_v['link'];
		
		
		$cont = '
		
			<h4><strong>'.$nom_partida.'</strong></h4>
			
			<p><strong>Jugadores: </strong>'.$cant_players.'</p>
			<p><strong>Fecha:</strong> '.$fecha_partida.' '.$hora_partida.'</p>
		
		';
		
		if($link !=""){
			$cont .= '
				<p><strong>Link Transmisión:</strong>
					<a href="'.$link.'" target="_blank">Click para Ver</a>
				</p>
			';	
		}
		
		$cont .= '
		
			<div class="lugarPartida">
				<p class="mb-2"><strong>Lugar:</strong></p>
				'.$lugar_partida.'
			</div>
		';
		
		echo $cont;
		
		
	}else{
		
		echo "<h4>Partida Eliminada</h4>";
	}
	
}

if(isset($_POST['action']) and $_POST['action']==='eliminarPartida'){ 
	
	$cod_partida = $_POST['cod_partida'];
	
	$ob_v = new cDragon();
	$matriz_v = $ob_v -> eliminarPartida($cod_partida);
	
}

if(isset($_POST['action']) and $_POST['action']==='registroPartida'){ 
	
	$cod_partida = $_POST['cod_partida'];
	$cod_player = $_POST['cod_player'];
	$nuevo_credito = $_POST['nuevo_credito'];
	$nom_temporada = '';
	
	/*verificamos si el usuario ya se unio*/
	
	$ob_u = new cDragon();
	$matriz_u = $ob_u -> verUserPartida($cod_player, $cod_partida);
	$fila_u = mysqli_fetch_array($matriz_u);
	if(isset($fila_u['cod_player']) and $fila_u['cod_player']!=""){
		
		echo "inscrito";
		exit;
	}
	/*verificamos si el usuario ya se unio*/
	
		/*temporada actual*/
		
		$ob_v = new cDragon();
		$matriz_v = $ob_v -> temporadaActiva();
		$fila_v = mysqli_fetch_array($matriz_v);

		if(isset($fila_v['cod_temporada']) and $fila_v['cod_temporada']!=""){

			$fecha_actual = date('Y-m-d');

			$temporada1_inicio = $fila_v['primer_inicio'];
			$temporada1_fin = $fila_v['primer_fin'];

			$temporada2_inicio = $fila_v['segunda_inicio'];
			$temporada2_fin = $fila_v['segunda_fin'];	

			$year_temporada = $fila_v['year_temporada'];
			$temporada = $fila_v['year_temporada'];
			
			// Comprobar si la fecha actual está dentro de la Temporada 1
			if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
				$nom_temporada = "Temporada 1 del ".$year_temporada;
			}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
				$nom_temporada = "Temporada 2 del ".$year_temporada;
			}
		}		
		
		/*temporada actual*/
	
	/*verificamos si no tiene mas de 4 usuarios*/
	$limitePartida = 4;
	$ob_li = new cDragon();
	$matriz_li = $ob_li -> verPartidaCod($cod_partida);
	$fila_li = mysqli_fetch_array($matriz_li);
	
	if(isset($fila_li['cant_players']) and $fila_li['cant_players']!=""){
		$limitePartida = $fila_li['cant_players'];
	}
	
	
	$cont = 0;
	$ob_v = new cDragon();
	$matriz_v = $ob_v -> verificarPartidaLimite($cod_partida);
	$fila_v = mysqli_fetch_array($matriz_v);
	
	if(isset($fila_v['cod_player']) and $fila_v['cod_player']!=""){
		
		do{
			
			$cont++;
			
		}while($fila_v = mysqli_fetch_array($matriz_v));
	}
	
	if($cont<$limitePartida){		
		$ob_i = new cDragon();
		$matriz_i = $ob_i -> unirsePartida($cod_partida, $cod_player);
		
		/*quitar los creditos*/
		$ob_q = new cDragon();
		$matriz_q = $ob_q -> eliminarPuntosTrans($cod_player);
		/*quitar los creditos*/
		
		/*insertar total de creditos del trasnferidor*/ 
		$ob_n = new cDragon();
		$matriz_n = $ob_n -> insertarPuntosUsuarios($cod_player, $nuevo_credito, $nom_temporada);
		/*insertar total de creditos del trasnferidor*/	
		
		
		echo "ok";
	}else{
		echo "bad";
	}
	
	/*verificamos si no tiene mas de 4 usuarios*/
	
	
	
}
	









