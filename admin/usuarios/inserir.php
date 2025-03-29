<?php
include('../proteger.php');
include('../../includes/conexao.php');

// Captura os dados do formulário
$nome   = trim($_POST['nome']);
$email  = trim($_POST['email']);
$senha  = password_hash($_POST['senha'], PASSWORD_DEFAULT);
$nivel  = $_POST['nivel']; // admin ou corretor

// Verifica se o nível está válido
if (!in_array($nivel, ['admin', 'corretor'])) {
  die("Nível de acesso inválido.");
}

// Monta e executa a query
$sql = "INSERT INTO usuarios (nome, email, senha, nivel) 
        VALUES ('$nome', '$email', '$senha', '$nivel')";

if ($conn->query($sql) === TRUE) {
  header('Location: index.php');
  exit;
} else {
  echo "Erro ao cadastrar: " . $conn->error;
}
?>
