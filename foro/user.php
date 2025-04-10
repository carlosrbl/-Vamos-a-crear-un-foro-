<?php
    $idUsuario = $_SESSION["usuario_id"];

    try
    {
        require_once "config.php";
            
        $texto_consulta = "SELECT nombre, email, ruta_foto_perfil FROM usuarios WHERE id = ?";
        
        $consulta = $pdo -> prepare($texto_consulta);
        $consulta -> execute([$idUsuario]);

        $fila = $consulta -> fetch(PDO::FETCH_ASSOC);
        $usuario = $fila["nombre"];
        $email = $fila["email"];
        $fotoPerfil = $fila["ruta_foto_perfil"];
        
        if ($fotoPerfil == null)
        {
            $fotoPerfil = "img/utilidades/desconocido.jpg";
        }

        $pdo = null;
        $consulta = null;

        ?>
        <div class="datos">
            <div class="perfil">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto del Usuario">
                <div class="perfil_info">
                    <h3>Usuario: <?php echo $usuario; ?></h3>
                    <h3>Email: <?php echo $email; ?></h3>
                </div>
            </div>
        </div>
        <div class="botones">
            <button type="button" onclick="actualizarDatos()">Actualizar Datos</button>
            <button type="button" onclick="crearNuevoHilo()">Crear Nuevo Hilo</button>
            <button type="button" onclick="mostrarHilos()">Ver Hilos</button>
            <button type="button" id="boton-cerrar" onclick="cerrarSesion()">Cerrar Sesión</button>
            <button type="button" id="boton-eliminar" onclick="eliminarCuenta()">Eliminar Cuenta</button>
        </div>
        <div class="dialogs">
            <dialog id="dialog-actualizar-datos">
                <form action="actualizar_datos.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" name="nombre_usuario" required>
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" required>
                    <label for="foto_perfil">Foto de Perfil</label>
                    <input type="file" name="foto_perfil">
                    <button type="submit">Actualizar datos</button>
                    <button type="button" onclick="cancelar()">Cancelar</button>
                </form>
            </dialog>
        </div>
        <div class="dialogs">
            <dialog id="dialog-eliminar-cuenta">
                <h1>¿SEGURO?</h1>
                <div class="centrar">   
                    <button type="button" id="boton-borrar" onclick="borrar()">Sí</button>
                    <button type="button" id="boton-cancelar" onclick="cancelar()">No</button>
                </div>
            </dialog>
        </div>
        <div class="dialogs">
            <dialog id="dialog-crear-hilo">
                <form action="crear_hilo.php" method="post" autocomplete="off" enctype="multipart/form-data">
                    <label for="titulo_hilo">Título</label>
                    <input type="text" name="titulo_hilo" required>
                    <label for="descripcion_hilo">Descripción</label>
                    <input type="text" name="descripcion_hilo" required>
                    <label for="foto_hilo">Foto</label>
                    <input type="file" name="foto_hilo">
                    <button type="submit">Crear hilo</button>
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

<script type="text/javascript">
    function cancelar()
    {
        document.querySelector("#dialog-actualizar-datos").close();
        document.querySelector("#dialog-eliminar-cuenta").close();
        document.querySelector("#dialog-crear-hilo").close();
    }
    function actualizarDatos()
    {
        document.querySelector("#dialog-actualizar-datos").showModal();
    }
    function eliminarCuenta()
    {
        document.querySelector("#dialog-eliminar-cuenta").showModal();
    }
    function crearNuevoHilo()
    {
        document.querySelector("#dialog-crear-hilo").showModal();
    }
    function cerrarSesion()
    {
        window.location.href = "cerrarSesion.php";
    }
    function mostrarHilos()
    {
        window.location.href = "hilo.php";
    }
    function borrar()
    {
        window.location.href = "eliminar_usuario.php";
    }
</script>