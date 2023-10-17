<?php
/*
  Plugin Name: Puntos de los Productos
  Plugin URI: http://ajamba.org
  Description: Agrega puntos a los productos y cuando el usuario compra un producto que tenga puntos, estos puntos se transfieren al usuario. También el Administrador puede dar puntos, los usuarios pueden trasnsferirse puntos entre si.
  Version: 1.0
  Author: Ing. Edward Avalos
  Author URI: http://ajamba.org

 */ 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $wpdb;


/*datos extras*/
function prefix_append_support_and_faq_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
	if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {

		// You can still use `array_unshift()` to add links at the beginning.
		$links_array[] = '<a href="https://wa.me/59161781119" target="_blank"><span class="dashicons dashicons-whatsapp"></span> Enviame un Mensaje</a>';
		$links_array[] = '<a href="https://www.facebook.com/ajamba.web.1" target="_blank"><span class="dashicons dashicons-facebook"></span> Visita mi Facebook</a>';
		$links_array[] = '<a href="https://ajamba.org" target="_blank"><span class="dashicons dashicons-admin-links"></span> Visita mi Web</a>';
	}
 
	return $links_array;
}

add_filter( 'plugin_row_meta', 'prefix_append_support_and_faq_links', 10, 4 );

/*datos extras*/

/*agrear css y js al admin del plugin*/
add_action('admin_head', 'css_ajamba_admin_logo');
function css_ajamba_admin_logo() {
    ?>
<style>
li#toplevel_page_puntos-dragon .wp-menu-image::before {
    content: ' ';
    background-image: url(<?php echo plugins_url( basename( __DIR__ ) . '/img/ajamba.jpg' ); ?>);
    background-clip: content-box;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 25px;
    width: 25px;
    height: 25px;
    margin-top: 5px;
    padding: 0;
    border-radius: 50%;
}        
</style>
    <?php
}

/*agrear css y js al admin del plugin*/
/*====admin====*/

/*tabla puntos*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS puntos_usuarios (

  	`cod_punto` int(11) NOT NULL AUTO_INCREMENT,
	`puntos` text NOT NULL,
	`cod_user` text NOT NULL,
	`temporada` text NOT NULL,

  PRIMARY KEY  (cod_punto)

) $charset_collate;";
dbDelta( $sql );
/*tabla puntos*/


/*registro puntos*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS registro_puntos (

  	`cod_reg` int(11) NOT NULL AUTO_INCREMENT,
	`cod_user` text NOT NULL,
	`cod_transferido` text NOT NULL,
	`puntos_transfer` text NOT NULL,
	
	`nom_temporada` text NOT NULL,
	`modo_trans` text NOT NULL,
	`temporada` text NOT NULL,
	
	`fecha_transfer` text NOT NULL,
	`hora_transfer` text NOT NULL,

  PRIMARY KEY  (cod_reg)

) $charset_collate;";
dbDelta( $sql );

/*registro puntos*/


/*tabla temporada*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS temporadas (

  	`cod_temporada` int(11) NOT NULL AUTO_INCREMENT,
	`nom_temporada` text NOT NULL,
	
	`primer_inicio` text NOT NULL,
	`primer_fin` text NOT NULL,
	
	`segunda_inicio` text NOT NULL,
	`segunda_fin` text NOT NULL,
	
	`estado_temporada` text NOT NULL,
	`year_temporada` text NOT NULL,

  PRIMARY KEY  (cod_temporada)

) $charset_collate;";
dbDelta( $sql );
/*tabla temporadas*/

/*tabla temporadas borradas*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS fechas_borradas (

  	`cod_fecha` int(11) NOT NULL AUTO_INCREMENT,
	`nom_temporada` text NOT NULL,
	`year_temporada` text NOT NULL,
	
	`estado` text NOT NULL,

  PRIMARY KEY  (cod_fecha)

) $charset_collate;";
dbDelta( $sql );
/*tabla temporadas borradas*/

/*tabla partidas*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS partidas (

  	`cod_partida` int(11) NOT NULL AUTO_INCREMENT,
	`nom_partida` text NOT NULL,
	`cod_creador` text NOT NULL,
	
	`cant_players` text NOT NULL,
	`lugar_partida` text NOT NULL,
	`fecha_partida` text NOT NULL,
	
	`flag` text NOT NULL,
  	`link` text NOT NULL,
  	`hora_partida` text NOT NULL,

  PRIMARY KEY  (cod_partida)

) $charset_collate;";
dbDelta( $sql );
/*tabla partidas*/

/*tabla registro_partidas*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS partidas_registro (

  	`cod_registro` int(11) NOT NULL AUTO_INCREMENT,
	
	`cod_partida` text NOT NULL,	
	`nom_partida` text NOT NULL,
	`cod_creador` text NOT NULL,
	
	`cant_players` text NOT NULL,
	`lugar_partida` text NOT NULL,
	`fecha_partida` text NOT NULL,
	
	`link` text NOT NULL,
  	`hora_partida` text NOT NULL,
	

  PRIMARY KEY  (cod_registro)

) $charset_collate;";
dbDelta( $sql );
/*tabla registro_partidas*/

/*tabla partida_players*/
$charset_collate = $wpdb->get_charset_collate();

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

$sql = "CREATE TABLE IF NOT EXISTS partida_players (

  	`cod_pp` int(11) NOT NULL AUTO_INCREMENT,
	`cod_partida` text NOT NULL,
	`cod_player` text NOT NULL,
	

  PRIMARY KEY  (cod_pp)

) $charset_collate;";
dbDelta( $sql );
/*tabla partida_players*/



//$wpdb->query("ALTER TABLE partidas ADD hora_partida TEXT NOT NULL;");
//$wpdb->query("ALTER TABLE partidas_registro ADD hora_partida TEXT NOT NULL;");

//$wpdb->query("DELETE FROM fechas_borradas where 1");
//$wpdb->query("DELETE FROM partidas_registro where 1");

//$wpdb->query("DROP TABLE transfer");

//$wpdb->query("DELETE FROM puntos_usuarios where cod_punto!=''");

//$wpdb->query("UPDATE puntos_usuarios SET temporada = 'Temporada 1 del 2023' 
//where cod_punto = '57' or cod_punto = '59' or cod_punto = '61' "); 

//$wpdb->query("UPDATE registro_puntos SET nom_temporada = 'Temporada 2 del 2023' 
//where cod_reg = 43");

//$wpdb->query("UPDATE registro_puntos SET nom_temporada = 'Temporada 2 del 2023' 
//where cod_reg = 52");



/*******coloca un menu al admin*********/ 
add_action('admin_menu', 'config_puntos');

function config_puntos() {
    add_menu_page('config_puntos', //page title
            'Créditos Dragon', //menu title
            'manage_options', //capabilities
            'puntos-dragon', //menu slug
            'configuracion' //function
    );
	
	
}
/*******coloca un menu al admin*********/

/*******rutas de archivos*********/ 
define('ROOTDIR_DP_AJA', plugin_dir_path(__FILE__)); 
require_once(ROOTDIR_DP_AJA . 'configuracion.php');
require_once(ROOTDIR_DP_AJA . 'ajax.php');
require_once(ROOTDIR_DP_AJA . 'includes/conex.php');
/*******rutas de archivos*********/


/*******funciones necesarias*********/

/*agregar puntos a los productos*/

// Mostrar los puntos guardados en el campo "Puntos del producto"
function mostrar_puntos_producto() {
    global $woocommerce, $post;
    $puntos_producto = get_post_meta( $post->ID, '_puntos_producto', true );
	
	
	
    ?>
    <div class="options_group">
        <?php
        woocommerce_wp_text_input(
            array(
                'id'          => '_puntos_producto',
                'label'       => __( 'Créditos del producto', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Ingresa los créditos correspondientes a este producto.', 'woocommerce' ),
                'type'        => 'number',
                'value'       => $puntos_producto, // Mostrar los puntos guardados
            )
        );
        ?>
    </div>
    <?php
}
add_action( 'woocommerce_product_options_general_product_data', 'mostrar_puntos_producto' );

// Guardar el valor del campo en los metadatos del producto
function guardar_puntos_producto( $post_id ) {
    $puntos_producto = isset( $_POST['_puntos_producto'] ) ? sanitize_text_field( $_POST['_puntos_producto'] ) : '';
    update_post_meta( $post_id, '_puntos_producto', $puntos_producto );
}
add_action( 'woocommerce_process_product_meta', 'guardar_puntos_producto' );

/*agregar puntos a los productos*/


/*solo un producto con la categoria puntos*/

function limitar_un_producto_por_categoria_al_carrito( $valid, $product_id, $quantity ) {
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query;
    // Obtener la categoría que deseas verificar (en este caso, "puntos")
    $categoria_a_verificar = 'puntos';

    // Verificar si el producto a agregar pertenece a la categoría deseada
    if ( has_term( $categoria_a_verificar, 'product_cat', $product_id ) ) {
        // Verificar si ya existe un producto de la misma categoría en el carrito
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $cart_product_id = $cart_item['product_id'];
            if ( has_term( $categoria_a_verificar, 'product_cat', $cart_product_id ) ) {
                // Ya existe un producto de la categoría "puntos" en el carrito, evitar agregar otro
                wc_add_notice( 'Solo se permite agregar un producto de este tipo en el carrito.', 'error' );
                return false;
            }
        }
    }

    return $valid;
}

add_filter( 'woocommerce_add_to_cart_validation', 'limitar_un_producto_por_categoria_al_carrito', 10, 3 );


/*solo un producto con la categoria puntos*/


