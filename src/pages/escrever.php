<?php
session_start();
require_once '../config/conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'escritor') {
    header("Location: acesso_negado.php");
    exit;
}

$erro = $sucesso = '';

// Processa o envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    // Verifica se os campos estão preenchidos
    if (empty($titulo) || empty($conteudo)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        // Prepara a inserção da notícia no banco de dados
        $id_escritor = $_SESSION['usuario_id'];
        $status = 'pendente'; // Status inicial da notícia
        $stmt = $conn->prepare("INSERT INTO noticias (titulo, conteudo, id_escritor, status, imagem) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $titulo, $conteudo, $id_escritor, $status, $imagem_caminho);

        if ($stmt->execute()) {
            $sucesso = "Notícia cadastrada com sucesso!";
        } else {
            $erro = "Erro ao cadastrar notícia.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escrever Notícia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../styles/styles.css" rel="stylesheet">
    <style>
        input.form-control:focus, textarea.form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(211, 211, 211, 0.5) !important;
            border-color: #d3d3d3 !important;
            outline: none !important;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            margin-bottom: 20px;
        }
        .form-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body class="bg-light">

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <div class="container-fluid">
                <a class="navbar-brand" href="../../index.php">Portal de Notícias</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="./logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Formulário -->
    <div class="form-container">
        <div class="card p-4 shadow-lg" style="width: 100%; max-width: 600px;">
            <h2 class="text-center text-secondary mb-4">Escrever notícia</h2>

            <?php if (!empty($erro)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $erro; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($sucesso)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sucesso; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título da notícia" required>
                </div>
                <div class="mb-3">
                    <label for="conteudo" class="form-label">Conteúdo</label>
                    <textarea class="form-control" id="conteudo" name="conteudo" rows="5" placeholder="Digite o conteúdo da notícia" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
                </div>
                <button type="submit" class="btn w-100" style="background-color: #343a40 !important; color: white;">Publicar</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
