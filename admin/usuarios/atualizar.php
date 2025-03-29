<?php
include('../proteger.php');
include('../../includes/conexao.php');

$id    = intval($_POST['id']);
$nome  = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = $_POST['senha'];

if (!empty($senha)) {
  $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
  $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha_hash' WHERE id=$id";
} else {
  $sql = "UPDATE usuarios SET nome='$nome', email='$email' WHERE id=$id";
}

$tipo = $_POST['tipo'];

if (!empty($senha)) {
  $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
  $sql = "UPDATE usuarios SET nome='$nome', email='$email', senha='$senha_hash', tipo='$tipo' WHERE id=$id";
} else {
  $sql = "UPDATE usuarios SET nome='$nome', email='$email', tipo='$tipo' WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
  header('Location: index.php');
  exit;
} else {
  echo "Erro ao atualizar: " . $conn->error;
}
?>