/*no permitir cambiar la cantidad de producto*/

/**
 * Limitar la cantidad de productos en la categoría "puntos" en el carrito de WooCommerce.
 */
function limitar_cantidad_de_producto_por_categoria( $cart ) {
    // Definir la categoría que deseas verificar (en este caso, "puntos")
    $categoria_a_verificar = 'puntos';

    // Inicializar una variable para realizar un seguimiento de la cantidad de productos en la categoría "puntos"
    $cantidad_productos_puntos = 0;

    // Recorrer los elementos del carrito
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
        $product_id = $cart_item['product_id'];

        // Verificar si el producto en el carrito pertenece a la categoría deseada
        if ( has_term( $categoria_a_verificar, 'product_cat', $product_id ) ) {
            $cantidad_productos_puntos += $cart_item['quantity'];
        }
    }

    // Verificar si hay más de un producto en la categoría "puntos" en el carrito
    if ( $cantidad_productos_puntos > 1 ) {
        // Mostrar un mensaje de error y ajustar la cantidad a 1 para todos los productos en la categoría "puntos"
        wc_add_notice( 'Solo se permite agregar un producto de este tipo en el carrito.', 'error' );

        // Ajustar la cantidad a 1 para todos los productos en la categoría "puntos"
        foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
            $product_id = $cart_item['product_id'];

            if ( has_term( $categoria_a_verificar, 'product_cat', $product_id ) ) {
                $cart->set_quantity( $cart_item_key, 1 );
            }
        }
    }
}

add_action( 'woocommerce_before_calculate_totals', 'limitar_cantidad_de_producto_por_categoria' );




/*no permiter cambiar la cantidad de producto*/



/*verficar si esta pagado en el thank you*/

add_action( 'woocommerce_thankyou', 'verificar_pago_despues_del_pedido', 10, 1 );

function verificar_pago_despues_del_pedido( $order_id ) {
	
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query;
	
    // Obtener el objeto del pedido
    $order = wc_get_order( $order_id );
	
	$user_id = $order->get_user_id();
	
	$temporada_year = date('Y-m-d');
    $total_puntos = 0;

    // Verificar si el pago está completo
    if ( $order->is_paid() ) {
        
		/**********************************************/
		
		// Si el usuario está registrado
		if ( $user_id ) {

			foreach ( $order->get_items() as $item_id => $item ) {
				$product_id = $item->get_product_id();
				$puntos_producto = get_post_meta( $product_id, '_puntos_producto', true );

				// Si el producto tiene puntos asociados, agregarlos al total
				if ( $puntos_producto ) {
					$total_puntos += intval( $puntos_producto );
				}
			}



			if ( $total_puntos > 0 ) {
				global $wpdb;

				

				// Insertar los datos en la tabla registro_puntos
				$tabla_registro_puntos = 'registro_puntos';
				$fecha_actual = date( 'Y-m-d' );

				$temporada = $wpdb->get_results("SELECT nom_temporada, primer_inicio, primer_fin,
													segunda_inicio, segunda_fin, estado_temporada, year_temporada

													FROM temporadas
													WHERE estado_temporada = 1 ");

				if($temporada){

					foreach ($temporada as $temp){
						$temporada1_inicio = $temp->primer_inicio;
						$temporada1_fin = $temp->primer_fin;

						$temporada2_inicio = $temp->segunda_inicio;
						$temporada2_fin = $temp->segunda_fin;	

						$year_temporada = $temp->year_temporada;
						$temporada = $temp->year_temporada;

					}


					/*obtener en que temporada esta*/
					if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
						$nom_temporada = "Temporada 1 del ".$year_temporada;
					}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
						$nom_temporada = "Temporada 2 del ".$year_temporada;
					}
					/*obtener en que temporada esta*/

				}else{

					$nom_temporada = ( date( 'm', strtotime( $fecha_actual ) ) >= 6 ) ? 'Temporada 2' : 'Temporada 1';
					$nom_temporada .= ' del ' . date( 'Y', strtotime( $fecha_actual ) );

					$year_temporada = date('Y');

				}

				$fecha_transfer = date('Y-m-d H:s');
				$hora_transfer = date('H:s');

				$wpdb->insert(
					$tabla_registro_puntos,
					array(
						'cod_user'      	=> $user_id,
						'cod_transferido' 	=> 0,
						'puntos_transfer' 	=> $puntos_producto,

						'nom_temporada' 	=> $nom_temporada,
						'modo_trans'    	=> 'Compra de producto',
						'temporada' 		=> $year_temporada,

						'fecha_transfer' 	=> $fecha_transfer,
						'hora_transfer' 	=> $hora_transfer,
					),
					array( '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%s' )
				);

				/* Insertar los datos en la tabla puntos_usuarios y registro puntos*/
				
				// Insertar los datos en la tabla puntos_usuarios y registro puntos
				$tabla_puntos_usuarios = 'puntos_usuarios';

				$wpdb->insert(
					$tabla_puntos_usuarios,
					array(
						'cod_user' => $user_id,
						'puntos'   => $puntos_producto,
						'temporada'   => $nom_temporada,
					),
					array( '%d', '%d', '%s' )
				);
			}
		}
		/**********************************************/
		
		
    } else {
        // El pago no está completo
        // Puedes tomar acciones diferentes en este caso si es necesario
    }
}



/*verficar si esta pagado en el thank you*/



/*agregar puntos desde el admin*/

function agregar_puntos_desde_admin( $post_id, $post, $update ) {
	
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
   
    // Obtener el objeto de la orden
    $order = wc_get_order( $post_id );

    // Verificar si el estado cambió a "completed" y antes no estaba en "completed"
    if ( isset( $_POST['order_status'] ) && $_POST['order_status'] == 'wc-completed' ) {
        // Obtener el producto asociado a la orden
        $items = $order->get_items();
        $puntos_producto = 0;

        foreach ( $items as $item ) {
            $product_id = $item->get_product_id();
            $puntos_producto += get_post_meta( $product_id, '_puntos_producto', true );
        }

        $user_id = $order->get_user_id();

        // Si el producto tiene puntos asociados y el usuario está registrado
        if ( $puntos_producto > 0 && $user_id ) {
            global $wpdb;
			
            /* Insertar los datos en la tabla puntos_usuarios y registro puntos*/
			

            // Insertar los datos en la tabla log_puntos
			$tabla_registro_puntos = 'registro_puntos';
			$fecha_actual = date( 'Y-m-d' );
			
			$temporada = $wpdb->get_results("SELECT nom_temporada, primer_inicio, primer_fin,
												segunda_inicio, segunda_fin, estado_temporada, year_temporada
												
												FROM temporadas
												WHERE estado_temporada = 1 ");
		
			if($temporada){

				foreach ($temporada as $temp){
					$temporada1_inicio = $temp->primer_inicio;
					$temporada1_fin = $temp->primer_fin;

					$temporada2_inicio = $temp->segunda_inicio;
					$temporada2_fin = $temp->segunda_fin;	

					$year_temporada = $temp->year_temporada;
					$temporada = $temp->year_temporada;

				}
				
				
				/*obtener en que temporada esta*/
				if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
					$nom_temporada = "Temporada 1 del ".$year_temporada;
				}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
					$nom_temporada = "Temporada 2 del ".$year_temporada;
				}
				/*obtener en que temporada esta*/

			}else{
				
				$nom_temporada = ( date( 'm', strtotime( $fecha_actual ) ) >= 6 ) ? 'Temporada 2' : 'Temporada 1';
				$nom_temporada .= ' del ' . date( 'Y', strtotime( $fecha_actual ) );
				
				$year_temporada = date('Y');
				
			}
			
			$fecha_transfer = date('Y-m-d H:s');
			$hora_transfer = date('H:s');
			
            $wpdb->insert(
                $tabla_registro_puntos,
                array(
					'cod_user'      	=> $user_id,
					'cod_transferido' 	=> 0,
                    'puntos_transfer' 	=> $puntos_producto,
					
					'nom_temporada' 	=> $nom_temporada,
                    'modo_trans'    	=> 'Compra de producto',
					'temporada' 		=> $year_temporada,
					
					'fecha_transfer' 	=> $fecha_transfer,
					'hora_transfer' 	=> $hora_transfer,
                ),
                array( '%d', '%d', '%d', '%s', '%s', '%d', '%s', '%s' )
            );
			
			$tabla_puntos_usuarios = 'puntos_usuarios';
			
            $wpdb->insert(
                $tabla_puntos_usuarios,
                array(
                    'cod_user' => $user_id,
                    'puntos'   => $puntos_producto,
					'temporada' => $nom_temporada,
                ),
                array( '%d', '%d', '%s' )
            );
			
			/* Insertar los datos en la tabla puntos_usuarios y registro puntos*/
        }
    }
}
add_action( 'save_post', 'agregar_puntos_desde_admin', 10, 3 );



/*agregar puntos desde el admin*/


/*ver los puntos en la orden*/

// Función para obtener los puntos del producto => debajo del articulo
add_action( 'woocommerce_before_order_itemmeta', 'unit_before_order_itemmeta', 10, 3 );
function unit_before_order_itemmeta( $item_id, $item, $product ){
    // Only "line" items and backend order pages
    if( ! ( is_admin() && $item->is_type('line_item') ) ) return;

    $unit = $product->get_meta('_puntos_producto');
    if( ! empty($unit) ) {
        echo '<p>Créditos: '.$unit.'</p>';
    }
}


/*ver los puntos en la orden*/


/*agregar los puntos a un nuevo menu de mi cuenta de woocommerce*/

