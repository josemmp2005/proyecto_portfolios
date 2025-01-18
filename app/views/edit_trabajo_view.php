<?php
    /**
     *  Vista para editar un trabajo 
     */

     // Se obtiene todos los trabajos del usuario y se busca el trabajo a editar por su ID
    $trabajos = $data["trabajo"];
    $id = $_GET['id'];
    $trabajo = null;

    foreach ($trabajos as $t) {
        if ($t['id'] == $id) {
            $trabajo = $t;
            break;
        }
    }

    if ($trabajo === null) {
        echo "Trabajo no encontrado.";
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
    </header>
    <nav>
        <ul>
            <li><a href="/logout">Cerrar Sesión</a></li>
            <li><a href="/">Inicio</a></li>
        </ul>
    </nav>
    <main>
        <section class="editarPerfil">
            <form action="" method="post" class ="form-new-trabajo">
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $trabajo['titulo'] ?>" required>
                <label for="descripcion">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo $trabajo['descripcion'] ?>" required>
                <label for="fecha_inicio">Fecha de inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo $trabajo['fecha_inicio'] ?>" required>
                <label for="fecha_final">Fecha de finalizacion:</label>
                <input type="date" id="fecha_final" name="fecha_final" value="<?php echo $trabajo['fecha_final'] ?>" required>
                <label for="logros">Logros:</label>
                <input type="text" id="logros" name="logros" value="<?php echo $trabajo['logros'] ?>" required>
                <label for="visible">Visible:</label>
                <input type="checkbox" id="visible" name="visible" value="1" <?php echo $trabajo['visible'] == 1 ? "checked" : "" ?>>
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