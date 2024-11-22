<?php
    session_start();
    // Incluindo o arquivo de conexão
    include './src/config/conexao.php';

    // Consulta de notícias publicadas
    $query = "SELECT * FROM noticias WHERE status = 'aprovada'";
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de notícias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./src/styles/styles.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <!-- Logo e Links -->
                <a class="navbar-brand" href="#">Portal de Notícias</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Tecnologia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Esportes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Entretenimento</a>
                        </li>
                    </ul>
                    <!-- Link de Login -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <h1>Notícias Publicadas</h1>
        <div class="noticias">
            <?php
                // Verificando se a consulta retornou resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='noticia'>
                                <h2>{$row['titulo']}</h2>
                                <img src='{$row['imagem']}' alt='Imagem'>
                                <p>{$row['conteudo']}</p>
                                <small>Autor: {$row['autor']} - {$row['data_criacao']}</small>
                            </div>";
                    }
                } else {
                    echo "<p>Nenhuma notícia encontrada.</p>";
                }
            ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Portal de Notícias</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
