<?php
include('proteger.php');
include('../includes/conexao.php');

// Verifica se é admin
if ($_SESSION['usuario_nivel'] !== 'admin') {
  echo "Acesso restrito.";
  exit;
}

// Busca os registros de log
$logs = $conn->query("SELECT * FROM log_exclusoes ORDER BY data_exclusao DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logs de Exclusão</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 800px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
    }
    th {
      background: #f2f2f2;
    }
  </style>
</head>
<body>
  <?php include('menu.php'); ?>

  <h1>📄 Logs de Exclusão de Imóveis</h1>
  <a href="index.php">← Voltar ao painel</a>
  <hr>

  <?php if ($logs->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Usuário</th>
          <th>Imóvel</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($log = $logs->fetch_assoc()): ?>
          <tr>
            <td><?= date('d/m/Y H:i', strtotime($log['data_exclusao'])) ?></td>
            <td><?= $log['usuario_nome'] ?> (ID <?= $log['usuario_id'] ?>)</td>
            <td><?= $log['imovel_titulo'] ?> (ID <?= $log['imovel_id'] ?>)</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Nenhuma exclusão registrada até o momento.</p>
  <?php endif; ?>
</body>
</html>
