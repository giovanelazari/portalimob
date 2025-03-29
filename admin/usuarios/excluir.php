<?php
include('../proteger.php');
include('../../includes/conexao.php');

$id = intval($_GET['id']);

$conn->query("DELETE FROM usuarios WHERE id = $id");

header('Location: index.php');
exit;
?>
