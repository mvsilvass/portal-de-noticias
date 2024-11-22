<?php

    $host = 'localhost';
    $dbname = 'portal_noticia';
    $username = 'root';
    $password = '';

    // Criando a conexão
    $conn = new mysqli($host, $username, $password, $dbname);

    // Verificando a conexão
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
