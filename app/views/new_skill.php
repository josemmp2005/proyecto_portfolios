<?php
    /**
     * Vista para añadir una habilidad
     */

     // Obtiene las categorías de habilidades
    $categorias = $data['categorias'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<header>
    <h1>Añadir Trabajo</h1>
    <h2><?php echo "Bienvenido " . $_SESSION["nombre"] . "!"; ?></h2>
    </header>
<nav>
    <ul>
        <li><a href="/edit">Atras</a></li>
        <li><a href="/">Inicio</a></li>
    </ul>
</nav>

<body>
    <form action="" method="post" class="form-new-trabajo">
        <label for="habilidad">Habilidad:</label>
        <input type="text" id="habilidades" name="habilidades" required><br>
        <label for="categoria_habilidad">Categoría Habilidad:</label>
        <select name="categoria_habilidad" id="categoria_habilidad">
            <?php foreach ($categorias as $categoria) {
                echo "<option value='" . $categoria['categoria'] . "'>" . $categoria['categoria'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit" name="anadir_habilidad" value="Añadir Habilidad">
    </form>
</body>

</html>