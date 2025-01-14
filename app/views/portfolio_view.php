<?php
/**
 * Principal view of the application Portfolio
 * 
 * author: José María Mayén Pérez
 * 
 */

$usuario = $data['usuario'];
$id = $data['id'];
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
    <title>Portfolio</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <header>
        <h1>Portfolio de <?php echo htmlspecialchars($usuario["nombre"]) ?></h1>
    </header>
    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
        </ul>
    </nav>

    <section>
        <section class="perfil">
            <h4>Perfil</h4>
            <img src="/img/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="img" width="50px">
            <?php echo htmlspecialchars($usuario["nombre"]) ?>
            <?php echo htmlspecialchars($usuario["apellidos"]) ?>
            <?php echo htmlspecialchars($usuario["categoria_profesional"]) ?>
            <?php echo htmlspecialchars($usuario["resumen_perfil"]) ?>
        </section>
        <section class="trabajos">
            <h4>Trabajos</h4>
            <?php if (empty($trabajos)): ?>
                <p>No existen trabajos.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha_Inicio</th>
                            <th>Fecha_Fin</th>
                            <th>Logros</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($trabajos as $trabajo) {
                            if ($trabajo['visible'] == 1) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($trabajo['titulo']) . "</td>";
                                echo "<td>" . htmlspecialchars($trabajo['descripcion']) . "</td>";
                                echo "<td>" . htmlspecialchars($trabajo['fecha_inicio']) . "</td>";
                                echo "<td>" . htmlspecialchars($trabajo['fecha_final']) . "</td>";
                                echo "<td>" . htmlspecialchars($trabajo['logros']) . "</td>";                         }   
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
        <section class="proyectos">
            <h4>Proyectos</h4>
            <?php if (empty($proyectos)): ?>
                <p>No existen proyectos.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Logo</th>
                            <th>Tecnologias</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($proyectos as $proyecto) {
                            if ($proyecto['visible'] == 1) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($proyecto['titulo']) . "</td>";
                            echo "<td>" . htmlspecialchars($proyecto['descripcion']) . "</td>";
                            echo "<td>" . htmlspecialchars($proyecto['logo']) . "</td>";
                            echo "<td>" . htmlspecialchars($proyecto['tecnologias']) . "</td>";
                            echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <section class="redes-sociales">
            <h4>Redes Sociales</h4>
            <?php if (empty($redes_sociales)): ?>
                <p>No existen redes sociales.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($redes_sociales as $red_social) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($red_social['redes_socialescol']) . "</td>";
                            echo "<td>" . htmlspecialchars($red_social['url']) . "</td>";
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

        <section class="skills">
            <h4>Habilidades</h4>
            <?php if (empty($skills)): ?>
                <p>No existen habilidades.</p>
            <?php else: ?>
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
                            if ($skill['visible'] == 1) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($skill['habilidades']) . "</td>";
                            echo "<td>" . htmlspecialchars($skill['categorias_skills_categoria']) . "</td>";
                            echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

    </section>
</body>
<footer>
    <p>José María Mayén Perez</p>
    <p>a23mapejo@gmail.com</p>
    <P>2ºDAW</P>
    <p>IES. Gran Capitan</p>
</footer>

</html>