// Crea el nuevo menú "Mis Puntos" en My Account
function mis_puntos_menu_item( $items ) {
    // Agregamos el nuevo ítem de menú al array
    $new_items = array(
        'mis-creditos' => 'Mis Créditos',
    );

    // Encontramos la posición del menú "Salir"
    $logout_position = array_search( 'customer-logout', array_keys( $items ) );

    // Insertamos el nuevo ítem justo antes del menú "Salir"
    if ( $logout_position !== false ) {
        $items = array_slice( $items, 0, $logout_position, true ) + $new_items + array_slice( $items, $logout_position, null, true );
    } else {
        // Si no se encuentra el menú "Salir", simplemente lo agregamos al final
        $items = array_merge( $items, $new_items );
    }

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'mis_puntos_menu_item', 10, 1 );


// Crea la página para mostrar los puntos ganados
function mis_puntos_page_content() {
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
    $user_id = get_current_user_id();
    $puntos_ganados = obtener_puntos_ganados( $user_id );
	
	

    echo '<h2><strong><i class="fa-solid fa-coins"></i> Mis Créditos</strong></h2>';
    echo '<strong>Créditos ganados:</strong> ' . $puntos_ganados . '';
	
	echo '
	
		<div class="row creditosTempActual">
		
			<div class="col-md-12 mt-5 mb-4"><hr></div>
			
			
			<!--traspasar creditos-->
			
			<div class="col-md-12">
				<h3><strong><i class="fa-solid fa-user-plus"></i> Traspasar Crédito</strong></h3>
				
				<a href="#0" id="verLimites" class="mb-4">Ver Límites diarios</a>
				
			</div>
			
			<div class="col-md-12">
				<div class="alert alert-success mt-3 mb-3 text-center alertTraspaso"  style="display:none;">
					<i class="fas fa-check-circle"></i> Traspaso realizado Correctamente!
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="alert alert-danger mt-3 mb-3 text-center traspasoError"  style="display:none;">
					<i class="fas fa-times-circle"></i> Algo paso. Intente en unos minutos!
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="alert alert-danger mt-3 mb-3 text-center traspasoLimite"  style="display:none;">
					<i class="fas fa-times-circle"></i> Llegaste al Limite diario de Traspasos Diarios.
				</div>
			</div>
			
			<div class="col-md-12 text-center">
				<img src="'.plugins_url( basename( __DIR__ ) . '/img/loader.gif' ).'" width="70" height="70" style="margin:0 auto;display:none;" id="loaderTras">
			</div>
			
			<div class="col-8 col-md-5 mb-3">
			
				
	';
			$users = get_users(
					array(
						'role__in' => array( 'customer', 'subscriber' ),
						'fields' => array( 'ID', 'user_login', 'user_email', 'display_name' ),
					)
			);
	
	echo '
	
	
				<label>Busque Usuario</label>
				<select name="cod_reciver" id="mis-puntos-user-search" class="form-control w-100" required>
				
					<option value="none">-- Busca a un usuario --</option>
	
	';
				$current_user_id = get_current_user_id();
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
						$full_name = esc_html( $user->display_name );
					}
	
					$userID = $user->ID;
					if($current_user_id!=$userID){
	echo '
					<option value="'.esc_attr( $user->ID ).'">
					
						'.esc_html( $user->user_login ).' - '.esc_html( $user->user_email ).' - '.$full_name.'
					
					</option>
	';				
					}	
	
				endforeach;
	
	echo '
				
				
				</select>
			
			</div>
			
			<div class="col-4 col-md-4 mb-3">
			
				<label for="mis-puntos"><strong>Créditos:</strong></label>


				<select class="form-control"  name="monto_transfer" id="monto_transfer">
				
					<option value="10">10 Créditos</option>
					<option value="25">25 Créditos</option>
					<option value="50">50 Créditos</option>
				
				</select>
				
			
			</div>
			
			<div class="col-12 col-md-3 btnTraspaso mb-3">
			
			
	';
			$user_id = get_current_user_id();
	
	
			/*todos los creditos del usuario*/
	
			
	
	echo '
				<input type="hidden" id="totalCreditos" value="'.$puntos_ganados.'">
				<input type="hidden" id="cod_transferido" value="'.$user_id.'">
			
				<button type="button" id="traspasar" class="fl-button secondary-button w-100 ">Traspasar</button>

			
			</div>
			
			<!--traspasar creditos-->
			
			
			<!-- modal limite traspasos -->
			<div class="modal fade" id="limitesTraspasoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle"><strong>Límites de Traspaso</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
				  
				  	<h6><strong>Transferencias Diarias</strong></h6>
					
					<p>1.- Solo puedes enviar 5 Transferencias de 10 Créditos</p>
					<p>2.- Solo puedes enviar 4 Transferencias de 25 Créditos</p>
					<p>3.- Solo puedes enviar 2 Transferencias de 50 Créditos</p>
					<p>4.- No puedes enviar más de 100 Créditos por día</p>
					
					
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- modal limite traspasos -->			
			
			
			<div class="col-md-12 mt-5 mb-4"><hr></div>
			
			<!--Tabla creditos temporada Actual-->
			
			
	';			
	
			$fecha_actual = date( 'Y-m-d' );
			$nom_temporada ="";
			
			$temporada = $wpdb->get_results("SELECT nom_temporada, primer_inicio, primer_fin,
												segunda_inicio, segunda_fin, estado_temporada, year_temporada
												
												FROM temporadas
												WHERE estado_temporada = 1 ");
		
			if($temporada){

				foreach ($temporada as $temp){
					$temporada1_inicio = $temp->primer_inicio;
					$temporada1_fin = $temp->primer_fin;

					$temporada2_inicio = $temp->segunda_inicio;
					$temporada2_fin = $temp->segunda_fin;	

					$year_temporada = $temp->year_temporada;
					$temporada = $temp->year_temporada;

				}
				
				
				/*obtener en que temporada esta*/
				if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
					$nom_temporada = "Temporada 1 del ".$year_temporada;
				}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
					$nom_temporada = "Temporada 2 del ".$year_temporada;
				}
				
				/*obtener en que temporada esta*/

			}else{
				
				$nom_temporada = ( date( 'm', strtotime( $fecha_actual ) ) >= 6 ) ? 'Temporada 2' : 'Temporada 1';
				$nom_temporada .= ' del ' . date( 'Y', strtotime( $fecha_actual ) );
				
			}
	
	
	echo '
			
			<div class="col-12">
			
				<h3><strong>Reporte Temporada Actual</strong></h3>
				
				
				
				<table class="tablesResp table table-striped table-sm dark-header" style="width: 100%">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Temporada</th>
							<th class="text-center">Metodo</th>
							
							<th class="text-center">Fecha</th>
							<th class="text-center">Creditos</th>
							
						</tr>
					</thead>
					
					<tbody>
					
	';
	
	/******************************************************************/
			$user_id = get_current_user_id();
	
	
			$creditosTempActual = $wpdb->get_results("SELECT cod_reg, cod_user, cod_transferido, 
											puntos_transfer, nom_temporada, modo_trans, temporada,
											fecha_transfer
												
											FROM registro_puntos
											WHERE  
											nom_temporada = '$nom_temporada' and (cod_user = '$user_id' or cod_transferido = '$user_id')
											
											order by cod_reg desc
											");
		
			if($creditosTempActual){
				
				$cont = 0;
				foreach ($creditosTempActual as $datos){
					
					$cont++;
					
					$nom_temporada = $datos->nom_temporada;
					$modo_trans = $datos->modo_trans;
					
					$cod_user = $datos->cod_user;
					$cod_transferido = $datos->cod_transferido;
					$puntos_transfer = $datos->puntos_transfer;
					
					
					$fecha_transfer = $datos ->fecha_transfer;
					$fecha_formateada = date("Y-m-d", strtotime($fecha_transfer));
					$fecha_formateada;
					
					if($cod_user==$user_id){
						
						$credito = '<h6><span class="label label-success">+ '.$puntos_transfer.'  Cred.</span></h6>';
						
					}elseif($cod_transferido == $user_id){
						
						$credito = '<h6><span class="label label-danger">- '.$puntos_transfer.'  Cred.</span></h6>';
						
					}

						 
	
	
	/******************************************************************/
	
	
	echo '
					
						<tr class="text-center">
							<td>'.$cont.'</td>
							<td>'.$nom_temporada.'</td>
							<td>'.$modo_trans.'</td>
							
							<td>'.$fecha_formateada.'</td>
							<td>'.$credito.'</td>
							
						</tr>	
	';
	
	/******************************************************************/
	
				}
				
				
			}
	
	/******************************************************************/
	
	echo '
							
							
						
						
					</tbody>
					
				</table>	
			
			
			</div>
			
			<!--Tabla creditos temporada Actual-->
			
			
			
			<div class="col-md-12 mt-5 mb-4"><hr></div>
			<!--Tabla creditos TODAS LAS TEMPORADAS-->
			
		';
		
		echo '
			
			<div class="col-12">
			
				<h3><strong>Reporte Todas las Temporada</strong></h3>
				
				
				
				<table class="tablesResp table table-striped table-sm dark-header" style="width: 100%">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Temporada</th>
							<th class="text-center">Metodo</th>
							
							<th class="text-center">Fecha</th>
							<th class="text-center">Creditos</th>
							
						</tr>
					</thead>
					
					<tbody>
					
	';
	
	/******************************************************************/
			$user_id = get_current_user_id();
	
	
			$creditosTempAll = $wpdb->get_results("SELECT cod_reg, cod_user, cod_transferido, 
											puntos_transfer, nom_temporada, modo_trans, temporada,
											fecha_transfer
												
											FROM registro_puntos
											WHERE  
											cod_user = '$user_id' or cod_transferido = '$user_id'
											
											order by cod_reg desc
											");
		
			if($creditosTempAll){
				
				$cont = 0;
				foreach ($creditosTempAll as $datos){
					
					$cont++;
					
					$nom_temporada = $datos->nom_temporada;
					$modo_trans = $datos->modo_trans;
					
					$cod_user = $datos->cod_user;
					$cod_transferido = $datos->cod_transferido;
					$puntos_transfer = $datos->puntos_transfer;
					
					
					$fecha_transfer = $datos ->fecha_transfer;
					$fecha_formateada = date("Y-m-d", strtotime($fecha_transfer));
					$fecha_formateada;
					
					if($cod_user==$user_id){
						
						$credito = '<h6><span class="label label-success">+ '.$puntos_transfer.'  Cred.</span></h6>';
						
					}elseif($cod_transferido == $user_id){
						
						$credito = '<h6><span class="label label-danger">- '.$puntos_transfer.'  Cred.</span></h6>';
						
					}

						 
	
	
	/******************************************************************/
	
	
	echo '
					
						<tr class="text-center">
							<td>'.$cont.'</td>
							<td>'.$nom_temporada.'</td>
							<td>'.$modo_trans.'</td>
							
							<td>'.$fecha_formateada.'</td>
							<td>'.$credito.'</td>
							
						</tr>	
	';
	
	/******************************************************************/
	
				}
				
				
			}
	
	/******************************************************************/
	
	echo '
							
							
						
						
					</tbody>
					
				</table>	
			
			
			</div>	
			
			<!--Tabla creditos TODAS LAS TEMPORADAS-->
			
			
			
			
			
		
		</div>
		
	
	';
	
	
	
}
add_action( 'woocommerce_account_mis-creditos_endpoint', 'mis_puntos_page_content' );

// Función para obtener los puntos ganados del usuario desde la tabla puntos_usuarios
function obtener_puntos_ganados( $user_id ) {
    global $wpdb;
    $tabla_puntos_usuarios = 'puntos_usuarios';

    $puntos_ganados = 0;
	
	
	$all_puntos = $wpdb->get_results("SELECT puntos FROM $tabla_puntos_usuarios 
										WHERE cod_user = '$user_id' ");
		
	if($all_puntos){

		foreach ($all_puntos as $puntos){
			$puntos_ganados += $puntos->puntos;
		}

	}

    return $puntos_ganados;
}


// Agrega la ruta para la página de Mis Puntos
function mis_creditos_endpoint() {
    add_rewrite_endpoint( 'mis-creditos', EP_PAGES );
}
add_action( 'init', 'mis_creditos_endpoint' );


// Actualiza las reglas de reescritura para mostrar la página de Mis Puntos
function mis_puntos_flush_rewrite_rules() {
    mis_creditos_endpoint();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mis_puntos_flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );


/*agregar los puntos a un nuevo menu de mi cuenta de woocommerce*/

/*agregar css y js a la pagina mis puntos*/
// Registrar y encolar los estilos y scripts de DataTables y DataTables Responsive
function mis_puntos_enqueue_assets() {
    // Registrar DataTables CSS
    wp_register_style( 'datatables', 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css', array(), '1.11.5' );

    // Registrar DataTables Responsive CSS
    wp_register_style( 'datatables-responsive', 'https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css', array(), '2.2.9' );

    // Registrar DataTables JS
    wp_register_script( 'datatables', 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', array( 'jquery' ), '1.11.5', true );

    // Registrar DataTables Responsive JS
    wp_register_script( 'datatables-responsive', 'https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js', array( 'datatables' ), '2.2.9', true );
	
	
	wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2' );
	
	wp_register_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array(), '4.5.2' );
	
	wp_register_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', array(), '6.3.0' );
	
	wp_register_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css', array(), '4.1.0' );

    wp_register_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.full.min.js', array( 'jquery' ), '4.1.0', true );
	
	// Registra el script de TinyMCE desde la CDN
    wp_register_script('tinymce', 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.7.0/tinymce.min.js', array(), '6.7.0');

	
	$current_url = home_url( add_query_arg( null, null ) ); // Obtener la URL actual
    $my_account_url = wc_get_page_permalink( 'myaccount' );
	
    if ( strpos( $current_url, $my_account_url ) !== false && strpos( $current_url, '/mis-creditos/' ) !== false ) {
        wp_enqueue_style( 'datatables' );
        wp_enqueue_style( 'datatables-responsive' );
        wp_enqueue_script( 'datatables' );
        wp_enqueue_script( 'datatables-responsive' );
		
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_script( 'bootstrap' );
		
		wp_enqueue_style( 'font-awesome' );
		
		wp_enqueue_style( 'select2' );
        wp_enqueue_script( 'select2' );
    }
	
	if ( strpos( $current_url, $my_account_url ) !== false && strpos( $current_url, '/partidas-epicas/' ) !== false ) {
        wp_enqueue_style( 'datatables' );
        wp_enqueue_style( 'datatables-responsive' );
        wp_enqueue_script( 'datatables' );
        wp_enqueue_script( 'datatables-responsive' );
		
		//wp_enqueue_style( 'bootstrap' );
		//wp_enqueue_script( 'bootstrap' );
		
		wp_enqueue_style( 'font-awesome' );
		
		wp_enqueue_style( 'select2' );
        wp_enqueue_script( 'select2' );
		
		wp_enqueue_script('tinymce');
    }
	
	if ( is_front_page() ) {
        wp_enqueue_style( 'datatables' );
        wp_enqueue_style( 'datatables-responsive' );
        wp_enqueue_script( 'datatables' );
        wp_enqueue_script( 'datatables-responsive' );
		
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_script( 'bootstrap' );
		
		wp_enqueue_style( 'font-awesome' );
		
		wp_enqueue_style( 'select2' );
        wp_enqueue_script( 'select2' );
		
		wp_enqueue_script('tinymce');
		
		
    }
	
	
}
add_action( 'wp_enqueue_scripts', 'mis_puntos_enqueue_assets' );

/*agregar css y js a la pagina mis puntos*/

/*agregar css y js personalizado al footer*/
// Verificar si estamos en la página "Mis Puntos"
function mis_puntos_check_page() {
	
	$current_url = home_url( add_query_arg( null, null ) ); // Obtener la URL actual
    $my_account_url = wc_get_page_permalink( 'myaccount' );
	
    if ( strpos( $current_url, $my_account_url ) !== false && strpos( $current_url, '/mis-creditos/' ) !== false ) {
        add_action( 'wp_footer', 'js_creditos' );
		add_action( 'wp_head', 'css_creditos' );
    }
	
	if ( strpos( $current_url, $my_account_url ) !== false && strpos( $current_url, '/partidas-epicas/' ) !== false ) {
        add_action( 'wp_footer', 'js_creditos' );
		add_action( 'wp_head', 'css_creditos' );
    }
	
	if ( is_front_page() ) {
        add_action( 'wp_footer', 'js_creditos' );
		add_action( 'wp_head', 'css_creditos' );
    }
	
}
add_action( 'template_redirect', 'mis_puntos_check_page' );

// Imprimir los scripts en el wp_footer solo en la página "Mis Puntos"
function js_creditos() {
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query, $wp; 
	
    
    ?>

<!-- mis creditos js -->
<script type="text/javascript">
jQuery( document ).ready( function($) { 
	
	/*tablas*/
	$('.tablesResp').DataTable({
		responsive: true,
		//"order": [[ 0, 'desc' ]],
        columnDefs: [
            //{ width: '50px', targets: 0 },
			//{ width: '100px', targets: 1 },
			{ responsivePriority: 1, targets: 4},
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
	
	/*select2*/
	$( "#mis-puntos-user-search" ).select2();
	/*select2*/
	
	/*modal limites*/
	$('#verLimites').on('click', function(e) {
		$('#limitesTraspasoModal').modal('show');
	});	
	/*modal limites*/
	
	/*boton traspaso*/
	
	$('#traspasar').on('click', function(e) {
        e.preventDefault(); // Evitar el envío automático del formulario
		var monto = parseInt($('#monto_transfer').val());
		
		var cod_user = $('#mis-puntos-user-search').val();
		var cod_transferido = $('#cod_transferido').val();
		
		var totalCreditos = parseInt($('#totalCreditos').val());
		
		if(monto>totalCreditos){
			alert('No tienes sufientes Créditos para Traspasar');
			return;
		}
		
		var nuevoMontoCredito = totalCreditos - monto;
		
		
		if (cod_user !== 'none' && monto > 0) {
			
			// Mostrar cuadro de confirmación
			if (confirm('¿Estás seguro de que deseas dar '+monto+' créditos a este usuario?')) {
				
				$('#loaderTras').show();
				/*ajax*/
				 

				var parametros = {
						"monto" : monto,
						"cod_user" : cod_user,
						"cod_transferido" : cod_transferido,
						"nuevoMontoCredito" : nuevoMontoCredito,
						"action" : 'traspaso'	
				}

				jQuery.ajax({
					data:  parametros,
					url:   '<?php echo plugins_url( basename( __DIR__ ) . '/ajax.php' ); ?>',
					type:  'post',
					beforeSend: function () {

				},
					success:  function (response) {	

						//alert(response)
						console.log(response)
						
						if(response=='ok'){
							$('#loaderTras').hide('slow');
							
							$('.alertTraspaso').show();
							
							setTimeout(function() { 
								$('.alertTraspaso').hide();
								location.reload();
							}, 2000);
						}else if(response=='bad'){
							
							$('#loaderTras').hide('slow');
							
							$('.traspasoError').show();
							
							setTimeout(function() { 
								$('.traspasoError').hide('slow');
							}, 2000);
							
						}else if(response=='limite'){
							
							$('#loaderTras').hide('slow');
							
							$('.traspasoLimite').show();
							
							setTimeout(function() { 
								$('.traspasoLimite').hide('slow');
							}, 2000);
							
						}

					}


				}); 
				/*ajax*/
				 
				
				
			} else {
				// Si el usuario cancela, no hacer nada
				return false;
			}
			
		}else{
			alert('Tiene que elegir un usuario e ingresar el monto!')
		}
		
        
	});
	
	/*boton traspaso*/
	
	
});

	
</script>
<!-- mis creditos js -->


<!-- partidas epicas js -->
<?php
$current_url = home_url(add_query_arg(array(), $wp->request));
$cod_player = get_current_user_id();	
?>
<script>
jQuery( document ).ready( function($) { 

	tinymce.init({
	  selector: 'textarea#lugar_partida',
	  plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons',
	  menubar: 'help',
	  toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist ',
	  height: 250,
	  quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',

	  toolbar_mode: 'sliding',
	  contextmenu: "link",

	});
	
	/*tablas*/
	$('.tablePartida').DataTable({
		responsive: true,
		//"order": [[ 0, 'desc' ]],
        columnDefs: [
            //{ width: '50px', targets: 0 },
			//{ width: '100px', targets: 1 },
			{ responsivePriority: 1, targets: 1},
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
	
	/*modal ver partida*/
	
	$('.verPartida').on('click', function() {
		
		$('#loaderPartida').show();
		$('#conPartidas').hide();
		
		$('#alertUnirse').hide();
		$('#modalPartida').modal('show');
		
		let cod_partida = $(this).data('id');
		console.log(cod_partida)
		
		verPartidaJs(cod_partida)
		
	});	
	
	/*modal ver partida*/
	
	/*modal registro partida*/
	
	$('.unirse').on('click', function() {
		
		$('#alertUnirse').hide();
		
		let cod_partida = $(this).data('id');
		let creditos = parseInt($(this).data('creditos'));
		
		let nuevo_credito = creditos - 50;
		
		console.log(cod_partida)
		
			/*ajax*/
			var parametros = {
					"cod_partida" : cod_partida,
					"nuevo_credito" : nuevo_credito,
					"cod_player" : '<?php echo $cod_player;?>',
					"action" : 'registroPartida'	
			}

			jQuery.ajax({
				data:  parametros,
				url:   '<?php echo plugins_url( basename( __DIR__ ) . '/ajax.php' ); ?>',
				type:  'post',
				beforeSend: function () {

			},
				success:  function (response) {	

					//alert(response)
					console.log(response)
					
					
					if(response=='inscrito'){
						
						$('#alertUnirse').removeClass('alert-success');
						$('#alertUnirse').addClass('alert-danger');
						
						$('#alertUnirse').html('<i class="fas fa-check-circle"></i> Ya te inscribiste a esta partida');
						
					}else if(response=='bad'){
						$('#alertUnirse').removeClass('alert-success');
						$('#alertUnirse').addClass('alert-danger');
						
						$('#alertUnirse').html('<i class="fas fa-times-circle"></i> La partida esta llena y no puedes inscribirte!');
						
					}else if(response=='ok'){
						$('#alertUnirse').removeClass('alert-danger');
						$('#alertUnirse').addClass('alert-success');	 
					}
					
					
					$('#alertUnirse').show();
					$('#modalPartida').modal('show');
					verPartidaJs(cod_partida)

				}


			}); 
			/*ajax*/
		
		
		
	});	
	
	/*modal registro partida*/
	
	
	/*eliminar partida*/
	
	$('.eliminarP').on('click', function() {
		
		if (confirm('¿Estás seguro de que deseas eliminar esta Partida?\nNo se te devolvera los 50 Créditos ni tampoco a los usuarios que se registraron')) {
		
			let cod_partida = $(this).data('id');

			/*ajax*/
			var parametros = {
					"cod_partida" : cod_partida,
					"action" : 'eliminarPartida'	
			}

			jQuery.ajax({
				data:  parametros,
				url:   '<?php echo plugins_url( basename( __DIR__ ) . '/ajax.php' ); ?>',
				type:  'post',
				beforeSend: function () {

			},
				success:  function (response) {	

					//alert(response)
					console.log(response)

					window.location.href = '<?php echo esc_url($current_url)?>'


				}


			}); 
			/*ajax*/
			
		}	
		
		
		
		
	});	
	
	/*eliminar partida*/
	
	
});	
	
	
function verPartidaJs(cod_partida){
	console.log('-------')
	console.log(cod_partida)
	
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	
	var parametros = {
			"cod_partida" : cod_partida,
			"action" : 'ver_partida_detalle'	
	}

	jQuery.ajax({
		data:  parametros,
		url:   ajaxurl,
		type:  'post',
		beforeSend: function () {
			
			console.log('*********')
			console.log(cod_partida)

	},
		success:  function (response) {	
				
			let respuesta = response
			console.log(respuesta)
			
			jQuery('#conPartidas').html(response);
			
			jQuery('#loaderPartida').hide();
			jQuery('#conPartidas').show();
		
		}


	});
	
	/*ajax*/
	
	
}	
	
	
	
</script>

<!-- partidas epicas js -->


    <?php
}


function css_creditos() {
    ?>

<style>
	
.tablesResp.dark-header th,
.tablePartida.dark-header th{
    background-color: #222; /* Fondo oscuro más oscuro */
    color: #fff; /* Texto blanco */
    border-color: #444; /* Borde más oscuro */
}
	
table.dataTable.tablesResp tbody th, table.dataTable.tablesResp tbody td,
table.dataTable.tablePartida tbody th, table.dataTable.tablePartida tbody td{
    vertical-align: middle;
    border: 1px solid #0000001c;
	word-break: unset;
}
	
.tablesResp th, .tablesResp td,
.tablePartida th, .tablePartida td {
    box-sizing: content-box !important;
    word-break: normal !important;
    word-wrap: normal !important;
}	
	
.dataTable button {
    font-size: 12px;
    padding: 5px 14px;
}	
	
.dataTables_wrapper .dataTables_length select {
    max-width: 40px;
    min-height: 28px;
}	
	
.select2-container {
    width: 100% !important;
}	
	
.select2-container .select2-selection--single {
    border-radius: 5px !important;
    height: 40px;
}	
	
.select2-container--default .select2-selection--single .select2-selection__rendered {
    border: 1px solid #E4E7EB;
    border-radius: 5px;
    height: 40px;
    line-height: 35px;
}
	
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 7px;
    right: 1px;
    width: 20px;
}	
	
.btnTraspaso {
    align-self: flex-end;
}
	
.fl-button {
    padding: 12px 25px;
    border-radius: 25px;
	display: block
}
	
.fl-button {
    padding: 12px 25px;
    border-radius: 25px;
	display: block
}
	
.fl-button:hover:before, .fl-button:hover:after {
    background: #ef2828;
}	
	
select#monto_transfer {
    margin-bottom: 0;
}	
	
a#verLimites {
    display: block;
    text-decoration: none !important;
    color: #f46119 !important;
}	
	
.single-page-wrapper .modal p {
    margin-top: 0;
    margin-bottom: 10px !important;
}	
	
	
.label {
    display: inline;
    padding: 0.2em 0.6em 0.3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25em;
}
	
.label-success {
    background-color: #5cb85c;
}
.label-danger {
    background-color: #d9534f;
}
	
	
.table h6 {
    margin-bottom: 0;
}	
	
	
.woocommerce-MyAccount-content .dataTables_length label {
    min-width: 300px;
}
	
.dataTables_wrapper .dataTables_length select {
    max-width: 100px;
}	
	
table.dataTable>tbody>tr.child ul.dtr-details>li {
    margin-left: 0;
}	
	
table.dataTable>tbody>tr:nth-of-type(odd).child ul.dtr-details>li {
    border-bottom: 1px solid #cdcdcd;
    padding: 0.5em 0;
}
	
table.dataTable>tbody>tr:nth-of-type(odd).child ul.dtr-details>li:last-child {
    border-bottom: none;
}	
	
.tox .tox-promotion+.tox-menubar, .tox .tox-promotion {
    display: none !important;
}	
	
	
.dataTable button i {
    margin-right: 3px;
}	
	
#conPartidas .loaderPartidas {
    margin: 0 auto;
}	
	
	
button.fl-button.btn.unirse {
    margin: 0 auto;
}	
	
#conPartidas a.fl-button {
    display: inline-block;
    color: #fff !important;
    padding: 6px 25px;
    margin-left: 15px;
}	
	
#conPartidas h4 {
    margin-bottom: 10px;
}
	
ul.playersPartida {
    list-style: decimal;
    padding: 0;
    margin-bottom: 0;
}	
	
#loaderPartida img {
    margin: 0 auto;
}	
	
/*medias queries*/
	
@media only screen and (max-width : 979px){

}

@media only screen and (max-width : 767px){
	
	html .woocommerce-account .woocommerce-MyAccount-content {
		float: none;
		width: 100%;
		padding: 30px;
		margin-top: 15px;
	}
	
	.woocommerce-MyAccount-content .dataTables_length label {
		min-width: auto;
	}
}

@media only screen and (max-width : 600px){
	
	
}	
        
</style>
    <?php
}

/*agregar css y js personalizado al footer*/



/*script para eliminar todos los puntos si pasa de la temporada actual*/
function js_allWebiste() {
	
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
	$creditos_ganados = 0;
	
    $current_user_id = get_current_user_id();
	$creditos_ganados = obtener_puntos_ganados( $current_user_id );
	
	if($creditos_ganados>0){
		$creditos_ganados = number_format($creditos_ganados, 2, '.', ',');
	}else{
		$creditos_ganados = 0;
	}
	
	
?>


<script>
	
	
	
	
jQuery( document ).ready( function($) { 	
	
	if($('.gamipress-user-points-amount').length){
		$('.gamipress-user-points-amount').text('<?php echo $creditos_ganados;?>');
		console.log('agrega puntos')
	}
	
	if($('.gamipress-user-points-points').length){
		$('.gamipress-user-points-points').hide();
		console.log('oculta div')
	}
	
	var myAccountURL = "<?php echo wc_get_account_endpoint_url('dashboard'); ?>";

    // Construir la URL completa agregando "/partidas-epicas/"
    var nuevaURL1 = myAccountURL + 'mis-creditos/';
    var nuevaURL2 = myAccountURL + 'partidas-epicas/'; // Cambia 'otra-pagina' según sea necesario

    // Crear los nuevos elementos <li> con las clases CSS y las URLs
    var nuevoElemento1 = '<li class="clase1"><a href="' + nuevaURL1 + '">Mis Créditos</a></li>';
    var nuevoElemento2 = '<li class="clase2"><a href="' + nuevaURL2 + '">Partidas Épicas</a></li>';

    // Insertar los nuevos elementos después del tercer elemento
    $("ul.uk-nav.uk-dropdown-nav").each(function() {
        var tercerElemento = $(this).find("li:eq(2)");
        tercerElemento.after(nuevoElemento1, nuevoElemento2);
    });
	
});	
	
	

function verificarTemporada(){
	
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	
	var parametros = {
			action : 'eliminar_pts_tmp_pasada'	
	}

	jQuery.ajax({
		data:  parametros,
		url:   ajaxurl,
		type:  'post',
		beforeSend: function () {

	},
		success:  function (response) {	
				
			//alert(response)
			console.log(response)
		
		}


	}); 
	
}	
	
verificarTemporada()	

</script>

<?php
	
}

add_action( 'wp_footer', 'js_allWebiste' );
//add_action('admin_footer', 'js_allWebiste');



add_action('wp_ajax_eliminar_pts_tmp_pasada', 'borrarPuntosTempPasada');
add_action('wp_ajax_nopriv_eliminar_pts_tmp_pasada', 'borrarPuntosTempPasada');

function borrarPuntosTempPasada() {
    global $wpdb;
	
	$fecha_actual = date( 'Y-m-d' );
	$nom_temporada ="";
			
	$temporada = $wpdb->get_results("SELECT nom_temporada, primer_inicio, primer_fin,
											segunda_inicio, segunda_fin, estado_temporada, year_temporada
												
											FROM temporadas
											WHERE estado_temporada = 1 ");
		
	if($temporada){

		foreach ($temporada as $temp){
			$temporada1_inicio = $temp->primer_inicio;
			$temporada1_fin = $temp->primer_fin;

			$temporada2_inicio = $temp->segunda_inicio;
			$temporada2_fin = $temp->segunda_fin;	

			$year_temporada = $temp->year_temporada;
			$temporada = $temp->year_temporada;

		}
				
		$enviarCorreo = 0;		
		/*obtener en que temporada esta*/
		if ($fecha_actual > $temporada1_fin) {
			$nom_temporada = "Temporada 1 del ".$year_temporada;
			
			/*ver si ya borramos puntos temporada 1*/
			$temporadaBorrada = $wpdb->get_results("SELECT estado, nom_temporada 
													FROM fechas_borradas			
													WHERE nom_temporada = '$nom_temporada' 
													and estado = '1'");
			
			if($temporadaBorrada){
				//ya se borro
				
			}else{
				
				/*insertar a fechas_borradas*/
				$insertSql = "
						INSERT INTO fechas_borradas 
						(nom_temporada, year_temporada, estado)

						VALUES 
						('$nom_temporada', '$year_temporada', '1')
						";

				$wpdb->query($insertSql);
				/*insertar a fechas_borradas*/
				
				/*borrar puntos usuario temporada*/
				$insertSql = "
						DELETE FROM puntos_usuarios 
						WHERE temporada = '$nom_temporada';
						";

				$wpdb->query($insertSql);
				/*borrar puntos usuario temporada*/
				
				$enviarCorreo = 1;
				
				
			}
			
			/*ver si ya borramos puntos temporada 1*/
			
			
			
			
		}elseif ($fecha_actual > $temporada2_fin) {
			$nom_temporada = "Temporada 2 del ".$year_temporada;
			
			/*ver si ya borramos puntos temporada 2*/
			$temporadaBorrada = $wpdb->get_results("SELECT estado, nom_temporada 
													FROM fechas_borradas			
													WHERE nom_temporada = '$nom_temporada' 
													and estado = '1'");
			
			if($temporadaBorrada){
				//ya se borro
				
			}else{
				
				/*insertar a fechas_borradas*/
				$insertSql = "
						INSERT INTO fechas_borradas 
						(nom_temporada, year_temporada, estado)

						VALUES 
						('$nom_temporada', '$year_temporada', '1')
						";

				$wpdb->query($insertSql);
				/*insertar a fechas_borradas*/
				
				/*borrar puntos usuario temporada*/
				$insertSql = "
						DELETE FROM puntos_usuarios 
						WHERE temporada = '$nom_temporada';
						";

				$wpdb->query($insertSql);
				/*borrar puntos usuario temporada*/
				
				$enviarCorreo = 1;
				
				
			}
			
			/*ver si ya borramos puntos temporada 2*/
			
		}
		
		
		/***=== Enviar Mail ===***/
		
		// Obtener usuarios con roles "customer" o "subscriber"
		$args = array(
			'role__in' => array('customer', 'subscriber'),
			'number' => -1, // Obtener todos los usuarios
		);
		$users = get_users($args);

		// Crear un array para almacenar las direcciones de correo
		$destinatarios = array();

		// Recorrer los usuarios y obtener sus direcciones de correo
		foreach ($users as $user) {
			$user_email = $user->user_email;
			if (is_email($user_email)) { // Valida que la dirección de correo sea válida
				$destinatarios[] = $user_email;
			}
		}

		if (!empty($destinatarios)) {
			// Dirección de correo del remitente
			$remitente = 'wordpress@plataforma.reinodragon.com'; // Dirección de correo del remitente

			// Dirección de correo principal del destinatario (correo principal de WordPress)
			$toAdmin = get_option('admin_email');
			$to = 'edward.avalos.severiche@gmail.com';
			
			// Asunto del correo
			$asunto = 'Fin y Reseteo de Puntos de la '.$nom_temporada;
			
			$logo = '';
			if (teamhost_get_theme_mod( 'site_logo')){
			
				$logo = '<img src="' . esc_url(teamhost_get_theme_mod( 'site_logo')) . '" width="30" style="margin-right:7px;" />';
				
			}
			
			
			// Contenido del correo
			$mensaje = '
			
				<center style="margin-top:50px;align-items:flex-end; justify-content:center;">
				
					'.$logo.'<p style="font-size:20px;margin-top: 0;">'.get_bloginfo('name').'</p>
				
				</center>
				
				
				<center style="margin-top:30px">
				
					<h2>Acabo la Temporada '.$nom_temporada.'</h2>
					<p style="font-size:16px;">Todos los puntos obtenidos en la '.$nom_temporada.' fueron borrados</p>
				
				</center>
			
			';

			// Divide el array de destinatarios en grupos de 30
			$grupos_destinatarios = array_chunk($destinatarios, 30);
			

			// Envía el correo por grupos de 50 destinatarios
			foreach ($grupos_destinatarios as $grupo_destinatarios) {
				
				$grupo_destinatarios;
				
				// Direcciones de correo de copia carbon (CC)
				$cc = implode(', ', $grupo_destinatarios); // Agrega las direcciones CC
				
				$headers []= "From: ".get_bloginfo('name')." <$remitente>\r\n";
				$headers []= "CC: $cc\r\n";
				//$headers []= "Return-Path: Presales Club777 <preorder@club777.io>\r\n";
				//$headers []= "Reply-To: Presales Support <support@club777.io>\r\n";

				$headers []= "Organization: ".get_bloginfo('name')."\r\n";
				$headers []= "MIME-Version: 1.0\r\n";
				$headers []= "Content-Type: text/html; charset=UTF-8\r\n"; 
				 $headers []= "X-Priority: 3\r\n";
				$headers []= "X-Mailer: PHP". phpversion() ."\r\n";

				// Envía el correo a la dirección principal con copia carbon (CC) a las otras direcciones del grupo
				
				if($enviarCorreo == 1){
					
					$enviado = wp_mail($toAdmin, $asunto, $mensaje, $headers);

					if (!$enviado) {
						echo 'Hubo un error al enviar el correo.';
					}
					
				}
				
				
			}
			if($enviarCorreo == 1){
				echo 'Correos enviados correctamente.';				
			}else{
				echo 'No se enviaron los mails';
			}
			
		} else {
			echo 'No se encontraron direcciones de correo válidas para enviar.';
		}
		
		
		/***=== Enviar Mail ===***/
				
				 

	}
	
	

    // Asegúrate de finalizar la ejecución
    wp_die();
}



/*script para eliminar todos los puntos si pasa de la temporada actual*/


/*funcion para ver el detalle de las partidas*/

add_action('wp_ajax_ver_partida_detalle', 'verPartidaDetalle');
add_action('wp_ajax_nopriv_ver_partida_detalle', 'verPartidaDetalle');

function verPartidaDetalle() {
   global $wpdb;  
	
	$cod_partida = $_POST['cod_partida'];

    
	$partida = $wpdb->get_results("
									SELECT cod_partida, nom_partida, cod_creador, cant_players, lugar_partida, fecha_partida, link, hora_partida
									
									FROM partidas
									WHERE cod_partida = '$cod_partida'
								   ");
		
	if($partida){

		foreach ($partida as $temp){
			
			$nom_partida = $temp->nom_partida;
			$cant_players = $temp->cant_players;
			$lugar_partida = $temp->lugar_partida;

			$fecha_partida = $temp->fecha_partida;
			$hora_partida = $temp->hora_partida;
			$link = $temp->link;
			
			$hora_partida = date('h:iA', strtotime($hora_partida));
			
		}
		
		
		$cont = '
		
			<h4><strong>'.$nom_partida.'</strong></h4>
			
			<p><strong>Jugadores: </strong>'.$cant_players.'</p>
			<p><strong>Fecha:</strong> '.$fecha_partida.'</p>
			<p><strong>Hora:</strong> '.$hora_partida.'</p>
		
		';
		
		if($link !=""){
			$cont .= '
				<p><strong>Link Transmisión:</strong>
					<a class="fl-button btn secondary-button" href="'.$link.'" target="_blank"><i class="fas fa-link"></i> Click para Ver</a>
				</p>
			';	
		}
		
		$cont .= '
		
			<div class="lugarPartida">
				<p class="mb-2"><strong>Lugar:</strong></p>
				'.$lugar_partida.'
			</div>
		';
		
		
	$partida = $wpdb->get_results("
									SELECT cod_partida, cod_player
									
									FROM partida_players
									WHERE cod_partida = '$cod_partida'
								   ");
		
	if($partida){
		
		$cont .= '
			
			<div class="col-md-12 mt-4 mb-4 p-0"><hr></div>
				
			<h4><strong>Usuarios en la partida</strong></h4>
			
			<ul class="playersPartida">
		';

		foreach ($partida as $temp){
			
			$cod_player = $temp->cod_player;
			
			/**/
			$full_name = "Anónimo";
			$user_data = get_userdata($cod_player);
								
			if ($user_data) {
				
				$user_id = $user_data->ID;
				$first_name = get_user_meta($user_id, 'first_name', true);
				$last_name = get_user_meta($user_id, 'last_name', true);
				
				
				$display_name = $user_data->display_name;
								
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
				$full_name = esc_html( $user_data->display_name );
				}
			}
			/**/
			
			/*Usuarios unidos a la partida*/
			
			$cont .= '
			
				<li>'.$full_name.'</li>
			
			
			';	
			
			
			/*Usuarios unidos a la partida*/
			
			
		}
		
		$cont .= '
			
			</ul>
		';
		
		
	}
		
		
		
		
		
		
		echo $cont;
		
	}else{
		echo "<h4>Partida no Encontrada</h4>";
	}
	
	wp_die();
}

/*funcion para ver el detalle de las partidas*/



/******************************APUESTAS EPICAS**********************************/
function agregar_menu_partidas_epicas( $items ) {
    // Agregamos el nuevo ítem de menú al array
    $new_items = array(
        'partidas-epicas' => 'Partidas Épicas',
    );

    // Encontramos la posición del menú "Salir"
    $logout_position = array_search( 'customer-logout', array_keys( $items ) );

    // Insertamos el nuevo ítem justo antes del menú "Salir"
    if ( $logout_position !== false ) {
        $items = array_slice( $items, 0, $logout_position, true ) + $new_items + array_slice( $items, $logout_position, null, true );
    } else {
        // Si no se encuentra el menú "Salir", simplemente lo agregamos al final
        $items = array_merge( $items, $new_items );
    }

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'agregar_menu_partidas_epicas', 10, 1 );


function partidas_epicas_page_content() {
	
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
	
    $user_id = get_current_user_id();
	$creditos_ganados = obtener_puntos_ganados( $user_id );
	
	$errorCampos = 0;
	$errorPlayers = 0;
	$errorCrear = 0;
	
	$errorPuntos = 0;
	
	if($_POST){
	
		if(
			isset($_POST['nom_partida']) and $_POST['nom_partida']!="" and
			isset($_POST['cant_players']) and $_POST['cant_players']!="" and
			isset($_POST['fecha_partida']) and $_POST['fecha_partida']!="" and
			isset($_POST['hora_partida']) and $_POST['hora_partida']!="" and
			isset($_POST['lugar_partida']) and $_POST['lugar_partida']!=""
		){

			$nom_partida = $_POST['nom_partida'];
			$cant_players = $_POST['cant_players'];

			$fecha_partida = $_POST['fecha_partida'];
			$fecha_partida = str_replace('/', '-', $fecha_partida);
			$fecha_partida = date("Y-m-d", strtotime($fecha_partida));

			$lugar_partida = $_POST['lugar_partida'];
			$link = $_POST['link'];
			$hora_partida = $_POST['hora_partida'];
			
			$cod_creador = $user_id;

			$flag = uniqid();

			if($cant_players>4){
				$errorPlayers = 1;
				$errorCrear = 1;
			}

			if($creditos_ganados<50){
				$errorCrear = 1;
				$errorPuntos = 1;
			}

			if($errorCrear==0){
				/*************************/
				$sqlCrear = "
					INSERT INTO  partidas  
					(nom_partida, cod_creador, cant_players, lugar_partida, fecha_partida, flag, link, hora_partida)

					VALUES  
					('$nom_partida', '$cod_creador', '$cant_players', '$lugar_partida', '$fecha_partida', '$flag', '$link', '$hora_partida')
				";
				$wpdb->query($sqlCrear);
				/**************************/

				/*************************/
				$get_flag = $wpdb->get_results("SELECT cod_partida, flag 
											FROM partidas 
											WHERE flag = '$flag' ");
				$cod_partida = 0;
				if($get_flag){
					foreach ($get_flag as $flag_code){
						$cod_partida = $flag_code->cod_partida;
					}
				}



				$sqlRegistro = "
					INSERT INTO  partidas_registro  
					(cod_partida, nom_partida, cod_creador, cant_players, lugar_partida, fecha_partida, link, hora_partida)

					VALUES  
					('$cod_partida', '$nom_partida', '$cod_creador', '$cant_players', '$lugar_partida', '$fecha_partida', '$link', '$hora_partida')
				";

				$wpdb->query($sqlRegistro);
				/**************************/
				
				
				/**************************/
				
				/**/
				$fecha_actual = date('Y-m-d');
				$nom_temporada="";
				$temporada = $wpdb->get_results("SELECT nom_temporada, primer_inicio, primer_fin,
												segunda_inicio, segunda_fin, estado_temporada, year_temporada
												
												FROM temporadas
												WHERE estado_temporada = 1 ");
		
				if($temporada){

					foreach ($temporada as $temp){
						$temporada1_inicio = $temp->primer_inicio;
						$temporada1_fin = $temp->primer_fin;

						$temporada2_inicio = $temp->segunda_inicio;
						$temporada2_fin = $temp->segunda_fin;	

						$year_temporada = $temp->year_temporada;
						$temporada = $temp->year_temporada;

					}


					/*obtener en que temporada esta*/
					if ($fecha_actual >= $temporada1_inicio and $fecha_actual <= $temporada1_fin) {
						$nom_temporada = "Temporada 1 del ".$year_temporada;
					}elseif ($fecha_actual >= $temporada2_inicio and $fecha_actual <= $temporada2_fin) {
						$nom_temporada = "Temporada 2 del ".$year_temporada;
					}

					/*obtener en que temporada esta*/

				}else{

					$nom_temporada = ( date( 'm', strtotime( $fecha_actual ) ) >= 6 ) ? 'Temporada 2' : 'Temporada 1';
					$nom_temporada .= ' del ' . date( 'Y', strtotime( $fecha_actual ) );

				}
				
				/**/
				
				$nuevoCredito = round($creditos_ganados - 50);
				
				$sqlEliminarCre = "
					DELETE FROM puntos_usuarios 
					WHERE cod_user = '$user_id'
				";

				$wpdb->query($sqlEliminarCre);
				
				
				$sqlInsertarNC = "
					INSERT INTO puntos_usuarios 
					(cod_user, puntos, temporada)

					VALUES 
					('$user_id', '$nuevoCredito', '$nom_temporada')
				";

				$wpdb->query($sqlInsertarNC);
				
				
				
				/**************************/

			}




		}else{
			$errorCampos = 1;
			$errorCrear = 1;
		}
		
	}else{
		$errorCrear = 1;
	}	
	
    echo '<h2><strong><i class="fas fa-trophy"></i> Partidas Épicas</strong></h2>';
    
	echo '
	
		<form action="" method="post" enctype="multipart/form-data">
			<div class="row partidasEpicas">
			
				<div class="col-md-12">
					<h5>
						<strong>Registra tu partida Épica (50 Créditos)</strong><br>
						<small>Todos los campos son Requeridos</small>
					</h5>
					
				</div>
	';
	
				if($errorCampos==1){
					
				echo '
					<div class="col-md-12">
						<div class="alert alert-danger mt-3 mb-3 text-center alert-dismissible fade show" role="alert">
							<i class="fas fa-times-circle"></i> Todos los campos son necesarios
							
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				';
				}
	
				if($errorPlayers==1){
					
				echo '
					<div class="col-md-12">
						<div class="alert alert-danger mt-3 mb-3 text-center alert-dismissible fade show" role="alert">
							<i class="fas fa-times-circle"></i> Solo puede haber Máximo 4 jugadores
							
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				';
				}
	
				if($errorPuntos==1){
					
				echo '
					<div class="col-md-12">
						<div class="alert alert-danger mt-3 mb-3 text-center  alert-dismissible fade show" role="alert">
							<i class="fas fa-times-circle"></i> No tienes suficientes Créditos para crear una Partida Épica. Mínimo de Créditos son: 50
							
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				';
				}
		
				
				if($errorCrear == 0){
				
	
	echo '
				<div class="col-md-12">
					<div class="alert alert-success mt-3 mb-3 text-center alert-dismissible fade show" role="alert">
						<i class="fas fa-check-circle"></i> Partida Épica Creada Correctamente!<br>
						Se te desconto 50 Créditos!
						
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>
	';
					
				}	
	
	echo '
	
				<div class="col-md-6 mb-3">
					<label>Nombre de la Partida</label>
					<input class="form-control" type="text" name="nom_partida">
				</div>

				<div class="col-md-6 mb-3">
					<label>Cant. de Jugadores (Max 4)</label>
					<input class="form-control" type="number" name="cant_players">
				</div>

				<div class="col-md-6 mb-3">
					<label>Fecha Partida</label>
					<input class="form-control" type="date" name="fecha_partida">
				</div>
				
				<div class="col-md-6 mb-3">
					<label>Hora Partida</label>
					<input class="form-control" type="time" name="hora_partida">
				</div>

				<div class="col-md-12 mb-3">
					<label>Lugar</label>
					<textarea name="lugar_partida" id="lugar_partida" class="form-control"></textarea>
				</div>
				
				<div class="col-md-12 mb-3">
					<label>Url de Transmición (Opcional)</label>
					<input class="form-control" type="text" name="link">
				</div>

				<div class="col-md-12 mt-3 mb-3">
					<button type="submit" id="crearPartida" class="fl-button secondary-button ">
						Crear Partida Épica
					</button>
				</div>
			
			</div>
			
		</form>
		
		<div class="row tablaPartida">
			
				<div class="col-md-12 mt-5 mb-4"><hr></div>

				<div class="col-md-12">
					<h3>Tus Partidas Épicas</h3>
				</div>
				
				
				<div class="col-12">
				
					<table class="tablePartida table table-striped table-sm dark-header" style="width: 100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nombre</th>

								<th class="text-center">Fecha</th>
								<th class="text-center">Eliminar</th>

							</tr>
						</thead>

						<tbody>
						
	';
	
					$partida = $wpdb->get_results("SELECT 
												nom_partida, cod_creador, cant_players, fecha_partida, link, hora_partida, cod_partida
												
												FROM partidas
												WHERE cod_creador = $user_id ");
	
					$link = "--";
					$cont = 0;
					if($partida){

						foreach ($partida as $temp){
							$cod_partida = $temp->cod_partida;
							$nom_partida = $temp->nom_partida;
							$cant_players = $temp->cant_players;
							
							$fecha_partida = $temp->fecha_partida;
							
							$hora_partida = $temp->hora_partida;
							$hora_partida = date('h:iA', strtotime($hora_partida));
							
							
							$link = $temp->link;
							
							$cont++;
								
						
	
	
	echo '
						
							<tr>
								<td class="text-center">
									'.$cont.'
								</td>
								
								<td class="text-center">
									'.$nom_partida.'
								</td>
								
								
								<td class="text-center">
									'.$fecha_partida.'<br>'.$hora_partida.'
								</td>
								
								
								<td class="text-center">
									<button class="btn btn-danger eliminarP mb-2" 
									data-id="'.$cod_partida.'">
										<i class="fas fa-times-circle"></i> Eliminar
									</button>
									
									<br>
									
									<button class="btn btn-success verPartida mb-0" 
									data-id="'.$cod_partida.'">
										<i class="fas fa-eye"></i> Ver Detalles
									</button>
									
								</td>
							
							</tr>
	';
	
	
						}//fin foreach
						
					}//fin if	
	
	echo '
						
						
							

						</tbody>

					</table>
				
				</div>
				
		</div>		
		
		
		
			<!-- modal partidas -->
			<div class="modal fade" id="modalPartida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">
						<strong>Detalle de la partida</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="">
				  
				  	<div id="loaderPartida"  class="text-center mt-3 mb-3">
						<img src="'.plugins_url( basename( __DIR__ ) . '/img/loader.gif' ).'" width="70" height="70" class="loaderPartidas">
					</div>
				  
				  	<div id="conPartidas"></div>
					
					
					
				  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- modal partidas -->
		
			
	
		
	
	';
	
	
	
}
add_action( 'woocommerce_account_partidas-epicas_endpoint', 'partidas_epicas_page_content' );

function partidas_epicas_endpoint() {
    add_rewrite_endpoint( 'partidas-epicas', EP_PAGES );
}
add_action( 'init', 'partidas_epicas_endpoint' );

function partidas_epicas_flush_rewrite_rules() {
    partidas_epicas_endpoint();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'partidas_epicas_flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );


/******************************APUESTAS EPICAS**********************************/


/******************************NUEVOS MENUS**********************************/


/******************************NUEVOS MENUS**********************************/



/******************************SHORTCODE APUESTAS EPICAS**********************************/
//'Marcellus'


function partida_epica() { 
	global $woocommerce, $wp_roles, $post, $wpdb,$wp_query; 
	
    $current_user_id = get_current_user_id();
	$creditos_ganados = obtener_puntos_ganados( $current_user_id );
	
	
	echo '
	
		<div class="row tablaPartida">

				<div class="col-md-12">
					<h3 class="uk-text-lead">Partidas Épicas</h3>
				</div>
				
				
				<div class="col-12">
				
					<table class="tablePartida table table-striped table-sm dark-header" style="width: 100%">
						<thead>
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Nombre de la Partida</th>

								<th class="text-center">Fecha</th>
								<th class="text-center">Eliminar</th>

							</tr>
						</thead>

						<tbody>
						
	';
	
					$partida = $wpdb->get_results("SELECT 
												nom_partida, cod_creador, cant_players, fecha_partida, link, hora_partida, cod_partida
												
												FROM partidas
												ORDER BY cod_partida DESC");
	
					$link = "";
					$cont = 0;
					if($partida){

						foreach ($partida as $temp){
							$cod_partida = $temp->cod_partida;
							$nom_partida = $temp->nom_partida;
							$cant_players = $temp->cant_players;
							
							$fecha_partida = $temp->fecha_partida;
							$hora_partida = $temp->hora_partida;
							$hora_partida = date('h:iA', strtotime($hora_partida));
							
							$link = $temp->link;
							
							$cod_creador = $temp->cod_creador;
							
							$cont++;
							
							/**/
							$full_name = "Anónimo";
							$user_data = get_userdata($cod_creador);
								
							if ($user_data) {
								
								
								$user_id = $user_data->ID;
								$first_name = get_user_meta($user_id, 'first_name', true);
								$last_name = get_user_meta($user_id, 'last_name', true);
								
								
								$display_name = $user_data->display_name;
								
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
									$full_name = esc_html( $user_data->display_name );
								}


							}
							
							/**/
								
						
	
	
	echo '
						
							<tr>
								<td class="text-center">
									'.$cont.'
								</td>
								
								<td class="text-center">
									'.$nom_partida.'<br>
									<strong>Creado por:</strong> '.$full_name.'
								</td>
								
								
								<td class="text-center">
									'.$fecha_partida.'<br>'.$hora_partida.'
								</td>
								
								
								<td class="text-center">
									<button class="fl-button btn secondary-button unirse mb-2" 
									data-id="'.$cod_partida.'" data-user="'.$current_user_id.'"
									data-creditos="'.$creditos_ganados.'">
										<i class="fas fa-user-plus"></i> Registrarte!
									</button>
									
									 
									
									<button class="btn btn-success verPartida mb-0" 
									data-id="'.$cod_partida.'">
										<i class="fas fa-eye"></i> Ver Detalles
									</button>
									
								</td>
							
							</tr>
	';
	
	
						}//fin foreach
						
					}//fin if	
	
	echo '
						
						
							

						</tbody>

					</table>
				
				</div>
				
		</div>		
		
		
		
			<!-- modal partidas --> 
			<div class="modal fade moda_shortcode" id="modalPartida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">
						<strong>Detalle de la partida</strong>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="">
				  
				  	
					<div id="alertUnirse" class="alert alert-success mt-3 mb-3 text-center alert-dismissible fade show" role="alert" style="display:none;">
					
							<i class="fas fa-check-circle"></i> Te uniste a la partida Correctamente!
							
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
					</div>
					
				  	<div id="loaderPartida"  class="text-center mt-3 mb-3" style="display:none;">
						<img src="'.plugins_url( basename( __DIR__ ) . '/img/loader.gif' ).'" width="70" height="70" class="loaderPartidas">
					</div>
				  
				  	<div id="conPartidas" style="display:none;"></div>
					
					<div id="usersPartida" class="mt-3">
					
					
					</div>
				  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- modal partidas -->
			
		
			
	
		
	
	';





}
// register shortcode
add_shortcode('partidaepica', 'partida_epica');


/**/





/******************************SHORTCODE APUESTAS EPICAS**********************************/





/*******funciones necesarias*********/





?>