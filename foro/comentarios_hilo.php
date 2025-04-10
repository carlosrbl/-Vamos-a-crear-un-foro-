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
    <title>Comentarios</title>
    <link rel="shortcut icon" href="img/utilidades/icono.png">
</head>
<body>
    <?php
        try
        {
            require_once "config.php";
        
            if (isset($_GET["id"]))
            {
                $id = $_GET["id"];
                $_SESSION["idHilo"] = $id;
        
                $texto_consulta = "SELECT * FROM hilos WHERE id = ?";
                $consulta = $pdo -> prepare($texto_consulta);
                $consulta -> execute([$id]);
        
                $hilo = $consulta -> fetch(PDO::FETCH_ASSOC);
                $fotoHilo = $hilo["ruta_foto_hilo"];

                $idUsuario = $hilo["id_usuario"];

                $texto_consulta2 = "SELECT * FROM usuarios WHERE id = ?";
                $consulta2 = $pdo -> prepare($texto_consulta2);
                $consulta2 -> execute([$idUsuario]);

                $fila = $consulta2 -> fetch(PDO::FETCH_ASSOC);
                
                $nombreUsuario = $fila["nombre"];

                ?>
                <div class="hilos">
                    <img src="
                    <?php 
                        if ($fotoHilo == null)
                        {
                            $fotoHilo = "img/utilidades/desconocido2.png";
                            echo $fotoHilo;
                        }
                        else
                        {
                            echo $hilo["ruta_foto_hilo"];
                        } 
                    ?>" alt="Foto del hilo" class="hilos-imagen">
                    <div class="hilos-datos">
                        <h2>Título: <?php echo $hilo["titulo"]; ?></h2>
                        <p>Descripción: <?php echo $hilo["descripcion"]; ?></p>
                        <h3>Autor: <?php echo $nombreUsuario; ?></h3>
                        <h4>Creación: <?php echo $hilo["creado"]; ?></h4>
                        <?php
                        if(isset($_SESSION["inicio"]))
                        {
                            $idUsuario = $_SESSION["usuario_id"];
                            $propietario = false;
                
                            if ($hilo["id_usuario"] == $idUsuario)
                            {
                                $propietario = true;
                            }
                            ?>
                            <button type="button" id="boton-crear" onclick="crearComentario()">Crear Comentario</button>
                            <?php
                            if ($propietario)
                            {
                                ?>
                                <button type="button" onclick="borrarHilo()" id="boton-eliminarHilo">Eliminar Hilo</button>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php
            }

            $texto_consulta2 = "SELECT * FROM comentarios WHERE id_hilo = ? ORDER BY creado DESC";
            $consulta2 = $pdo -> prepare($texto_consulta2);
            $consulta2 -> execute([$id]);
    
            $comentarios = $consulta2 -> fetchAll(PDO::FETCH_ASSOC);
            
            ?>
            <div class="comentarios">
                <?php
                foreach ($comentarios as $comentario)
                {
                    $texto_consulta3 = "SELECT nombre, ruta_foto_perfil FROM usuarios WHERE id = ?";
                    $consulta3 = $pdo -> prepare($texto_consulta3);
                    $consulta3 -> execute([$comentario["id_usuario"]]);

                    if ($consulta3 -> rowCount() > 0)
                    {
                        $fila = $consulta3 -> fetch(PDO::FETCH_ASSOC);
                        $nombreUsuario = $fila["nombre"];
                        $fotoUsuario = $fila["ruta_foto_perfil"];
                        
                        if ($fotoUsuario == null)
                        {
                            $fotoUsuario = "img/utilidades/desconocido.jpg";
                        }
                    }
                    
                    ?>
                        
                    <div class="hilos">
                        <img src="
                        <?php 
                            echo $fotoUsuario;
                        ?>" alt="Foto del usuario" class="hilos-imagen">
                        <div class="hilos-datos">
                            <h2>Usuario: <?php echo $nombreUsuario; ?></h2>
                            <p>Descripción: <?php echo $comentario["texto"]; ?></p>
                            <h3>Creación: <?php echo $comentario["creado"]; ?></h3>
                            <?php
                            if(isset($_SESSION["inicio"]))
                            {
                                $idUsuario = $_SESSION["usuario_id"];
                                $propietario = false;
                    
                                if ($comentario["id_usuario"] == $idUsuario)
                                {
                                    $propietario = true;
                                }
                                
                                if ($propietario)
                                {
                                    $_SESSION["id_comentario"] = $comentario["id"];
                                    ?>
                                    <button type="button" onclick="borrar()" id="boton-eliminarHilo">Eliminar Comentario</button>
                                <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php

            $pdo = null;
            $consulta = null;

            ?>
            <div class="botones">
                <button type="button" onclick="volverInicio()">Volver</button>
            </div>
            <div class="dialogs">
                <dialog id="dialog-crear-comentario">
                    <form action="crear_comentario.php" method="post" autocomplete="off">
                        <label for="texto_comentario">Texto</label>
                        <input type="text" name="texto_comentario" required>
                        <button type="submit">Crear</button>
                        <button type="button" onclick="cancelar()">Cancelar</button>
                    </form>
                </dialog>
            </div>
            <?php
        }
        catch (PDOException $e)
        {
            die("<script type='text/javascript'>
                alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
                window.location.href = 'index.php';
            </script>");
        }
    ?>
</body>
<script type="text/javascript">
    function volverInicio()
    {
        <?php
        if(isset($_SESSION["inicio"]))
        {
            ?>
            window.location.href = "hilo.php";
            <?php
        }
        else
        {
            ?>
            window.location.href = "index.php";
            <?php
        }
        ?>
    }
    function crearComentario()
    {
        document.querySelector("#dialog-crear-comentario").showModal();
    }
    function cancelar()
    {
        document.querySelector("#dialog-crear-comentario").close();
    }
    function borrar()
    {
        window.location.href = "eliminar_comentario.php";
    }
    function borrarHilo()
    {
        window.location.href = "eliminar_hilo.php";
    }
</script>
</html>