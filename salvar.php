<?php
$arquivo = 'emails.txt';

if (!isset($_POST['email']) || !isset($_POST['senha'])) {
    echo 'Dados inválidos';
    exit;
}

$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

if ($email === '' || $senha === '') {
    echo 'Preencha os dois campos';
    exit;
}

// Verifica se o email já está cadastrado
$linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($linhas as $linha) {
    $partes = explode(';', $linha);
    if (trim($partes[0]) === $email) {
        echo 'Este e-mail já está cadastrado';
        exit;
    }
}

// Adiciona o novo cadastro
file_put_contents($arquivo, "$email; $senha\n", FILE_APPEND);
echo 'Cadastro realizado com sucesso!';
