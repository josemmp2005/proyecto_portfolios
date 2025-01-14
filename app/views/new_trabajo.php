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
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="fecha_inicio">Fecha Inicio</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>
        <label for="fecha_final">Fecha Final</label>
        <input type="date" id="fecha_final" name="fecha_final">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
        <label for="descripcion">Logros</label>
        <textarea name="logros" id="logros" cols="30" rows="8"></textarea>
        <input type="submit" name="anadir_trabajo" value="Añadir Trabajo">
    </form>
</body>

</html>