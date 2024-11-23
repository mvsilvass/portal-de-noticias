<?php
session_start();

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../config/conexao.php';

// Verifica se o ID da notícia foi passado via POST
if (isset($_POST['id'])) {
    $id_noticia = $_POST['id'];

    // Atualiza o status da notícia para 'aprovada'
    $stmt = $conn->prepare("UPDATE noticias SET status = 'aprovada' WHERE id = ?");
    $stmt->bind_param("i", $id_noticia);

    if ($stmt->execute()) {
        echo "Notícia aprovada com sucesso!";
    } else {
        echo "Erro ao aprovar a notícia: " . $stmt->error;
    }
} else {
    echo "ID da notícia não fornecido!";
}

// Redireciona de volta para a página de notícias pendentes
header("Location: admin.php");
exit;
?>
