<?php
include('proteger.php');
include('../includes/conexao.php');

$id = intval($_GET['id']);
$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];
$nivel = $_SESSION['usuario_nivel'];

// Valida permissão: admin pode tudo, corretor só os seus
if ($nivel === 'admin') {
  $sql = "SELECT * FROM imoveis WHERE id = $id";
} else {
  $sql = "SELECT * FROM imoveis WHERE id = $id AND corretor_id = $usuario_id";
}

$res = $conn->query($sql);
$imovel = $res->fetch_assoc();

if (!$imovel) {
  echo "Imóvel não encontrado ou acesso negado.";
  exit;
}

// Apaga imagens físicas
$imagens = $conn->query("SELECT nome_imagem FROM imagens_imovel WHERE imovel_id = $id");
while ($img = $imagens->fetch_assoc()) {
  $caminho = '../uploads/' . $img['nome_imagem'];
  if (file_exists($caminho)) {
    unlink($caminho);
  }
}

// Apaga do banco
$conn->query("DELETE FROM imagens_imovel WHERE imovel_id = $id");
$conn->query("DELETE FROM imoveis WHERE id = $id");

// Registra no log
$titulo = $conn->real_escape_string($imovel['titulo']);
$conn->query("INSERT INTO log_exclusoes (usuario_id, usuario_nome, imovel_id, imovel_titulo)
              VALUES ($usuario_id, '$usuario_nome', $id, '$titulo')");

header('Location: index.php');
exit;
?>
