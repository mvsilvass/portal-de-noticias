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
</head>
<body>
    <header>
        <div>
            <!-- Colocar algum ícone ou logo -->
            <h1>Portal de Notícias</h1>
        </div>

        <nav>
            <!-- fazer um dropdown -->
            <div>
                <h2>Categorias</h2>
                <ul>
                    <li><a href="./pages/esportes.php">Esportes</a></li>
                    <li><a href="./pages/tecnologia.php">Tecnologia</a></li>
                    <li><a href="./pages/entretenimento.php">Entretenimento</a></li>
                </ul>
            </div>
            <a href="./pages/login.php">Login</a>
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
</body>
</html>
