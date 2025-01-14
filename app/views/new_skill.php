<?php
    $categorias = $_SESSION["categoriasSkill"]
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