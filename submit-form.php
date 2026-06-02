<?php
require 'config.php';

// Captura
$tipo = $_POST['tipo'] ?? 'geral';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$whatsapp = $_POST['whatsapp'] ?? '';
$mensagem = $_POST['mensagem'] ?? '';

// Validação mínima
if (!$nome || !$email) {
    die("Dados obrigatórios faltando");
}

// Salvar no banco
$stmt = $conn->prepare("
    INSERT INTO formularios 
    (tipo, nome, email, telefone, whatsapp, mensagem) 
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssss", $tipo, $nome, $email, $telefone, $whatsapp, $mensagem);
$stmt->execute();

// 📧 EMAIL INTERNO (cliente)
$assunto = "[FORM - $tipo] Novo envio";

$conteudo = "
Tipo: $tipo
Nome: $nome
Email: $email
Telefone: $telefone
Whatsapp: $whatsapp
Mensagem: $mensagem
";

$destinatarios = "agnaldo.alves@grupoaal.com.br, contato@grupoaal.com.br";

$headers = "From: noreply@grupoaal.com.br\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail($destinatarios, $assunto, $conteudo, $headers);

// 📧 EMAIL AUTOMÁTICO
$headersAuto = "From: noreply@grupoaal.com.br\r\n";
$headersAuto .= "Content-Type: text/plain; charset=UTF-8\r\n";

mail(
    $email,
    "Recebemos sua solicitação",
    "Olá $nome, recebemos sua mensagem e retornaremos em breve.",
    $headersAuto
);

// Redirecionamento
header("Location: /obrigado.html");
exit;
