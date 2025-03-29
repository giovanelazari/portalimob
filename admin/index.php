<?php
include('proteger.php');
include('../includes/conexao.php');

// Se for corretor, busca só os imóveis dele
if ($_SESSION['usuario_nivel'] === 'corretor') {
  $usuario_id = $_SESSION['usuario_id'];
  $resultado = $conn->query("SELECT * FROM imoveis WHERE corretor_id = $usuario_id ORDER BY id DESC");
} else {
  // Admin vê todos os imóveis
  $resultado = $conn->query("SELECT * FROM imoveis ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Painel - <?= ucfirst($_SESSION['usuario_nivel']) ?></title>
</head>
<body>
  <?php include('menu.php'); ?>

  <h1>Painel de <?= ucfirst($_SESSION['usuario_nivel']) ?></h1>
  <p>Bem-vindo, <?= $_SESSION['usuario_nome'] ?>!</p>

  <a href="cadastrar.php">+ Novo Imóvel</a>
  <hr>

  <?php while($imovel = $resultado->fetch_assoc()) { ?>
    <div style="margin-bottom: 20px;">
      <strong><?= $imovel['titulo'] ?></strong><br>
      <?= $imovel['bairro'] ?> | <?= $imovel['tipo'] ?> |
      R$ <?= number_format($imovel['preco'], 2, ',', '.') ?><br>

      <?php
        // Buscar a primeira imagem
        $id = $imovel['id'];
        $img = $conn->query("SELECT nome_imagem FROM imagens_imovel WHERE imovel_id = $id LIMIT 1")->fetch_assoc();
      ?>

      <?php if ($img): ?>
        <img src="../uploads/<?= $img['nome_imagem'] ?>" width="200"><br>
      <?php endif; ?>

      <!-- Mostrar corretor responsável (apenas se for admin) -->
      <?php if ($_SESSION['usuario_nivel'] === 'admin' && $imovel['corretor_id']): ?>
        <?php
          $corretor_id = $imovel['corretor_id'];
          $corretor = $conn->query("SELECT nome FROM usuarios WHERE id = $corretor_id")->fetch_assoc();
        ?>
        <small><strong>Responsável:</strong> <?= $corretor['nome'] ?? '---' ?></small><br>
      <?php endif; ?>

      <!-- Links de ação -->
      <a href="editar.php?id=<?= $imovel['id'] ?>">Editar</a> |
      <a href="excluir.php?id=<?= $imovel['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este imóvel?')">Excluir</a>
    </div>
    <hr>
  <?php } ?>
</body>
</html>
