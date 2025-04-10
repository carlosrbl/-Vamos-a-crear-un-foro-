<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Foros">
    <meta name="author" content="Carlos Rodrigo Beltrá">
    <link rel="stylesheet" href="style.css">
    <title>Foro</title>
    <link rel="shortcut icon" href="img/utilidades/icono.png">
</head>
<body>
    <div class="contenedor">
        <?php
            if(isset($_SESSION["inicio"]))
            {
                require_once "user.php";
            }
            else
            {
                ?>
                <div class="formularios">
                    <div class="form">
                        <h1>Registro</h1>
                        <form action="registro.php" method="post" autocomplete="off" enctype="multipart/form-data">
                            <label for="nombre_usuario">Nombre de Usuario</label>
                            <input type="text" name="nombre_usuario" required>
                            <label for="email">Email</label>
                            <input type="email" name="email" required>
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" required>
                            <label for="foto_perfil">Foto de Perfil</label>
                            <input type="file" name="foto_perfil">
                            <button type="submit">Registrarse</button>
                        </form>
                    </div>
                    <div class="form">
                        <h1>Iniciar Sesión</h1>
                        <form action="inicioSesion.php" method="post" autocomplete="off">
                            <label for="nombre_usuario">Nombre de Usuario</label>
                            <input type="text" name="nombre_usuario" required>
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" required>
                            <button type="submit">Iniciar Sesión</button>
                        </form>
                    </div> 
                </div>
                    <?php
                        require_once "hilos_recientes.php";
            }
            ?>
    </div>
</body>
</html>