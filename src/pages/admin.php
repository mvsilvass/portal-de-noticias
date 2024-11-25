<?php
session_start();
require_once '../config/conexao.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Consultar as notícias pendentes
$stmt = $conn->prepare("SELECT n.id, n.titulo, n.conteudo, u.nome AS escritor, n.status 
                        FROM noticias n
                        JOIN usuarios u ON n.id_escritor = u.id
                        WHERE n.status = 'pendente'");
$stmt->execute();
$result = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aprovar'])) {
        $noticia_id = $_POST['noticia_id'];
        $stmt = $conn->prepare("UPDATE noticias SET status = 'aprovada' WHERE id = ?");
        $stmt->bind_param("i", $noticia_id);
        $stmt->execute();
    } elseif (isset($_POST['rejeitar'])) {
        $noticia_id = $_POST['noticia_id'];
        $stmt = $conn->prepare("UPDATE noticias SET status = 'rejeitada' WHERE id = ?");
        $stmt->bind_param("i", $noticia_id);
        $stmt->execute();
    }
    // Redirecionar após aprovação ou rejeição
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center text-secondary mb-4">Painel de Administração</h2>
    <a href="../index.php" class="btn btn-dark mb-3">Sair</a>

    <h4>Notícias Pendentes</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Conteúdo</th>
                    <th>Escritor</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($noticia = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($noticia['titulo']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars(substr($noticia['conteudo'], 0, 100)) . '...'); ?></td>
                        <td><?php echo htmlspecialchars($noticia['escritor']); ?></td>
                        <td><?php echo ucfirst($noticia['status']); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="noticia_id" value="<?php echo $noticia['id']; ?>">
                                <button type="submit" name="aprovar" class="btn btn-success">Aprovar</button>
                            </form>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="noticia_id" value="<?php echo $noticia['id']; ?>">
                                <button type="submit" name="rejeitar" class="btn btn-danger">Rejeitar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
