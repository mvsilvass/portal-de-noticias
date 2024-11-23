<?php
session_start();

// Verifica se o usuário está logado e se é um escritor
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'escritor') {
    header("Location: login.php");
    exit;
}

require_once '../config/conexao.php';

// Obtém as categorias do banco de dados
$stmtCategorias = $conn->prepare("SELECT id, nome FROM categorias");
$stmtCategorias->execute();
$resultCategorias = $stmtCategorias->get_result();
$categorias = $resultCategorias->fetch_all(MYSQLI_ASSOC);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $id_categoria = $_POST['categoria'];
    $id_escritor = $_SESSION['usuario_id']; // ID do escritor
    $imagemPath = null;

    // Verifica se há um arquivo de imagem enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagemNome = uniqid() . "_" . basename($_FILES['imagem']['name']);
        $imagemPath = "../uploads/" . $imagemNome;

        // Move o arquivo para a pasta de uploads
        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemPath)) {
            $mensagem = "Erro ao fazer o upload da imagem.";
            $tipoMensagem = "danger";
        }
    }

    // Insere a notícia no banco de dados
    $stmt = $conn->prepare("INSERT INTO noticias (titulo, conteudo, imagem, id_escritor, id_categoria, status) VALUES (?, ?, ?, ?, ?, 'pendente')");
    $stmt->bind_param("sssii", $titulo, $conteudo, $imagemPath, $id_escritor, $id_categoria);

    if ($stmt->execute()) {
        $mensagem = "Notícia enviada para aprovação!";
        $tipoMensagem = "success";
    } else {
        $mensagem = "Erro ao enviar a notícia: " . $stmt->error;
        $tipoMensagem = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escrever Notícia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Escrever Notícia</h1>
        
        <!-- Mensagem de Feedback -->
        <?php if (isset($mensagem)): ?>
            <div class="alert alert-<?= $tipoMensagem ?>" role="alert">
                <?= $mensagem ?>
            </div>
        <?php endif; ?>

        <!-- Formulário -->
        <form method="POST" enctype="multipart/form-data" class="card p-4">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título da Notícia</label>
                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o título" required>
            </div>
            <div class="mb-3">
                <label for="conteudo" class="form-label">Conteúdo</label>
                <textarea class="form-control" id="conteudo" name="conteudo" rows="6" placeholder="Digite o conteúdo" required></textarea>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="" selected disabled>Selecione uma categoria</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem da Notícia (opcional)</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Enviar Notícia</button>
        </form>

        <!-- Link para Logout -->
        <div class="mt-4">
            <a href="logout.php" class="btn btn-secondary">Sair</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
