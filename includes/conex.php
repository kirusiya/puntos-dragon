<?php
/* That's all, stop editing! Happy publishing. */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', '../../../'. '/' );
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-config.php');	

class conexion{

		

		function conectar()

		{

			$servidor=DB_HOST;

			$usuario=DB_USER;

			$clave=DB_PASSWORD;

			$db=DB_NAME;

			return mysqli_connect($servidor,$usuario,$clave,$db);

		}

		function consultar($csql){

			

			$conexion=$this->conectar();

			//mysql_select_db($db,$conexion);

			return mysqli_query($conexion,$csql);

		}

	}



?>