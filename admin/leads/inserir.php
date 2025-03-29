<?php
include('../../includes/conexao.php');

$nome       = $_POST['nome'];
$telefone   = $_POST['telefone'];
$mensagem   = $_POST['mensagem'];
$origem     = $_POST['origem'];
$imovel_id  = $_POST['imovel_id'] ?: 'NULL'; // se vazio, grava NULL

$sql = "INSERT INTO leads (nome, telefone, mensagem, origem, imovel_id)
        VALUES ('$nome', '$telefone', '$mensagem', '$origem', $imovel_id)";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao cadastrar lead: " . $conn->error;
}
?>
