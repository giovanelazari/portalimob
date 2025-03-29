<?php
include('proteger.php');
include('../includes/conexao.php');

// Pega o ID do imóvel da URL
$id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario_id'];

// Admin pode editar qualquer imóvel; corretor só os próprios
if ($_SESSION['usuario_nivel'] === 'admin') {
  $sql = "SELECT * FROM imoveis WHERE id = $id";
} else {
  $sql = "SELECT * FROM imoveis WHERE id = $id AND corretor_id = $usuario_id";
}

$res = $conn->query($sql);
$imovel = $res->fetch_assoc();

// Impede o acesso se não encontrar ou não tiver permissão
if (!$imovel) {
  echo "Imóvel não encontrado ou acesso negado.";
  exit;
}
?>
