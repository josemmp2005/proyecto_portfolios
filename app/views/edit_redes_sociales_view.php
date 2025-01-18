<?php
/**
 * Vista para editar una red social
 */

 // Se reciben todas las redes sociales del usuario y el ID de la red social a editar
    $redes_sociales = $data["redSocial"];
    $id = $_GET['id'];
    $red_social = null;

    foreach ($redes_sociales as $rs) {
        if ($rs['id'] == $id) {
            $red_social = $rs;
            break;
        }
    }

    if ($red_social === null) {
        echo "Red social no encontrada.";
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
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $red_social['redes_socialescol'] ?>" required><br>
                <label for="url">URL:</label>
                <input type="text" id="url" name="url" value="<?php echo $red_social['url'] ?>" required><br>
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