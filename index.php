<?php
include('includes/conexao.php');

// Busca configurações
$config = $conn->query("SELECT * FROM configuracoes WHERE id = 1")->fetch_assoc();

// Busca categorias distintas
$categorias = $conn->query("SELECT DISTINCT tipo FROM imoveis WHERE tipo IS NOT NULL AND tipo != '' ORDER BY tipo ASC");

// Filtro
$filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';

if ($filtro) {
  $stmt = $conn->prepare("SELECT * FROM imoveis WHERE tipo = ? ORDER BY id DESC");
  $stmt->bind_param("s", $filtro);
  $stmt->execute();
  $resultado = $stmt->get_result();
} else {
  $resultado = $conn->query("SELECT * FROM imoveis ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Portal Imobiliário</title>
  <?php include('includes/tagmanager.php'); ?>
</head>
<body>
<div style="text-align: right; padding: 10px; background: #f2f2f2;">
  <a href="admin/login.php" style="text-decoration: none; font-weight: bold;">🔐 Acesso Restrito</a>
</div>
<hr>

  <h1>Imóveis disponíveis</h1>

  <!-- Filtro por categoria -->
  <form method="GET">
    <label>Filtrar por categoria:
      <select name="categoria" onchange="this.form.submit()">
        <option value="">Todas</option>
        <?php while($cat = $categorias->fetch_assoc()): ?>
          <option value="<?= $cat['tipo'] ?>" <?= $filtro === $cat['tipo'] ? 'selected' : '' ?>><?= $cat['tipo'] ?></option>
        <?php endwhile; ?>
      </select>
    </label>
  </form>
  <br>

  <?php while($imovel = $resultado->fetch_assoc()) { ?>
    <div style="margin-bottom: 40px;">
      <h2><?= $imovel['titulo'] ?></h2>

      <?php
      $id = $imovel['id'];
      $img = $conn->query("SELECT nome_imagem FROM imagens_imovel WHERE imovel_id = $id LIMIT 1")->fetch_assoc();
      ?>
      <?php if ($img): ?>
        <img src="uploads/<?= $img['nome_imagem'] ?>" width="300"><br><br>
      <?php endif; ?>

      <p><strong>Tipo:</strong> <?= $imovel['tipo'] ?></p>
      <p><strong>Bairro:</strong> <?= $imovel['bairro'] ?></p>
      <p><strong>Preço:</strong> R$ <?= number_format($imovel['preco'], 2, ',', '.') ?></p>

      <a href="imovel.php?id=<?= $imovel['id'] ?>">Ver detalhes</a>
      <hr>
    </div>
  <?php } ?>

</body>
</html>
