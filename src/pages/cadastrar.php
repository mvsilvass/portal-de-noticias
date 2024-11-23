<?php
require_once '../config/conexao.php'; // Conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar usuário: " . $stmt->error;
    }
}
?>
<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <select name="tipo">
        <option value="escritor">Escritor</option>
        <option value="admin">Admin</option>
    </select>
    <button type="submit">Cadastrar</button>
</form>

<p>Já tem uma conta? <a href="../pages/login.php">Faça seu login aqui</a></p>
