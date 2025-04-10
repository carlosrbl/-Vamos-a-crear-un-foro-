<?php
    session_start();

    $idUsuario = $_SESSION["usuario_id"];
    $idHilo = $_SESSION["idHilo"];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $texto = $_POST["texto_comentario"]; 
            
        try
        {
            require_once "config.php";
            
            $texto_consulta = "INSERT INTO comentarios (id_hilo,id_usuario,texto)
            VALUES (?,?,?)";

            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$idHilo,$idUsuario,$texto]);

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
    }
    else
    {
        header("Location: ./index.php");
    }

?>