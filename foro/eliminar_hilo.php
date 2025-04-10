<?php
    session_start();

    $idUsuario = $_SESSION["usuario_id"];
    $idHilo = $_SESSION["idHilo"];

    try
    {   
        require_once "config.php";
    
        $texto_consulta = "DELETE FROM comentarios WHERE id_hilo = ?";
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute([$idHilo]);

        $texto_consulta2 = "DELETE FROM hilos WHERE id = ?";
        $consulta2 = $pdo -> prepare($texto_consulta2);
        $consulta2 -> execute([$idHilo]);
        
        $pdo = null;
        $consulta = null;
        
        die("<script type='text/javascript'>
            window.location.href = 'hilo.php';
        </script>");
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>");
    }
?>
