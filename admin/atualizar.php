<?php
include('proteger.php');
include('../includes/conexao.php');


$id         = $_POST['id'];
$titulo     = $_POST['titulo'];
$descricao  = $_POST['descricao'];
$tipo       = $_POST['tipo'];
$bairro     = $_POST['bairro'];
$preco      = $_POST['preco'];

$sql = "UPDATE imoveis 
        SET titulo='$titulo', descricao='$descricao', tipo='$tipo', bairro='$bairro', preco='$preco' 
        WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao atualizar: " . $conn->error;
}
?>
