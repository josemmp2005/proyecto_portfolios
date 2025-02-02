<?php
/**
 * Vista para editar una habilidad
 */

// Se obtienen los datos de la habilidad a editar y las categorías de habilidades desde el controlador de habilidades 
$skills = $data["skill"];
$id = $data["id"];
$skill = null;

foreach ($skills as $s) {
    if ($s['id'] == $id) {
        $skill = $s;
        break;
    }
}

if ($skill === null) {
    echo "Habilidad no encontrada.";
}

$categorias = $data['categorias'];
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
        <h1>Edicion de Skill</h1>
        <h2><?php echo "Bienvenido " . $_SESSION["nombre"] . "!"; ?></h2>
    </header>
    <nav>
        <ul>
            <li><a href="/edit">Atras</a></li>
            <li><a href="/">Inicio</a></li>
        </ul>
    </nav>
    <main>
        <section class="editarPerfil">
            <form action="" method="post" class="form-new-trabajo">
                <label for="habilidad">Habilidad:</label>
                <input type="text" id="habilidades" name="habilidades" value="<?php echo $skill['habilidades']; ?>"
                    required><br>
                <label for="categoria_habilidad">Categoría Habilidad:</label>
                <select name="categoria_habilidad" id="categoria_habilidad">
                    <?php foreach ($categorias as $categoria) {
                        echo "<option value='" . $categoria['categoria'] . "'>" . $categoria['categoria'] . "</option>";
                    }
                    ?>
                </select><br>
                <label for="visible">Visible:</label>
                <input type="checkbox" id="visible" name="visible" value="1" <?php echo $skill['visible'] == 1 ? "checked" : "" ?>>
                <input type="submit" name="submit" value="Editar">
            </form>
        </section>
    </main>
    <footer class="footerLogin">
        <p>José María Mayén Perez</p>
        <p>a23mapejo@gmail.com</p>
        <P>2ºDAW</P>
        <p>IES. Gran Capitan</p>
    </footer>

</body>

</html>