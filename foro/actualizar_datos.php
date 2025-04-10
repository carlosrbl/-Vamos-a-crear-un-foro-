<?php
    session_start();
    
    $idUsuario = $_SESSION["usuario_id"];
    $emailUsuario = $_SESSION["usuario_email"];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = $_POST["nombre_usuario"];
        $contrasenya = password_hash($_POST["password"],PASSWORD_BCRYPT);

        if (is_uploaded_file ($_FILES["foto_perfil"]["tmp_name"])) 
        {
            $nombreDirectorio = "img/data/usuarios/";
            $idUnico = time();   
            $rutaFotoPerfil = $idUnico . "-" . $_FILES["foto_perfil"]["name"]; 
            move_uploaded_file ($_FILES["foto_perfil"]["tmp_name"], $nombreDirectorio . 
            $rutaFotoPerfil);
            $rutaFotoPerfil = $nombreDirectorio . $rutaFotoPerfil;
        }
        else
        {
            $rutaFotoPerfil = null;
        }   
            
        try
        {
            require_once "config.php";
            
            $texto_consulta = "UPDATE usuarios SET nombre = ?, email = ?, contrasenya = ?, ruta_foto_perfil = ?
            WHERE id = ?";

            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$usuario,$emailUsuario,$contrasenya,$rutaFotoPerfil,$idUsuario]);

            $pdo = null;
            $consulta = null;

            die("<script type='text/javascript'>
                        window.location.href = 'index.php';
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