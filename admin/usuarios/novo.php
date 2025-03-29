<?php
include('../proteger.php');
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Novo Usuário</title>
</head>
<body>
  <h1>Cadastrar Novo Usuário</h1>
  <?php include('../menu.php'); ?>

  <form method="POST">
  <label>Nome:<br>
    <input type="text" name="nome" required>
  </label><br><br>

  <label>Email:<br>
    <input type="email" name="email" required>
  </label><br><br>

  <label>Senha:<br>
    <input type="password" name="senha" required>
  </label><br><br>

  <label>Nível de acesso:<br>
  <select name="nivel" required>
    <option value="">Selecione...</option>
    <option value="admin">Administrador</option>
    <option value="corretor">Corretor</option>
  </select>
</label><br><br>


  <button type="submit">Cadastrar</button>
</form>

</body>
</html>
