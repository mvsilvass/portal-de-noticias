<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Negado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card{
            padding: 10px;
        }
        p {
            font-size: 2rem;
            font-weight: bold;
        }
        .btn {
            background-color: #343a40;
            border: none;
            font-size: 1.2rem;
            color: white;
        }
        .btn:hover{
            background-color: #43494e;
            color: white;
        }
        .btn:focus, .btn:active {
            box-shadow: none;
            outline: none;
            background-color: #343a40;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card" style="width: 50rem;">
        <div class="card-body text-center">
            <p class="card-text mb-4">Você não tem permissão para acessar esta página. Por favor, faça login para continuar.</p>
            <a href="login.php" class="btn">Ir para o Login</a>
        </div>
    </div>
</body>
</html>
