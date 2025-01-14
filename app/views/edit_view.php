<?php
$usuario = $data['usuario'];
$trabajos = $data['trabajos'];
$proyectos = $data['proyectos'];
$redes_sociales = $data['redes_sociales'];
$skills = $data['skills'];

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
        <section class="perfil-edit">
            <h3>Editar Perfil</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="foto-perfil-edicion">
                    <img src="/img/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="img">
                    <label for="foto_perfil">Foto de Perfil</label>
                    <input type="file" id="foto_perfil" name="foto_perfil">
                </div>
                <div class="datos-perfil-edicion">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                        value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos"
                        value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                    <label for="categoria_profesional">Categoría Profesional</label>
                    <select name="categoria_profesional" id="categoria_profesional">
                        <option value="Desarrollador" <?php echo $usuario['categoria_profesional'] == 'Desarrollador' ? 'selected' : ''; ?>>Desarrollador</option>
                        <option value="Diseñador" <?php echo $usuario['categoria_profesional'] == 'Diseñador' ? 'selected' : ''; ?>>Diseñador</option>
                        <option value="Tester" <?php echo $usuario['categoria_profesional'] == 'Tester' ? 'selected' : ''; ?>>Tester</option>
                        <option value="Analista" <?php echo $usuario['categoria_profesional'] == 'Analista' ? 'selected' : ''; ?>>Analista</option>
                    </select><br>
                    <label for="resumen_perfil">Resumen Perfil</label>
                    <textarea name="resumen_perfil" id="resumen_perfil" cols="30"
                        rows="10"><?php echo htmlspecialchars($usuario['resumen_perfil']); ?></textarea><br>
                </div>

                <input type="submit" name="submit" value="Actualizar">
            </form>
        </section>
        <section class="trabajos">
            <h4>Trabajos</h4>
            <?php if (empty($trabajos)) : ?>
            <p>No existen trabajos.</p>
            <?php else : ?>
            <table>
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha_Inicio</th>
                    <th>Fecha_Fin</th>
                    <th>Logros</th>
                    <th>Visible</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($trabajos as $trabajo) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($trabajo['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($trabajo['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($trabajo['fecha_inicio']) . "</td>";
                    echo "<td>" . htmlspecialchars($trabajo['fecha_final']) . "</td>";
                    echo "<td>" . htmlspecialchars($trabajo['logros']) . "</td>";
                    echo "<td>" . htmlspecialchars($trabajo['visible']) . "</td>";
                    echo "<td>" .
                    '<a href="/editarTrabajo/' . $trabajo['id'] . '">Editar</a> ' .
                    '<a href="/eliminarTrabajo/' . $trabajo['id'] . '">Eliminar</a>' .
                    "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <?php endif; ?>
            <a href="/anadirTrabajo" class="anadir">Añadir</a>
        </section>
        <section class="proyectos">
            <h4>Proyectos</h4>
            <?php if (empty($proyectos)) : ?>
            <p>No existen proyectos.</p>
            <?php else : ?>
            <table>
                <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Logo</th>
                    <th>Tecnologias</th>
                    <th>Visible</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($proyectos as $proyecto) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($proyecto['titulo']) . "</td>";
                    echo "<td>" . htmlspecialchars($proyecto['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($proyecto['logo']) . "</td>";
                    echo "<td>" . htmlspecialchars($proyecto['tecnologias']) . "</td>";
                    echo "<td>" . htmlspecialchars($proyecto['visible']) . "</td>";
                    echo "<td>" .
                    '<a href="/editarProyecto/' . $proyecto['id'] . '">Editar</a> ' .
                    '<a href="/eliminarProyecto/' . $proyecto['id'] . '">Eliminar</a>' .
                    "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <?php endif; ?>
            <a href="/anadirProyecto" class="anadir">Añadir</a>
        </section>

        <section class="redes-sociales">
            <h4>Redes Sociales</h4>
            <?php if (empty($redes_sociales)) : ?>
            <p>No existen redes sociales.</p>
            <?php else : ?>
            <table>
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>URL</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($redes_sociales as $red_social) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($red_social['redes_socialescol']) . "</td>";
                    echo "<td>" . htmlspecialchars($red_social['url']) . "</td>";
                    echo "<td>" .
                    '<a href="/editarRedSocial/' . $red_social['id'] . '">Editar</a> ' .
                    '<a href="/eliminarRedSocial/' . $red_social['id'] . '">Eliminar</a>' .
                    "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <?php endif; ?>
            <a href="/anadirRedSocial" class="anadir">Añadir</a>
        </section>

        <section class="skills">
            <h4>Habilidades</h4>
            <?php if (empty($skills)) : ?>
            <p>No existen habilidades.</p>
            <?php else : ?>
            <table>
                <thead>
                <tr>
                    <th>Habilidad</th>
                    <th>Categoría Habilidad</th>
                    <th>Visible</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($skills as $skill) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($skill['habilidades']) . "</td>";
                    echo "<td>" . htmlspecialchars($skill['categorias_skills_categoria']) . "</td>";
                    echo "<td>" . htmlspecialchars($skill['visible']) . "</td>";
                    echo "<td>" .
                    '<a href="/editarHabilidad/' . $skill['id'] . '">Editar</a> ' .
                    '<a href="/eliminarHabilidad/' . $skill['id'] . '">Eliminar</a>' .
                    "</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <?php endif; ?>
            <a href="/anadirSkill" class="anadir">Añadir</a>
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