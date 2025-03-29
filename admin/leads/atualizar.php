<?php
include('../../includes/conexao.php');

$id     = intval($_POST['id']);
$status = $_POST['status'];

$sql = "UPDATE leads SET status = '$status' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
    exit;
} else {
    echo "Erro ao atualizar status: " . $conn->error;
}
?>
