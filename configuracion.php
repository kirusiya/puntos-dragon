<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once('includes/conex.php');
include_once('includes/clases.php');

function configuracion() {
	//require_once(ABSPATH . 'wp-config.php');
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
	
	/*crear temporadas*/
	$errorTemp = 1;
	if(isset($_POST['crearTemporadas']) and $_POST['crearTemporadas']!=""){
		
		$primer_inicio = $_POST['primer_inicio'];
		$primer_fin = $_POST['primer_fin'];
		
		$segunda_inicio = $_POST['segunda_inicio'];
		$segunda_fin = $_POST['segunda_fin'];
		
		$year_temporada = $_POST['year_temporada'];
		$estado_temporada = $_POST['estado_temporada'];
		$nom_temporada = $_POST['nom_temporada'];
		
		if($estado_temporada == 1){
			
			//echo "<br>.<h1>entra a desactivar</h1>".$estado_temporada;
			
			$ob_dt = new cDragon();
			$matriz_dt = $ob_dt -> desactivarTemporadas();
			
		}
		
		/*crear temporada*/
		$ob_it = new cDragon();
		$matriz_it = $ob_it -> insertarTemporada($primer_inicio, $primer_fin, $segunda_inicio, $segunda_fin, $year_temporada, $estado_temporada, $nom_temporada);
		
		$errorTemp = 0;
		/*crear temporada*/
		
	}
	/*crear temporadas*/
	
	
	/*eliminar temporadas*/
	$errorDelete = 1;
	
	if(isset($_GET['delete']) and $_GET['delete']!="" and isset($_GET['cod']) and $_GET['cod']!=""){
		
		/*buscar temporada*/
		$cod_temporada = $_GET['cod'];
		$ob_v = new cDragon();
		$matriz_v = $ob_v -> verCodTemporada($cod_temporada);
		$fila_v = mysqli_fetch_array($matriz_v);
		
		if(isset($fila_v['cod_temporada']) and $fila_v['cod_temporada']!=""){
			
			/*eliminar temporada*/
			$ob_d = new cDragon();
			$matriz_d = $ob_d -> eliminarTemporada($cod_temporada);
			/*eliminar temporada*/

			$errorDelete = 0;
			
		}
		
		/*buscar temporada*/
		
		
		
	}
	
	/*eliminar temporadas*/
	
	
	/*Dar puntos a los usuarios*/
	$errorTransfer = 3;
	
	if(isset($_POST['transfer']) and $_POST['transfer']!=""){
		
		$cod_user = $_POST['cod_reciver'];
		$puntos_transfer = $_POST['monto_transfer'];
		$cod_transferido = $_POST['cod_transferidor'];
		
		$modo_trans = "Por Admin";
		$fecha_transfer = date('Y-m-d H:s');
		$hora_transfer = date('H:s');
		
		
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
				
				
			}else {
				//echo "La fecha actual no está en ninguna temporada conocida.";
				$errorTransfer = 2;
			}



		}else{
			$errorTransfer = 1;
		}		
		
		/*temporada actual*/
		
		
	}
	
	/*Dar puntos a los usuarios*/
	
	/*quitar puntos Usuario*/
	
	if(isset($_GET['delete_puntos']) and $_GET['delete_puntos']!="" and 
	   isset($_GET['cod_reg']) and $_GET['cod_reg']!="" and
	   isset($_GET['puntos']) and $_GET['puntos']!="" and
	   isset($_GET['cod_user']) and $_GET['cod_user']!=""
	  ){
		
		$puntos = $_GET['puntos'];
		$cod_user = $_GET['cod_user'];
		
		$cod_reg = $_GET['cod_reg'];
		
		/*quitar los puntos*/
		$ob_ep = new cDragon();
		$matriz_ep = $ob_ep -> quitarPuntosUsuarios($cod_user, $puntos);
		/*quitar los puntos*/
		
		/*quitar los puntos*/
		$ob_ep = new cDragon();
		$matriz_ep = $ob_ep -> quitarPuntosRegistro($cod_reg);
		/*quitar los puntos*/
		
		
		
	}
	
	
	/*quitar puntos Usuario*/
	
	
	/*desactivar Temporadas*/
	if(isset($_GET['desactivar_temp']) and $_GET['desactivar_temp']!="" and 
	   isset($_GET['cod_temporada']) and $_GET['cod_temporada']!=""
	  ){
		
		$cod_temporada = $_GET['cod_temporada'];
		$ob_ep = new cDragon();
		$matriz_ep = $ob_ep -> desactivarCodTemp($cod_temporada);
	}
	
	/*desactivar Temporadas*/
	
	
	/*activar Temporadas*/
	if(isset($_GET['activar_temp']) and $_GET['activar_temp']!="" and 
	   isset($_GET['cod_temporada']) and $_GET['cod_temporada']!=""
	  ){
		
		$ob_dt = new cDragon();
		$matriz_dt = $ob_dt -> desactivarTemporadas();
		
		$cod_temporada = $_GET['cod_temporada'];
		$ob_ep = new cDragon();
		$matriz_ep = $ob_ep -> activarCodTemp($cod_temporada);
	}
	
	/*activar Temporadas*/
	
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" >

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">

