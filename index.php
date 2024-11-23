<?php
session_start();
// Incluindo o arquivo de conexão
include './src/config/conexao.php';

// Consulta de notícias publicadas
$query = "SELECT noticias.*, usuarios.nome AS autor
          FROM noticias
          JOIN usuarios ON noticias.id_escritor = usuarios.id
          WHERE status = 'aprovada'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Portal de Notícias</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/pages/login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="noticias">
            <?php
                // Verificando se a consulta retornou resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='noticia'>
                                <h2>{$row['titulo']}</h2>
                                <p>{$row['conteudo']}</p>
                                <small>Autor: {$row['autor']} - {$row['data_criacao']}</small>
                            </div>";
                    }
                } else {
                    echo "<div class='d-flex justify-content-center align-items-center vh-100'>
                    <p class='text-center text-muted fw-bold fs-4'>Nenhuma notícia encontrada.</p>
                  </div>";
                }
            ?>
        </div>
    </main>

    <footer>
        <div>
            <p>&copy; 2024 Portal de Notícias. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
