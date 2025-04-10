<?php
    session_start();

    $idUsuario = $_SESSION["usuario_id"];
    $idComentario = $_SESSION["id_comentario"];

    try
    {   
        require_once "config.php";
    
        $texto_consulta = "DELETE FROM comentarios WHERE id = ?";
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute([$idComentario]);

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
