<?php
    session_start();

    $idUsuario = $_SESSION["usuario_id"];

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $titulo = $_POST["titulo_hilo"];
        $descripcion = $_POST["descripcion_hilo"];

        if (is_uploaded_file ($_FILES["foto_hilo"]["tmp_name"])) 
        {
            $nombreDirectorio = "img/data/hilos/";
            $idUnico = time();   
            $rutaFotoHilo = $idUnico . "-" . $_FILES["foto_hilo"]["name"]; 
            move_uploaded_file ($_FILES["foto_hilo"]["tmp_name"], $nombreDirectorio . 
            $rutaFotoHilo);
            $rutaFotoHilo = $nombreDirectorio . $rutaFotoHilo;
        }
        else
        {
            $rutaFotoHilo = null;
        }   
            
        try
        {
            require_once "config.php";
            
            $texto_consulta = "INSERT INTO hilos (id_usuario,titulo,descripcion,ruta_foto_hilo)
            VALUES (?,?,?,?)";

            $consulta = $pdo -> prepare($texto_consulta);
            $consulta -> execute([$idUsuario,$titulo,$descripcion,$rutaFotoHilo]);

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