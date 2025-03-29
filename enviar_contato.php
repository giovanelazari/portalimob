<?php
include('includes/conexao.php');

$nome       = $_POST['nome'];
$telefone   = $_POST['telefone'];
$mensagem   = $_POST['mensagem'];
$origem     = $_POST['origem'];
$imovel_id  = $_POST['imovel_id'];

$sql = "INSERT INTO leads (nome, telefone, mensagem, origem, imovel_id)
        VALUES ('$nome', '$telefone', '$mensagem', '$origem', $imovel_id)";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Mensagem enviada com sucesso!'); window.location.href = 'imovel.php?id=$imovel_id';</script>";
} else {
    echo "Erro ao enviar: " . $conn->error;
}
?>
