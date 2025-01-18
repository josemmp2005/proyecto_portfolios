<?php
    // Carga el autoloader de Composer para gestionar las dependencias
    require 'vendor/autoload.php';

    // Importa la clase Dotenv para gestionar variables de entorno
    use Dotenv\Dotenv;

    // Crea una instancia de Dotenv y carga las variables de entorno desde el archivo .env
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Define constantes para la configuración de la base de datos
    define("DBHOST", "localhost");
    define("DBUSER", "root");
    define("DBPASS", "root");
    define("DBNAME", "portfolio");
    define("DBPORT", "3306");

?>