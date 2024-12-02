<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Header -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Portal de Notícias</a>
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

<div class="container mt-5">
    <h2 class="text-center text-secondary mb-4">Painel de Administração</h2>

    <div class="table-responsive">
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
        if ($stmt->execute()) {
            $result = $stmt->get_result();
        } else {
            die("Erro ao executar a consulta: " . $conn->error);
        }

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

        <?php if ($result->num_rows > 0): ?>
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
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($row['conteudo']); ?></td>
                            <td><?php echo htmlspecialchars($row['escritor']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="noticia_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="aprovar" class="btn btn-success btn-sm">Aprovar</button>
                                    <button type="submit" name="rejeitar" class="btn btn-danger btn-sm">Rejeitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">
                Nenhuma notícia pendente.
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
