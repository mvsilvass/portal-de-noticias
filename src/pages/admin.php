<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

require_once '../config/conexao.php';

// Pega as notícias pendentes
$stmt = $conn->prepare("SELECT * FROM noticias WHERE status = 'pendente'");
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Notícias Pendentes</h1>";
while ($noticia = $result->fetch_assoc()) {
    echo "<h2>{$noticia['titulo']}</h2>";
    echo "<p>{$noticia['conteudo']}</p>";
    echo "<form method='POST' action='aprovar_noticia.php'>
            <input type='hidden' name='id' value='{$noticia['id']}'>
            <button type='submit'>Aprovar</button>
          </form>";
}
?>
<a href="logout.php">Sair</a>
