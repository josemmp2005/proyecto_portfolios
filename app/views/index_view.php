<?php
/**
 * Principal view of the application Portfolio
 * 
 * author: José María Mayén Pérez
 * 
 */
$autenticado = $data['autenticado'];
$portfolios = $data['portfolios'];

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
        <h1>Dashboard</h1>
    </header>
    <nav>
        <ul>
            <?php if ($autenticado): ?>
                <li><a href="/edit">Editar Perfil</a></li>
                <li><a href="/logout">Cerrar sesión</a></li>
            <?php else: ?>
                <li><a href="/login">Iniciar sesión</a></li>
                <li><a href="/register">Registro</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <form action="" method="post">
        <input type="text" name="nombre" id="nombre" placeholder="Buscador">
        <button type="submit" name="search">Buscar</button>
    </form>
    <section>

        <section class="vistaPortfolios">
            <?php if (!empty($portfolios)): ?>
                <?php
                foreach ($portfolios as $portfolio) {
                    if ($portfolio['visible'] == 1) {
                        echo '<article>';
                        echo '<img src="' . "img/". htmlspecialchars($portfolio['foto']) . '" alt="img">';
                        ;
                        echo '<h3>' . htmlspecialchars($portfolio['nombre']) . '</h3>';
                        echo '<p class="correo">' . htmlspecialchars($portfolio['email']) . '</p>';
                        echo '<p class="categoriaProfesional">' . htmlspecialchars($portfolio['categoria_profesional']) . '</p>';
                        echo '<a href="/verPortfolio?id=' . htmlspecialchars($portfolio['id']) . '">';
                        echo '<img src= img/visibility.svg alt=img id=visibility>';
                        echo '</a>';
                        echo '</article>';
                    }
                }
                ?>
            <?php else: ?>
                <p>No se encontraron resultados.</p>
            <?php endif; ?>
        </section>
</body>
<footer>
    <p>José María Mayén Perez</p>
    <p>a23mapejo@gmail.com</p>
    <P>2ºDAW</P>
    <p>IES. Gran Capitan</p>
</footer>

</html>