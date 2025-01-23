<?php
/**
 * Vista para editar un proyecto 
 */

// Se obtiene todos los proyectos del usuario y se busca el proyecto a editar por su ID
$proyectos = $data["proyecto"];
$id = $data['id'];
$proyecto = null;

foreach ($proyectos as $p) {
    if ($p['id'] == $id) {
        $proyecto = $p;
        break;
    }
}

if ($proyecto === null) {
    echo "Proyecto no encontrado.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Perfil</title>

</head>

<body>
    <header>
        <h1>Ajustes del perfil</h1>
        <h2><?php echo "Bienvenido " . $_SESSION["nombre"] . "!"; ?></h2>
    </header>
    <nav>
        <ul>
            <li><a href="/edit"></a>Atras</a></li>
            <li><a href="/">Inicio</a></li>
        </ul>
    </nav>
    <main>
        <section class="editarPerfil">
            <form action="" method="POST" enctype="multipart/form-data" class="form-new-trabajo">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo"
                    value="<?php echo htmlspecialchars($proyecto['titulo']); ?>" required>
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="10"
                    required><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
                <label for="tecnologias">Tecnologías:</label>
                <input type="text" id="tecnologias" name="tecnologias"
                    value="<?php echo htmlspecialchars($proyecto['tecnologias']); ?>" required>
                <label for="logo">Logo:</label>
                <input type="file" id="logo" name="logo">
                <label for="visible">Visible:</label>
                <input type="checkbox" id="visible" name="visible" value="1" <?php echo $proyecto['visible'] == 1 ? "checked" : ""; ?>>
                <input type="submit" name="submit" value="Editar">
            </form>
        </section>
    </main>
    <footer>
        <p>José María Mayén Perez</p>
        <p>a23mapejo@gmail.com</p>
        <P>2ºDAW</P>
        <p>IES. Gran Capitan</p>
    </footer>

</body>

</html>