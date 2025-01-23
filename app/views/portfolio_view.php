<?php
/**
 * Vista para mostrar el portfolio de un usuario
 */

// Obtiene los datos enviados desde el controlador
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
        <h2><?php echo "Bienvenido " . $_SESSION["nombre"] . "!"; ?></h2>

    </header>
    <nav>
        <ul>
            <li><a href="/">Inicio</a></li>
        </ul>
    </nav>

    <section>
        <section class="perfil">
            <article class="foto">
                <img src="/img/<?php echo htmlspecialchars($usuario['foto']); ?>" alt="img">
            </article>
            <article class="info">
                <p>Nombre</p>
                <?php echo htmlspecialchars($usuario["nombre"]) ?>
                <p>Apellidos</p>
                <?php echo htmlspecialchars($usuario["apellidos"]) ?>
                <p>Email</p>
                <?php echo htmlspecialchars($usuario["email"]) ?>
                <p>Categoria Profesional</p>
                <?php echo htmlspecialchars($usuario["categoria_profesional"]) ?>
                <p>Resumen Perfil</p>
                <?php echo htmlspecialchars($usuario["resumen_perfil"]) ?>
            </article>
        </section>
        <section class="trabajos">
            <?php
                $cont = 0;
                foreach ($trabajos as $trabajo) {
                    if ($trabajo['visible'] == 1) {
                        $cont++;
                    }
                }
                if ($cont >= 1) {
                    echo "<h4>Trabajos</h4>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Título</th>";
                    echo "<th>Descripción</th>";
                    echo "<th>Fecha_Inicio</th>";
                    echo "<th>Fecha_Fin</th>";
                    echo "<th>Logros</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                }

                foreach ($trabajos as $trabajo) {
                    if ($trabajo['visible'] == 1) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($trabajo['titulo']) . "</td>";
                        echo "<td>" . htmlspecialchars($trabajo['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars($trabajo['fecha_inicio']) . "</td>";
                        echo "<td>" . htmlspecialchars($trabajo['fecha_final']) . "</td>";
                        echo "<td>" . htmlspecialchars($trabajo['logros']) . "</td>";
                    }
                }
            ?>
            </tbody>
            </table>
        </section>
        <section class="proyectos">
            <?php
                $cont = 0;
                foreach ($proyectos as $proyecto) {
                    if ($proyecto['visible'] == 1) {
                        $cont++;
                    }
                }
                if ($cont >= 1) {
                    echo "<h4>Proyectos</h4>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Título</th>";
                    echo "<th>Descripción</th>";
                    echo "<th>Logo</th>";
                    echo "<th>Tecnologias</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                }

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
        </section>

        <section class="redes-sociales">
            <?php 
                if ($redes_sociales) {
                    echo "<h4>Redes Sociales</h4>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Nombre</th>";
                    echo "<th>URL</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                }

                foreach ($redes_sociales as $red_social) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($red_social['redes_socialescol']) . "</td>";
                    echo "<td>" . htmlspecialchars($red_social['url']) . "</td>";
                }
            ?>
            </tbody>
            </table>
        </section>

        <section class="skills">
            <?php 
                $cont = 0;
                foreach ($skills as $skill) {
                    if ($skill['visible'] == 1) {
                        $cont++;
                    }
                }
                if ($cont >= 1) {
                    echo "<h4>Habilidades</h4>";
                    echo "<table>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Habilidad</th>";
                    echo "<th>Categoría Habilidad</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                }
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