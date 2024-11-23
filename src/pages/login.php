<?php
session_start();
require_once '../config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica as credenciais no banco de dados
    $stmt = $conn->prepare("SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            // Salva os dados na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo'] = $usuario['tipo'];

            // Redireciona para a página correta
            if ($usuario['tipo'] === 'admin') {
                header("Location: ../pages/admin.php");
            } elseif ($usuario['tipo'] === 'escritor') {
                header("Location: ../pages/escrever.php");
            }
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>

<!-- Formulário de Login -->
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Login</button>
</form>

<p>Não tem uma conta? <a href="../pages/cadastrar.php">Cadastre-se aqui</a></p>
