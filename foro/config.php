<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbName = "foro";

    try 
    {
        $pdo = new PDO("mysql:host={$serverName};dbname={$dbName}", $username, $password);
        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        die("<script type='text/javascript'>
            alert('Ha fallado la conexión: " . addslashes($e->getMessage()) . "');
            window.location.href = 'index.php';
        </script>");
    }
?>