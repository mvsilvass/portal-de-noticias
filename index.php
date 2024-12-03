<?php
session_start();

// Incluindo o arquivo de conexão
include './src/config/conexao.php';

// Consulta de notícias publicadas
$query = "SELECT noticias.*, usuarios.nome AS autor FROM noticias JOIN usuarios ON noticias.id_escritor = usuarios.id WHERE status = 'aprovada'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./src/styles/styles.css">
</head>
<body class="bg-light">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <div class="container-fluid">
                <a class="navbar-brand" href="./">Portal de Notícias</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./src/pages/login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container py-5 flex-grow-1">
        <div class="row">
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='col-md-4 mb-4'>
                                <div class='card h-100'>";
                                    
                                    // Exibindo a imagem, se houver
                                    if (!empty($row['imagem'])) {
                                        echo "<img src='./src/imagens/{$row['imagem']}' class='card-img-top' alt='Imagem da notícia'>";
                                    }

                                    echo "<div class='card-body'>
                                            <h5 class='card-title'>{$row['titulo']}</h5>
                                            <p class='card-text'>" . $row['conteudo'] . "</p>
                                          </div>
                                          <div class='card-footer bg-dark text-white'>
                                            <p>Autor: {$row['autor']}</p>
                                            <p>Data: {$row['data_criacao']}</p>
                                          </div>
                                      </div>
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

    <footer class="text-white text-center py-3" style="background-color: #343a40;">
        <div>Portal de Notícias &copy; <?php echo date('Y'); ?></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
