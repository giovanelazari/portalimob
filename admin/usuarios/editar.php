<?php
include('../proteger.php');
include('../../includes/conexao.php');

$id = intval($_GET['id']);
$usuario = $conn->query("SELECT * FROM usuarios WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Editar Usuário</title>
</head>
<body>
  <h1>Editar Usuário</h1>
  <?php include('../menu.php'); ?>

  <form action="atualizar.php" method="POST">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

    <label>Nome:<br>
      <input type="text" name="nome" value="<?= $usuario['nome'] ?>" required>
    </label><br><br>

    <label>Email:<br>
      <input type="email" name="email" value="<?= $usuario['email'] ?>" required>
    </label><br><br>

    <label>Nova senha (deixe em branco para não alterar):<br>
      <input type="password" name="senha">
    </label><br><br>
    <label>Tipo:<br>
    
  <select name="tipo">
    <option value="admin" <?= $usuario['tipo'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
    <option value="corretor" <?= $usuario['tipo'] == 'corretor' ? 'selected' : '' ?>>Corretor</option>
  </select>
</label><br><br>


    <button type="submit">Atualizar</button>
  </form>
</body>
</html>
