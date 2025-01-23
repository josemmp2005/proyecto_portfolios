<?php
/**
 * Vista para añadir un nuevo proyecto
 */
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
    <h1>Añadir Proyecto</h1>
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
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
        <label for="tecnologias">Tecnologias</label>
        <input type="text" id="tecnologias" name="tecnologias">
        <label for="logo">Logo</label>
        <input type="file" id="logo" name="logo">
        <input type="submit" name="anadir_proyecto" value="Añadir Proyecto">
    </form>
</body>

</html>