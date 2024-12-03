<?php
session_start();
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $conn->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            if ($usuario['tipo'] === 'admin') {
                header("Location: ../pages/admin.php");
            } elseif ($usuario['tipo'] === 'escritor') {
                header("Location: ../pages/escrever.php");
            }
            exit;
        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Usuário não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    input.form-control:focus, select.form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(211, 211, 211, 0.5) !important;
        border-color: #d3d3d3 !important;
        outline: none !important;
    }
    .home-icon {
        position: absolute;
        top: 20px;
        left: 20px;
        font-size: 24px;
        color: #343a40;
        text-decoration: none;
    }
</style>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<a href="../../index.php" class="home-icon">
    <i class="fas fa-home"></i>
</a>

<div class="card p-4 shadow-lg" style="width: 100%; max-width: 400px;">
    <h2 class="text-center text-secondary mb-4">Login</h2>

    <?php if (isset($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>
        <button type="submit" class="btn w-100" style="background-color: #343a40 !important; color: white;">Login</button>
    </form>

    <p class="text-center mt-3 mb-0">
        Não tem uma conta? <a href="../pages/cadastrar.php">Cadastre-se aqui</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
