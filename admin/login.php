<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include('../includes/conexao.php');

$erro = '';

// Lógica de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $senha = $_POST['senha'] ?? '';

  $sql = "SELECT * FROM usuarios WHERE email = '$email' LIMIT 1";
  $res = $conn->query($sql);

  if ($res && $res->num_rows > 0) {
    $usuario = $res->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
      if (!empty($usuario['nivel']) && in_array($usuario['nivel'], ['admin', 'corretor'])) {
        $_SESSION['usuario_id']    = $usuario['id'];
        $_SESSION['usuario_nome']  = $usuario['nome'];
        $_SESSION['usuario_nivel'] = $usuario['nivel'];

        header("Location: index.php");
        exit;
      } else {
        $erro = "Usuário sem nível de acesso.";
      }
    } else {
      $erro = "Senha incorreta!";
    }
  } else {
    $erro = "Usuário não encontrado!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <h1>Login do sistema</h1>

  <?php if (!empty($erro)): ?>
    <p style="color: red;"><?= $erro ?></p>
  <?php endif; ?>

  <form method="POST" style="max-width: 300px;">
    <label>Email:<br>
      <input type="email" name="email" required>
    </label><br><br>

    <label>Senha:<br>
      <input type="password" name="senha" required>
    </label><br><br>

    <button type="submit">Entrar</button>
  </form>
</body>
</html>
