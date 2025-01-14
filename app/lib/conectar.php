<?php
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

function conectaDB()
{
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    $dbHost = $_ENV['DB_HOST'];
    $dbName = $_ENV['DB_NAME'];
    $dbUser = $_ENV['DB_USER'];
    $dbPass = $_ENV['DB_PASS'];

    try {
        // Conexión con la base de datos
        $dsn = "mysql:host=$dbHost;dbname=$dbName";
        $db = new PDO($dsn, $dbUser, $dbPass);

        // Configuración de atributos para la conexión PDO
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Manejo de errores
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // Modo de fetch predeterminado
        $db->exec('SET NAMES utf8'); // Configuración de codificación UTF-8

        return $db;
    } catch (PDOException $e) {
        // Manejo de errores y salida
        echo "Error de conexión: " . $e->getMessage();
        exit();
    }
}