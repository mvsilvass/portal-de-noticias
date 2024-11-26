<?php
require_once '../config/conexao.php'; // Conexão ao banco de dados

// Variável para mensagens de sucesso ou erro
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $tipo = $_POST['tipo'];

    // Usando try-catch para capturar exceções
    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senha, $tipo);

        // Tenta executar a query
        if ($stmt->execute()) {
            // Mensagem de sucesso
            $message = "<div class='alert alert-success' role='alert'>Usuário cadastrado com sucesso!</div>";
        } else {
            // Mensagem de erro genérica, se houver outro erro
            $message = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar usuário: " . $stmt->error . "</div>";
        }
    } catch (mysqli_sql_exception $e) {
        // Captura o erro de duplicidade e mostra uma mensagem personalizada
        if ($e->getCode() === 1062) {  // Código de erro de chave duplicada
            $message = "<div class='alert alert-danger' role='alert'>Este e-mail já está cadastrado!</div>";
        } else {
            // Mensagem para outros erros
            $message = "<div class='alert alert-danger' role='alert'>Erro ao cadastrar usuário: " . $e->getMessage() . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../src/styles/styles.css">
</head>
<style>
    input.form-control:focus, select.form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(211, 211, 211, 0.5) !important;
        border-color: #d3d3d3 !important;
        outline: none !important;
    }
</style>
<body class="bg-light" style="min-height: 100vh; display: flex; justify-content: center; align-items: center;">
    <main class="container py-5">
        <div class="col-md-6 mx-auto">
            <!-- Exibe a mensagem de sucesso ou erro -->
            <?php echo $message; ?>

            <form method="POST" class="bg-white p-4 border rounded shadow">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Senha" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Usuário</label>
                    <select name="tipo" id="tipo" class="form-select">
                        <option value="escritor">Escritor</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #343a40 !important; color: white;">Cadastrar</button>
            </form>
            <p class="mt-3 text-center">Já tem uma conta? <a href="../pages/login.php">Faça seu login aqui</a></p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
