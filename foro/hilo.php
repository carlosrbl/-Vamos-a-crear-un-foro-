<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Foros">
    <meta name="author" content="Carlos Rodrigo Beltrá">
    <link rel="stylesheet" href="style.css">
    <title>Hilos</title>
    <link rel="shortcut icon" href="img/utilidades/icono.png">
</head>
<body>
    <?php
        ?>
        <h1>Últimos Hilos:</h1>
        <?php
        try
        {   
            require_once "config.php";
    
            $texto_consulta = "SELECT * FROM hilos ORDER BY creado DESC LIMIT 10";
            
            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute();
    
            $hilos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($hilos as $hilo)
            {
                $idUsuario = $hilo["id_usuario"];

                $texto_consulta2 = "SELECT * FROM usuarios WHERE id = ?";
                $consulta2 = $pdo -> prepare($texto_consulta2);
                $consulta2 -> execute([$idUsuario]);

                $fila = $consulta2 -> fetch(PDO::FETCH_ASSOC);
                
                $nombreUsuario = $fila["nombre"];

                $fotoHilo = $hilo["ruta_foto_hilo"];
                ?>
                <a href="comentarios_hilo.php?id=<?php echo $hilo["id"]; ?>" class="hilo-enlace">
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
                        </div>
                    </div>
                </a>
                <?php
            }
    
            $pdo = null;
            $consulta = null;
    
            ?>
            <div class="botones">
                <button type="button" onclick="menuPerfil()">Volver al Perfil</button>
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
    function menuPerfil()
    {
        window.location.href = "index.php";
    }
</script>
</html>