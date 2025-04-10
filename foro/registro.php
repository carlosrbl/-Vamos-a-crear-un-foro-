<?php
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = $_POST["nombre_usuario"];
        $email = $_POST["email"];
        
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
            
            $texto_consulta2 = "SELECT * FROM usuarios";
            $consulta2 = $pdo -> prepare($texto_consulta2);
            $consulta2 -> execute();

            $correos = $consulta2 -> fetchAll(PDO::FETCH_ASSOC);

            foreach ($correos as $correo)
            {
                if ($correo["email"] == $email)
                {
                    $existe = true;
                }
            }

            if ($existe)
            {
                die("<script type='text/javascript'>
                        alert('Este correo ya está en uso');
                        window.location.href = 'index.php';
                    </script>");
            }

            $texto_consulta = "INSERT INTO usuarios (nombre,email,contrasenya,ruta_foto_perfil)
            VALUES (?,?,?,?)";
            
            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$usuario,$email,$contrasenya,$rutaFotoPerfil]);

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