<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> 
<link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet">


<style>
.select2-container .select2-selection--single {
    height: 40px;
}
	
.select2-container .select2-selection--single .select2-selection__rendered {
    padding-top: 5px;
}
	
.select2-container {
    width: 100% !important;
}	
	
.notice,
.fs-notice,
div.fs-notice.updated, 
div.fs-notice.success, 
div.fs-notice.promotion{
    display: none !important;
}		
	
.flatpickr-input[readonly] {
    background: #fff;
	width: 100%;
}	
	
/* Estilo para la tabla con encabezado oscuro */


/* Estilo para las celdas del encabezado */
.dark-header th {
    background-color: #222; /* Fondo oscuro más oscuro */
    color: #fff; /* Texto blanco */
    border-color: #444; /* Borde más oscuro */
}
	
table.dataTable tbody th, table.dataTable tbody td {
    vertical-align: middle;
}	
	
code {
    display: block;
    padding: 30px;
}	
	
</style>        
        

<div class="wrap">
	
	
	<div class="container mt-5">
		
		
		
		<div class="row">
			
			
			<div class="col-md-12 mb-4">
			
				<h1 class="mb-4"><strong>Partidas Épicas Shortcode</strong></h1>
				
				<code>
					Solo tiene que poner el shortcode en una pagina y listo!<br><br>
					=> [partidaepica]<br>
					=> &lt;?php echo do_shortcode("[partidaepica]")?&gt;
				</code>
			</div>
			
			<div class="col-md-12 mb-3 mt-3">
				<hr>
			</div>
			
			
			<!-- configurar temporadas -->
			
			<div class="col-md-6">
				
				<?php 
				if($errorTemp==0){
				?>
				<div class="alert alert-success mb-3">Temporada Creada Correctamente</div>
				<?php 
				}
				?>
				
				
				<h1 class="mb-4"><strong>Configurar Temporadas</strong></h1>
				
				<form action="" method="post" enctype="multipart/form-data">
					
				<div class="row">
					
					
					
					<div class="col-md-6 mb-3">
						
						<div class="date-picker">
							<label for="datepicker1"><strong>Inicio Temp. 1</strong></label>
							<input type="text" id="datepicker1" name="primer_inicio" required  
								   placeholder="Elije Fecha" class="primer_inicio date-input">
						</div>
						
					</div>	
					
					
					<div class="col-md-6 mb-3">
						<div class="date-picker">
							<label for="datepicker2"><strong>Fin Temp. 1</strong></label>
							<input type="text" id="datepicker2" name="primer_fin" required
								   placeholder="Elije Fecha" class="primer_fin date-input">
						</div>
					</div>	
					
					<div class="col-md-6 mb-3">
						<div class="date-picker">
							<label for="datepicker3"><strong>Inicio Temp. 2</strong></label>
							<input type="text" id="datepicker3" name="segunda_inicio" required
								   placeholder="Elije Fecha" class="segunda_inicio date-input">
						</div>
					</div>
					
					<div class="col-md-6 mb-3">
						<div class="date-picker">
							<label for="datepicker4"><strong>Fin Temp. 2</strong></label>
							<input type="text" id="datepicker4" name="segunda_fin" required
								   placeholder="Elije Fecha" class="segunda_fin date-input">
						</div>
					</div>
					
					<div class="col-md-6 mb-3">
						<div class="date-picker">
							<label for="datepicker4"><strong>Año Temporada</strong></label>
							<select name="year_temporada" class="form-control" required>
							
								<?php 
	
								$year = date('Y');
								
								for($i=$year; $i<=2100; $i++){
									
								?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
								<?php
									
								}	
								
								?>
								
							</select>
						</div>
					</div>
					
					<div class="col-md-6 mb-3">
						<div class="date-picker">
							<label for="datepicker4"><strong>Estado Temporada</strong></label>
							<select name="estado_temporada" class="form-control" required>
							
								<option value="0">Temporada Inactiva</option>
								<option value="1">Temporada Activa</option>
								
							</select>
						</div>
					</div>
					
					<div class="col-md-12 mb-3">
						<div class="date-picker">
							<label for="datepicker4"><strong>Nombre Temporada</strong></label>
							<input type="text"  name="nom_temporada" required
								   placeholder="" class="form-control">
						</div>
					</div>
					
					<div class="col-md-12 mb-3">
					
						<input type="hidden" name="crearTemporadas" value="ok">
						<button type="submit" id="btnTemporadas" class="button button-primary">
							Crear Temporada
						</button>
					
					</div>
						
						
					
				</div>	
					
				</form>	
			
			
			</div>
			
			
			<!-- configurar temporadas -->
			
			
			<!-- dar puntos a los usuarios -->
			<div class="col-md-6">	
				<?php 
				if($errorTransfer==0){
				?>
				<div class="alert alert-success">Puntos Agregados al Usuario elegido Correctamente</div> 
				<?php 
				}
				?>
				
				<?php 
				if($errorTransfer==1){
				?>
				<div class="alert alert-danger">No hay Temporadas Activas</div> 
				<?php 
				}
				?>
				
				<?php 
				if($errorTransfer==2){
				?>
				<div class="alert alert-danger">No se encontro la Fecha en ninguna de las Temporadas.<br> Revise la configuracion de las Fechas de las Temporadas</div> 
				<?php 
				}
				?>
	
				<h1 class="mb-4"><strong>Dar Creditos a Usuarios</strong></h1>
				<form method="post" action="" enctype="multipart/form-data" id="formDarPuntos">
					<?php
					// Campo Select2 para buscar usuarios
					$selected_user = get_option( 'mis_puntos_user_id', 0 );

					// Obtener todos los usuarios con rol "customer" o "subscriber"
					$users = get_users(
						array(
							'role__in' => array( 'customer', 'subscriber' ),
							'fields' => array( 'ID', 'user_login', 'user_email', 'display_name' ),
						)
					);


					?>
					<div class="form-group">
						<label for="mis-puntos-user-search"><strong>Seleccionar usuario:</strong></label>
						<select name="cod_reciver" id="mis-puntos-user-search" class="form-control" required>
								<option value="none">-- Busca a un usuario --</option>
							<?php 
									$full_name = "";
									foreach ( $users as $user ) : 
							
									$user_id = $user->ID;
									$first_name = get_user_meta($user_id, 'first_name', true);
									$last_name = get_user_meta($user_id, 'last_name', true);

									if (!empty($first_name) && !empty($last_name)) {
										// El usuario tiene tanto nombre como apellido
										$full_name = $first_name . ' ' . $last_name;
									} elseif (!empty($first_name)) {
										// El usuario tiene solo nombre
										$full_name = $first_name;
									} elseif (!empty($last_name)) {
										// El usuario tiene solo apellido
										$full_name = $last_name;
									} else {
										// El usuario no tiene nombre ni apellido definidos
										$full_name = esc_html( $user->user_login );
									}
							
							?>
							
								<option value="<?php echo esc_attr( $user->ID ); ?>">
									<?php echo $full_name . ' - ' . esc_html( $user->user_email ) . ' - ' . esc_html( $user->display_name ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label for="mis-puntos"><strong>Créditos:</strong></label>

						<input type="number" name="monto_transfer" id="monto_transfer" value="0" class="form-control" required>
						
					</div>

					<p class="submit">
						<?php $user_id = get_current_user_id();?>
						<input type="hidden" name="cod_transferidor" value="<?php echo $user_id;?>">
						<input type="hidden" name="transfer" value="fromAdmin">
						
						<button type="button" id="btnCreditos" class="button button-primary">
							Dar Créditos
						</button>
					</p>
				</form>
			
				
			</div>
			<!-- dar puntos a los usuarios -->
			
			<div class="col-md-12 mb-3 mt-3">
				<hr>
			</div>	
			
			
			
			
			<!-- Tabla de Temporadas -->
			
			<div class="col-md-12">
				
				<?php 
				if($errorDelete==0){
				?>
				<div class="alert alert-success mb-3">Temporada Eliminada Correctamente</div>
				<?php 
				}
				?>
				
				<h1 class="mb-4"><strong>Todas las Temporadas</strong></h1>
			
				<div class="detalle w-100 position-relative table-responsive">
					<table class="tablesResp table table-striped cell-border  table-sm table-borderless  dark-header" style="width: 100%">
						<thead>
							<tr>
								<th class="text-center">Temporada 1</th>
								<th class="text-center">Temporada 2</th>
								<th class="text-center">Año</th>
								
								<th class="text-center">Estado</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>

						<tbody>
							
							<?php 
							
							$ob_v = new cDragon();
							$matriz_v = $ob_v -> verTemporadas();
							$fila_v = mysqli_fetch_array($matriz_v);
	
							$admin_page_url = admin_url('admin.php?page=puntos-dragon');
	
							if(isset($fila_v['cod_temporada']) and $fila_v['cod_temporada']!=""){
							
								do{
									
									$estado_temporadaTXT = '<span class="badge bg-danger text-white">Inactivo</span>';
									
									$actDesButton = '<a href="'.$admin_page_url.'&activar_temp=ok&cod_temporada='.$fila_v['cod_temporada'].'" class="btn btn-dark"><i class="fas fa-check"></i> Activar</a>';
									
									if($fila_v['estado_temporada']==1){
										$estado_temporadaTXT = '<span class="badge bg-success text-white">Activo</span>';
										
										$actDesButton = '<a href="'.$admin_page_url.'&desactivar_temp=ok&cod_temporada='.$fila_v['cod_temporada'].'" class="btn btn-dark"><i class="fas fa-ban"></i> Desactivar</a>';
										
									}
							?>
							<tr>
								<td class="text-center">
									<?php echo "<strong>Inicio:</strong> ".$fila_v['primer_inicio']. "<br><strong>Fin:</strong> ".$fila_v['primer_fin']?>
								</td>
								
								<td class="text-center">
									<?php echo "<strong>Inicio:</strong> ".$fila_v['segunda_inicio']. "<br><strong>Fin:</strong>  ".$fila_v['segunda_fin']?>
								</td>
								
								<td class="text-center">
									<?php echo $fila_v['year_temporada']?>
								</td>

								<td class="text-center">
									<?php echo $estado_temporadaTXT;?>
								</td>

								<td class="text-center">
									
									<?php 
									$admin_page_url = admin_url('admin.php?page=puntos-dragon');
									?>
									
									
									<?php echo $actDesButton;?>
									
									<a href="<?php echo $admin_page_url."&delete=ok&cod=".$fila_v['cod_temporada']?>" class="btn btn-danger">
										<i class="fa-solid fa-trash-can"></i>
									</a>
									
								</td>

							</tr>
							
							<?php 
								}while($fila_v = mysqli_fetch_array($matriz_v));	
							}
							?>
						</tbody>	

					</table>		

				</div>
				
			</div>	
			
			<!-- Tabla de Temporadas -->
			
			<div class="col-md-12 mb-3 mt-3">
				<hr>
			</div>
			
			<!-- Tabla Puntos Usuarios -->
			
			<div class="col-md-12">
				
				<h1 class="mb-4"><strong>Puntos Agregados por Administrador</strong></h1>
			
				<div class="detalle w-100 position-relative table-responsive">
					<table class="tablesResp table table-striped cell-border  table-sm table-borderless  dark-header" style="width: 100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Usuario</th>
								<th class="text-center">Puntos Trans.</th>
								
								<th class="text-center">Fecha Trans.</th>
								<th class="text-center">Temporada</th>
								<!--<th class="text-center">Quitar</th>-->
							</tr>
						</thead>

						<tbody>
							
							<?php 
							
							$ob_v = new cDragon();
							$matriz_v = $ob_v -> puntosPorAdmin();
							$fila_v = mysqli_fetch_array($matriz_v);
							
							$cont = 0;
							if(isset($fila_v['cod_reg']) and $fila_v['cod_reg']!=""){
							
								do{
									$cont++;
									
									$cod_user = $fila_v['cod_user'];
									
									/*datos del usuario*/
									$user_info = get_userdata($cod_user);
									$username = $user_info->user_login;

									// Obtener el correo electrónico
									$email = $user_info->user_email;

									// Obtener el nombre y apellido (si están disponibles)
									$first_name = $user_info->first_name;
									$last_name = $user_info->last_name;

									if (!empty($first_name) && !empty($last_name)) {
										// El usuario tiene tanto nombre como apellido
										$full_name = $first_name . ' ' . $last_name;
									} elseif (!empty($first_name)) {
										// El usuario tiene solo nombre
										$full_name = $first_name;
									} elseif (!empty($last_name)) {
										// El usuario tiene solo apellido
										$full_name = $last_name;
									} else {
										// El usuario no tiene nombre ni apellido definidos
										$full_name = $username;
									}
									/*datos del usuairo*/
							?>
							<tr>
								<td class="text-center"><?php echo $cont;?></td>
								
								<td class="text-center">
									<?php echo "<strong>".$full_name."</strong><br>".$email;?>
								</td>
								
								<td class="text-center">
									<?php echo $fila_v['puntos_transfer']." pts.";?>
								</td>
								
								<td class="text-center">
									<?php echo "<strong>Fecha: </strong>".$fila_v['fecha_transfer'];?>
								</td>

								<td class="text-center">
									<?php echo $fila_v['nom_temporada'];?>
								</td>
								
								<!--<td class="text-center">
									
									<?php 
									$admin_page_url = admin_url('admin.php?page=puntos-dragon');
									?>
									
									
									<a href="<?php echo $admin_page_url."&delete_puntos=ok&cod_reg=".$fila_v['cod_reg']."&puntos=".$fila_v['puntos_transfer']."&cod_user=".$cod_user;?>" class="btn btn-danger">
										<i class="fa-solid fa-trash-can"></i>
									</a>
									
								</td>-->


							</tr>
							
							<?php 
								}while($fila_v = mysqli_fetch_array($matriz_v));	
							}
							?>
						</tbody>	

					</table>		

				</div>
				
			</div>	
			
			<!-- Tabla Puntos Usuarios -->
			
				
		</div>	
		
		
		
		
	</div>	
	
	
	
	
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/es.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<script>

jQuery( document ).ready( function($) { 
	$( "#mis-puntos-user-search" ).select2();
	
	$('#btnCreditos').on('click', function(e) {
        e.preventDefault(); // Evitar el envío automático del formulario
		let monto = parseInt($('#monto_transfer').val());
		
		var selectedValue = $('#mis-puntos-user-search').val();
		
		if (selectedValue !== 'none' && monto > 0) {
			
			// Mostrar cuadro de confirmación
			if (confirm('¿Estás seguro de que deseas dar '+monto+' créditos a este usuario?')) {
				// Si el usuario acepta, enviar el formulario
				$('#formDarPuntos').submit();
			} else {
				// Si el usuario cancela, no hacer nada
				return false;
			}
			
		}else{
			alert('Tiene que elegir un usuario e ingresar el monto!')
		}
		
        
	});
	
	/*tablas*/
	
	$('.tablesResp').DataTable({
		responsive: true,
		//"order": [[ 0, 'desc' ]],
        columnDefs: [
            //{ width: '50px', targets: 0 },
			//{ width: '100px', targets: 1 },
			//{ responsivePriority: 1, targets: 5},
			//{ width: '50%', targets: 2, className: 'txt-cortado' }
        ],
		"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Ver Todos"]],
		language: {
		  "sEmptyTable":     "Sin datos disponibles en la tabla",
		  "sInfo":           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
		  "sInfoEmpty":      "Mostrando 0 a 0 de 0 entradas",
		  "sInfoFiltered":   "(filtrado de un total de _MAX_ entradas)",
		  "sInfoPostFix":    "",
		  "sInfoThousands":  ",",
		  "sLengthMenu":     "Mostrar _MENU_ entradas",
		  "sLoadingRecords": "Cargando...",
		  "sProcessing":     "Procesando...",
		  "sSearch":         "Buscar:",
		  "sZeroRecords":    "No se encontraron coincidencias",
		  "oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		  },
		  "oAria": {
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		  }
		}
	});
	
	/*tablas*/
	
});
	
