<?php
    session_start();

    $idUsuario = $_SESSION["usuario_id"];

    try
    {   
        require_once "config.php";

        $usuario = "Usuario Eliminado";
        $rutaFoto = "img/utilidades/desconocido.jpg";
        $nulo = null;
    
        $texto_consulta = "UPDATE usuarios SET nombre = ?, ruta_foto_perfil = ?, email = ?, contrasenya = ? WHERE id = ?";
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute([$usuario,$rutaFoto,$nulo,$nulo,$idUsuario]);

        $pdo = null;
        $consulta = null;
        session_unset();
        session_destroy();
        header("Location: ./index.php");
        die();
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>");
    }
?>
