<?php
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $usuario = $_POST["nombre_usuario"];
        $contrasenya = $_POST["password"];

        if (strtolower($usuario) == "usuario eliminado")
        {
            die("<script type='text/javascript'>
                alert('No se puede acceder a usuarios eliminados');
                window.location.href = 'index.php';
            </script>");
        }
        else
        {
            try
            {
                require_once "config.php";
                
                $texto_consulta = "SELECT id, email, contrasenya FROM usuarios WHERE nombre = ?";
                
                $consulta = $pdo -> prepare($texto_consulta);
                $consulta -> execute([$usuario]);

                if ($consulta -> rowCount() > 0)
                {
                    $fila = $consulta -> fetch(PDO::FETCH_ASSOC);
                    $contrasenyaHash = $fila["contrasenya"];

                    if (password_verify($contrasenya,$contrasenyaHash))
                    {
                        $_SESSION["inicio"] = true;
                        $_SESSION["usuario_id"] = $fila["id"];
                        $_SESSION["usuario_email"] = $fila["email"];
                        
                        die("<script type='text/javascript'>
                            window.location.href = 'index.php';
                        </script>");
                    }
                    else
                    {
                        die("<script type='text/javascript'>
                            alert('Usuario o contraseña incorrectos');
                            window.location.href = 'index.php';
                        </script>");
                    }
                }
                else
                {
                    die("<script type='text/javascript'>
                            alert('Usuario o contraseña incorrectos');
                            window.location.href = 'index.php';
                        </script>");
                }
                
                $pdo = null;
                $consulta = null;
                //No hay que dar pistas de si el usuario es correcto
            }
            catch (PDOException $e)
            {
                die("<script type='text/javascript'>
                    alert('Fallo en la ejecución: " . addslashes($e->getMessage()) . "');
                    window.location.href = 'index.php';
                </script>");
            }
        }
    }
    else
    {
        header("Location: ./index.php");
    }
?>