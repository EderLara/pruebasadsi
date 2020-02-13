<?php
/**
 * Fecha de inicio del proyecto: sábado, 20 de agosto del año 2016
 * @author        Gregori Enrique Piñeres Zerpa
 * @link          https://www.github.com/Gregori02/getDb
 * @since         1.0
 * @license       MIT License Copyright (c) 2016 Gregori Piñeres
*/
define('APP_VERSION', '1.0');
define('APP_URL'    , 'https://github.com/Gregori02/getDb');
define('APP_AUTHOR' , 'Gregori Enrique Piñeres Zerpa');

if ($_POST) {
  include 'conexion.php';
	/*Extencion del archivo generado*/
	$ext = $_POST['extencion'];
	$for = $_POST['formato'];
	/*Ruta de la carpeta donde se guardara el backup, de no existir la carpeta el
  script la crea*/
	$ruta = 'exports/';
	/*Si el usuario desea eliminar la base de datos ya existente*/
	$tables_drop = true;
	/*Version del servidor, y usuario conectado*/
	$version = $sql->query("SELECT user(), version();");
	$version = $version->fetch_row();
	/*Nombre del archivo resultante*/
	$nombre = date("Y-m-d-") . $database . $ext;
	/*Si el archivo existe, lo abrimos*/
	$file_exists = false;
	if (file_exists($ruta)) {
		$handle = fopen($ruta."\\".$nombre, "w");
		$file_exists = true;
	}
	/*Si el archivo no existe, lo creamos*/
	if (!file_exists($ruta) && $file_exists != true) {
		mkdir($ruta);
		$handle = fopen($ruta."\\".$nombre, "w");
		$file_exists = true;
	}
	/*Inicializacion de las consultas SQL*/
	$database_exists = false;
	$usar_base_de_datos = $sql->query("USE $database");
	if ($usar_base_de_datos) { $database_exists = true; }

	/*Si existe la base de datos y se creo el archivo*/
	if ($database_exists && $file_exists) {
		/*Consulta para mostrar las tablas de una base de datos*/
		$tablas = $sql->query("SHOW TABLES");
		$num_tablas = $tablas->num_rows;
  	$fecha = date("d/m/Y");
		$hora  = date("h:i:s a");
		$salto_de_lineas = "-- -----------------------------------------" . PHP_EOL;
  	/*Si hay tablas*/
		if ($table_name = $tablas->fetch_array()) {
			/*Header del archivo generado*/
			fwrite ($handle, "-- MySQL script generado por getDb v" . APP_VERSION . PHP_EOL);
			fwrite ($handle, "-- Autor: " . APP_AUTHOR . PHP_EOL);
			fwrite ($handle, "-- Url: " . APP_URL . PHP_EOL);
			/*Segunda cabecera, contiene datos del servidor*/
			fwrite($handle, $salto_de_lineas);
			fwrite($handle, "-- Usuario MySQL:    " . $version[0] . PHP_EOL);
			fwrite($handle, "-- MySQL versión:    " . $version[1] . PHP_EOL);
			fwrite($handle, "-- PHP versión:      " . phpversion(). PHP_EOL);
			fwrite($handle, "-- Fecha del backup: " . $fecha . " a las " . $hora . PHP_EOL);
			/*Obtener el Character set de la base de datos*/
			$caracteres = $sql->query("SHOW VARIABLES LIKE 'character_set_database'");
			$caracteres = $caracteres->fetch_row();
			$charset    = "DEFAULT CHARACTER SET " . $caracteres[1];
			/*Mostrando algunas propiedades de la base de datos en el SQL*/
			fwrite ($handle, $salto_de_lineas);
			fwrite ($handle, "-- Base de datos:    " . $database . PHP_EOL);
			fwrite ($handle, "-- Número de tablas: " . $num_tablas    . PHP_EOL);
			fwrite ($handle, "-- Cotejamiento:     " . $caracteres[1] . PHP_EOL);
			fwrite ($handle, $salto_de_lineas);
			/*Variables que seran utilizadas en consultas SQL*/
			$dropDb   = "DROP SCHEMA IF EXISTS ";
			$dropTb   = "DROP TABLE IF EXISTS ";
			$createDb = "CREATE SCHEMA IF NOT EXISTS ";
			$createTb = "CREATE TABLE IF NOT EXISTS ";
			$crateEng = "SELECT ENGINE FROM information_schema.tables WHERE table_name =";
			$createAI = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name =";
			$createCS = "SELECT TABLE_COLLATION FROM information_schema.tables WHERE table_name =";
			$show     = "SHOW FULL COLUMNS FROM `" . $database . "` . `";
			$showIX   = "SHOW INDEX FROM ";
			/*Creando la base de datos*/
			fwrite ($handle, $createDb."`$database` $charset;".PHP_EOL);
			fwrite ($handle, "USE `$database`;".PHP_EOL);
  		/*Bucle 1. El primer bucle almacena por completos el numero de tablas
			Se repetira el numero de veces del entero que retorne, es decir.
			Si una base de datos tiene 8 tablas se repetiran 8 veces.
			*/
			do {
				/*Comentario SQL para la creacion de cada tabla*/
				fwrite ($handle, PHP_EOL);
				fwrite ($handle, $salto_de_lineas);
				fwrite ($handle, "-- Creando la tabla ".$table_name[0]." ".PHP_EOL);
				fwrite ($handle, $salto_de_lineas);
				/*Creando el lenguaje de definicion de datos (DDL)*/
				/*Eliminar tabla si existe*/
				if ($tables_drop){ fwrite($handle, $dropTb . "`" . $table_name[0] . "`;" . PHP_EOL); }
 			  /*Crear tabla si no existe*/
				fwrite ($handle, $createTb . "`$database` . `" . $table_name[0] ."`(" . PHP_EOL);
				$full_columnas = $sql->query($show . $table_name[0] . "`");
				$num_col = $full_columnas->num_rows;
				/*Crando la Estructura de la tabla*/
				if($array = $full_columnas->fetch_array()) {
					do{
						/*El comando de Mysql 'SHOW FULL COLUMN FROM' retorna un array de 9 posiciones
							Array[0] = Fiel
							Array[1] = Type
							Array[2] = Collation
							Array[3] = Null
							Array[4] = Key
							Array[5] = Default
							Array[6] = Extra
							Array[7] = Privileges
							Array[8] = Comment
						Para poder transformarlos de nuevo a sintaxis SQL Debemos realizar
						El siguiente cambio de los valores del array mediante toma de decisiones.
						*/
						/*Si el campo es 'NOT NULL'*/
						if ($array[3]=="NO")  { $array[3] = "NOT NULL"; }
						if ($array[3]=="YES") { $array[3] = "NULL";     }
						/*Si el campo es 'MUL' no lo escribiremos en el archivo*/
						$key = false;
						if ($array[4]=="MUL") {	$array[4] = ""; $key = true; }
						/*Verificar si el campo tiene valores por default ya definidos*/
						$default=false;
						$default_times = false;
						if ($array[5]!="") {
							$default=true;
							if ($default) {
								if ($array[5]   == "CURRENT_TIMESTAMP") {
									$default_times = true;
								}
							}
						}
						/*Verificar si el campo es un auto_increment*/
						$increment=false;
						if ($array[6] == "auto_increment") {
							$array[6]    = "AUTO_INCREMENT";
							$increment   = true;
						}
						/*Verificar si el campo contiene algun comentario*/
						$coment = false;
						if ($array[8] != "") { $coment = true; }
						/*Drecrementamos -1 el valor de $num_col hasta que llegue a 0 para
  					asi poder asegurarnos de cerrar la consulta SQL*/
						$num_col--;
						/*Si no es la ultima columna*/
						if ($num_col > 0) {
						/*Los valores que siempre tienen que estar presentes son los siguientes
								array[0] = NAME
								array[1] = TYPE
								array[2] = NULL
							*/
							fwrite($handle, "  `".$array[0]."` ");
							fwrite($handle, strtoupper($array[1])." ");
							fwrite($handle, $array[3]." ");
							/*Si tiene algun default, y ademas es CURRENT_TIMESTAMP*/
							if ($default && $default_times) {
								fwrite($handle, "default CURRENT_TIMESTAMP ");
							}
							/*Si tiene algun default, pero no es CURRENT_TIMESTAMP*/
							if($default && !$default_times){
								fwrite($handle, "DEFAULT '". strtoupper($array[5])."' ");
							}
							/*Si el campo tiene un auto_increment*/
							if($increment){
								fwrite($handle, $array[6]." ");
							}
							/*Si el campo tiene un comentario*/
							if($coment){
								fwrite($handle, "COMMENT '". $array[8] . "'");
							}
							/*Como es el primer campo se finaliza la linea de comando SQL con una coma(,)*/
							fwrite($handle, "," . PHP_EOL);
						}
						/*Si es la ultima columna*/
						if ($num_col == 0) {
							/*Los valores que siempre tienen que estar presentes son los siguientes
									array[0] = NAME
									array[1] = TYPE
									array[2] = NULL
							*/
							fwrite($handle, "  `".$array[0]."` ");
							fwrite($handle, strtoupper($array[1])." ");
							fwrite($handle, $array[3]." ");
							/*Si tiene algun default, y ademas es CURRENT_TIMESTAMP*/
							if ($default && $default_times) {
								fwrite($handle, "default CURRENT_TIMESTAMP ");
							}
							/*Si tiene algun default, pero no es CURRENT_TIMESTAMP*/
							if($default && !$default_times){
								fwrite($handle, "DEFAULT '".strtoupper($array[5])."' ");
							}
							/*Si el campo tiene un auto_increment*/
							if($increment){
								fwrite($handle, $array[6]." ");
							}
							/*Si el campo tiene un comentario*/
							if($coment){
								fwrite($handle, "COMMENT '". $array[8] . "'");
							}
							/*Se finaliza la linea SQL con una coma(,) para asi saltar a la
              siguiente linea que es donde se mostraran los index de cada tabla,
              su llave primaria y demas.*/
							fwrite($handle, "," . PHP_EOL);
							/*Obtener los valores clave de cada tabla*/
							$indices = $sql->query($showIX . $table_name[0]);
							if ($row_indices = $indices->fetch_array()) {
								$num_indices = $indices->num_rows;
								do {
									/*El comando de Mysql 'SHOW INDEX FROM' retorna un array de 12
                  posiciones:
										Array[0] = Table
										Array[1] = Non_unique     //Devuelve 0 si el campo es unico
										Array[2] = Key_name
										Array[3] = Seq_in_index
										Array[4] = Column_name   //Devuelve el nombre de la columna
										Array[5] = Collation
										Array[6] = Cardinality
										Array[7] = Sub_part
										Array[8] = Packed
										Array[9] = Null
										Array[10] = Index_type
										Array[11] = Comment
										Array[12] = Index_comment
									*/
									/*Si el campo es unico, y ademas es llave primaria*/
									if ($row_indices[1] == 0 && $row_indices[2] == "PRIMARY") {
										fwrite($handle, " PRIMARY KEY (`".$row_indices[4]."`)");
									}
									/*Si el campo es unico, pero no es llave primaria*/
									if ($row_indices[1] == 0 && $row_indices[2] != "PRIMARY") {
										fwrite($handle, "," . PHP_EOL . " UNIQUE KEY `"
											.$row_indices[2]."` (`"
											.$row_indices[4]."`)");
									}
									/*Si el campo no es unico, entonces es el key de la tabla*/
									if ($row_indices[1] != 0) {
										fwrite($handle, ",".PHP_EOL." KEY `".$row_indices[2]
										."` (`".$row_indices[4]."`)");
									}
									/*Cuando llega al final hace un saldo de lineas*/
									if ($num_indices == 1) { fwrite($handle, PHP_EOL); }
									$num_indices--;
								} while ($row_indices = $indices->fetch_array());
							}
							/*Cierre del 'create table'*/
							fwrite($handle, ")");
							/*Obteniendo el Motor de almacenamiento de la tabla*/
							$engine_rs = $sql->query($crateEng."'".$table_name[0]."'");
							$engine_rs = $engine_rs->fetch_array();
							$engine    = "ENGINE=".$engine_rs[0];
							/*Obteniendo el auto_incrementable de la tabla*/
							$auto_in_rs = $sql->query($createAI."'".$table_name[0]."'");
							$auto_in_rs = $auto_in_rs->fetch_array();
							$auto_in    = "";
							/*Obteniendo el character set de la tabla*/
							$def_char_rs = $sql->query($createCS."'".$table_name[0]."'");
							$def_char_rs = $def_char_rs->fetch_array();
							$char_set    = "";
							/*Si una tabla no tuviese motor de almacenamiento*/
							if ($engine_rs[0]=="") { fwrite($handle, ";"); }
							/*Si la tabla no tiene auto_incrementable*/
							if($auto_in_rs[0] == "" ){
								/*Cuando el CHARSET sea igual a latin1*/
								if ($def_char_rs[0] == "latin1_swedish_ci") {
									$def_char_rs[0] = "latin1";
									$char_set       = "DEFAULT CHARSET = " . $def_char_rs[0].";";
									fwrite($handle, $engine . " "          . $char_set.PHP_EOL);
								}
								/*Cuando el CHARSET sea igual a utf8*/
								if ($def_char_rs[0] == "utf8_general_ci" || $def_char_rs[0] == "utf8_bin") {
									$def_char_rs[0] = "utf8";
									$char_set = "DEFAULT CHARSET=" . $def_char_rs[0] . ";";
									fwrite($handle, $engine . " "  . $char_set       . PHP_EOL);
								}
							}
							/*Si la tabla tiene auto_incrementable*/
							if ($auto_in_rs[0] != "") {
								/*Cuando el CHARSET sea igual a latin1*/
								if ($def_char_rs[0] == "latin1_swedish_ci") {
									$def_char_rs[0]  = "latin1";
									$char_set = "DEFAULT CHARSET=" . $def_char_rs[0].";";
									$auto_in  = "AUTO_INCREMENT="  . $auto_in_rs[0];
									fwrite($handle, $engine . " "  . $auto_in . " " . $char_set . PHP_EOL);
								}
								/*Cuando el CHARSET sea igual a latin1*/
								if ($def_char_rs[0] == "utf8_general_ci" || $def_char_rs[0] == "utf8_bin") {
									$def_char_rs[0]  = "utf8";
									$char_set = "DEFAULT CHARSET=" . $def_char_rs[0] . ";";
									$auto_in 	= "AUTO_INCREMENT="  . $auto_in_rs[0];
									fwrite($handle, $engine . " "  . $auto_in . " " . $char_set . PHP_EOL);
								}
							}
						}
					} while ($array = $full_columnas->fetch_array());
					/*Fin del codigo para crear el lenguaje de definicion de datos*/
					/*Codigo para insertar datos (Si los tuviese)
					Este es el nucleo del programa: Lenguaje de manipulacion de datos (DML)*/
					fwrite ($handle, PHP_EOL);
					/*Seleccionando datos de la tabla, si hay registros se ejecutará
					El DML Para hacer la consulta sql de insercion.*/
					$datos = $sql->query("SELECT * FROM `".$database."`.`".$table_name[0]."`");
					if (!$datos) {echo "Error: " . $sql->error; return false; }
					/*La variable num_datos almacena la cantidad de registros encontrados
          por la consulta*/
					$num_datos = $datos->num_rows;
					/*Si hay registros procede*/
					if ($row = $datos->fetch_row()) {
						/*Ahora tengo que obtener el nombre del campo, y tambien tengo que
            saber si algun dato es binario, de ser asi tengo que convertirlo a
            un formato hexadecimal para que cuando se haga nuevamente el uploader
            a la BD no ocurra algun error, esto se logra gracias a la funcion de
            PHP bin2hex(); concatenado antes con un 0x
						*/
						$fileds      = $sql->query("DESC `".$table_name[0]."`");
						$cont_fields = $fileds->num_rows;
						if ($fields_row = $fileds->fetch_array()) {
							/*El comando de Mysql 'DESC' retorna un array de 5 posiciones
								Array[0] = Name      //Devuelve el nombre
								Array[1] = Type			 //Devuelve el tipo
								Array[2] = Null
								Array[3] = Key
								Array[4] = Default
								Array[5] = Extra
							*/
							/*Comentario SQL para la insercion de datos de cada tabla (Si los tuviese)*/
							fwrite ($handle, $salto_de_lineas);
							fwrite ($handle, "-- Insertando datos en la tabla ".$table_name[0]." ".PHP_EOL);
							fwrite ($handle, $salto_de_lineas);
							/*Creando el insert*/
							fwrite($handle, "INSERT INTO `" . $database. "`.`" . $table_name[0] . "` (");
							do {
								/*Cuando no sea el ultimo campo, finaliza la instruccion con una coma(,)*/
								if ($cont_fields != 1) {
									fwrite ($handle, $fields_row[0].", ");
								}
								/*Cuando sea el ultmo campo, finaliza la instruccion con ) y pasa al VALUES
								DE aqui en adelante tengo que mostrar los datos que quiero insertar*/
								if($cont_fields == 1){
									fwrite ($handle, $fields_row[0].") VALUES " . PHP_EOL);
								}
								/*Necesito decrementar el valor de cont_Fields porque si no, la computadora no
								Sabria cual es el ultimo campo, cuando cont_fields valga 1 la computadora entiende que es el ultimo.*/
								$cont_fields--;
							} while ($fields_row = $fileds->fetch_array());
						}

						/*Creando el algoritmo para los datos que van a ser insertados, ATENCION!!
						debo ver si el dato a insertar es BINARIO, NUMERICO O STRING*/

						do { /*Repite el SELECT * FROM almacenado en la variable dato*/
							fwrite ($handle, " (");
							$cols = $sql->query("DESC `".$table_name[0]."`");
							if ($tipo = $cols->fetch_array()) {
								$contador = 0;
								$temp     = 0;
								$array    = array();
								/*
									Estas 3 variables son fundamentales, la primera es un contador
                  el cual se ira incrementado en 1 mientras se ejecuta el bucle,
                  cuando el array tipo[1] sea alguna de las sentencias verdaderas
                  el arrar[] va a ser igual al valor que tenga en ese momento el
                  contador, es decir, que si en la 2 vuelta del bucle encuentra
									un true... array[0] va a ser igual a 2
								*/
								do {
									if ($tipo[1]=="tinyblob"  ||
											$tipo[1]=="mediumblob"||
											$tipo[1]=="blob"      ||
											$tipo[1]=="longblob") {
										$array[$temp] = $contador;
										$temp++;
									}
									$contador++;
								} while ($tipo = $cols->fetch_array());
							}
								/*
							Ya tendriamos los valores de los campos que son binarios en un simple
								arreglo de una dimension, luego tenemos que crear dos bucles for,
                El primer	bucle for se repetira tantas veces halla registros en
                la tabla, y el segundo bucle se ejecuta dentro del primero, su
                funcion es determinar si en el array[] definido anteriormente
                hay binarios.
							*/
							$numr = count($row);
							for ($i=0; $i < count($row); $i++) {
								/*
									$binario es la variable que hara el trabajo, es inicializada
                  en false, para que cuando se repita el bucle empieze como false.
								*/
								$binario = false;
								for ($c=0; $c < count($array); $c++) {
									if ($array[$c] == $i) {
										/*Cuando sea el primer valor*/
									if ($numr == count($row)){
											fwrite ($handle, "0x" . bin2hex($row[$i]) . ",");
											$binario = true;
										}
										/*Cuando no sea el primer valor*/
										if ($numr != 1) {
											fwrite ($handle, " 0x".bin2hex($row[$i]).",");
											$binario = true;
										}
										/*Cuando sea el ultimo valor*/
										if ($numr == 1) {
											fwrite ($handle, " 0x".bin2hex($row[$i]));
											$binario = true;
										}
									}
								}
								/*Si no hay binarios procede a evaluar si son numericos o cadenas de texto*/
								/*Cuando binario sea false, osea si no encontro binarios en esta posicion*/
								if (!$binario) {
									$ultimo = false;
									/*Cuando sea el primer valor*/
									if ($numr == count($row)) {
										/*Cundo sea un numero*/
										if (is_numeric($row[$i])) {
											fwrite ($handle, $row[$i] . ",");
										}
										/*Cuando sea un string*/
										if (!is_numeric($row[$i])){
											/*Cuando este vacio*/
											if ($row[$i] == '')
												fwrite ($handle, "NULL,");
											else
											fwrite ($handle, "'". $row[$i] . "',");
										}
									}
									/*Cuando sea el ultimo valor*/
									if ($numr == 1) {
										/*Cuando sea un numero*/
										if (is_numeric($row[$i])) {
											fwrite ($handle, " " . $row[$i]);
										}
										/*Cuando sea un string*/
										if (!is_numeric($row[$i])){
											/*Cuando este vacio*/
											if ($row[$i] == '')
												fwrite ($handle, " NULL");
											else
											fwrite ($handle, " '". $row[$i] . "'");
										}
										$ultimo = true;
									}
									/*Cuando no sea ni primer, ni ultimo valor*/
									if ($numr < count($row) && !$ultimo) {
										/*Cundo sea un numero*/
										if (is_numeric($row[$i])) {
											fwrite ($handle, " ".$row[$i].",");
										}
										/*Cuando sea un string*/
										if (!is_numeric($row[$i])){
											/*Cuando este vacio*/
											if ($row[$i] == '')
												fwrite ($handle, " NULL,");
											else
											fwrite ($handle, " '". $row[$i] . "',");
										}

									}
								}
							$numr--;
							}
							/*Cuando sea el ultimo registro*/
							if ($num_datos == 1) {
								fwrite ($handle, ");");
							}
							/*Cuando no sea el ultimo registro*/
							else{
								fwrite ($handle, "),");
							}
							fwrite ($handle, PHP_EOL);
							$num_datos--;
						} while ($row = $datos->fetch_row());
					}
					/*Fin del codigo para insertar*/
				}
			/*Bucle-1-FIN*/
			} while ($table_name = $tablas->fetch_array());
		/*Si hay tablas fin*/
		}
		/*Comentario SQL para el footer del archivo .sql generado*/
		fwrite ($handle, $salto_de_lineas);
    fwrite ($handle, "-- MySQL script generado por getDb v" . APP_VERSION . PHP_EOL);
    fwrite ($handle, "-- Autor: " . APP_AUTHOR . PHP_EOL);
    fwrite ($handle, "-- Url: " . APP_URL . PHP_EOL);
		fwrite ($handle, $salto_de_lineas);
		/*Cerrar el buffer de datos*/
		fclose ($handle);
	}
	/*Retornar datos a javascript*/
	$fecha  = date('Y-m-d-');
  $nombre = $fecha . $database . $ext;
	$descargar = $_POST['down'];
	$datos = array($nombre, $for, $descargar);
	echo json_encode($datos);
}
?>