document.addEventListener('DOMContentLoaded', function() {
    const dateInputs = document.querySelectorAll('.date-input');

    dateInputs.forEach(input => {
        flatpickr(input, {
            dateFormat: 'Y-m-d', // Formato deseado
			locale: 'es',
        });
    });
});
	
	
/*datapicker js*/

document.addEventListener('DOMContentLoaded', function() {
	/*1ra parte temporada*/
	
    const primerInicioInput = document.querySelector('.primer_inicio');
    const primerFinInput = document.querySelector('.primer_fin');
	
	const segundaInicioInput = document.querySelector('.segunda_inicio');
    const segundaFinInput = document.querySelector('.segunda_fin');

    primerInicioInput.addEventListener('change', function() {
        const primerInicioDate = new Date(this.value);
        const primerFinDate = new Date(primerFinInput.value);
		
		const segundaInicioDate_PI = new Date(segundaInicioInput.value);

        if (primerInicioDate >= primerFinDate) {
            alert('La fecha de Inicio Temp. 1 debe ser menor a la fecha de Fin Temp. 1.');
            this.value = ''; // Borra la fecha si no cumple con la validación
        }else if(primerInicioDate >= segundaInicioDate_PI){
			
			alert('La fecha de Inicio Temp. 1 debe ser menor a la fecha de Inicio/Fin Temp. 2.');
            this.value = '';
			
		}
    });

    primerFinInput.addEventListener('change', function() {
        const primerInicioDate = new Date(primerInicioInput.value);
        const primerFinDate = new Date(this.value);
		
		const segundaInicioDate_PI = new Date(segundaInicioInput.value);
		
        if (primerInicioDate >= primerFinDate) {
            alert('La fecha de Fin Temp. 1 debe ser mayor a la fecha de Inicio Temp. 1.');
            this.value = ''; // Borra la fecha si no cumple con la validación
        }else if(primerFinDate >= segundaInicioDate_PI){
			
			alert('La fecha de Fin Temp. 1 debe ser menor a la fecha de Inicio/Fin Temp. 2.');
            this.value = '';
			
		}
    });
	
	/*1ra parte temporada*/
	
	/*2da parte temporada*/
	
    segundaInicioInput.addEventListener('change', function() {
        const segundaInicioDate = new Date(this.value);
        const segundaFinDate = new Date(segundaFinInput.value);
		
		const primerFinDate_PF = new Date(primerFinInput.value);
		
		console.log(segundaInicioDate+' -- '+primerFinDate_PF)
		
		
        if (segundaInicioDate >= segundaFinDate) {
            alert('La fecha de Inicio Temp. 2 debe ser menor a la fecha de Fin Temp. 2.');
            this.value = ''; // Borra la fecha si no cumple con la validación
			
        }else if (segundaInicioDate <= primerFinDate_PF) {
            alert('La fecha de Inicio Temp. 2 debe ser mayor a la fecha de Fin Temp. 1.');
            this.value = ''; 
        }
    });

    segundaFinInput.addEventListener('change', function() {
        const segundaInicioDate = new Date(segundaInicioInput.value);
        const segundaFinDate = new Date(this.value);

        if (segundaInicioDate >= segundaFinDate) {
            alert('La fecha de Fin Temp. 2 debe ser mayor a la fecha de Inicio Temp. 2.');
            this.value = ''; // Borra la fecha si no cumple con la validación
        }
    });
	
	/*2da parte temporada*/
	
	
});
	
	
/*datapicker js*/	

	

</script>

<?php





 

//fin config 
}