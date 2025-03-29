<?php
include('../proteger.php');
include('../../includes/conexao.php');

$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY nome");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Usuários</title>
</head>
<body>
  <h1>Usuários do Sistema</h1>
  <?php include('../menu.php'); ?>

  <a href="novo.php">+ Novo Usuário</a>
  <hr>

  <?php while ($user = $usuarios->fetch_assoc()) { ?>
    <div>
      <strong><?= $user['nome'] ?></strong><br>
      <?= $user['email'] ?><br>
      <a href="editar.php?id=<?= $user['id'] ?>">Editar</a> 
      <a href="excluir.php?id=<?= $user['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
    </div>
    <hr>
  <?php } ?>
</body>
</html>
