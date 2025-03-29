<?php
include('proteger.php');
include('../includes/conexao.php');

// Total de leads
$total = $conn->query("SELECT COUNT(*) AS total FROM leads")->fetch_assoc()['total'];

// Leads por status
$status_novo = $conn->query("SELECT COUNT(*) AS total FROM leads WHERE status = 'novo'")->fetch_assoc()['total'];
$status_em_contato = $conn->query("SELECT COUNT(*) AS total FROM leads WHERE status = 'em contato'")->fetch_assoc()['total'];
$status_fechado = $conn->query("SELECT COUNT(*) AS total FROM leads WHERE status = 'fechado'")->fetch_assoc()['total'];

// Leads por origem
$origens = $conn->query("SELECT origem, COUNT(*) AS total FROM leads GROUP BY origem");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>
  <h1>Dashboard de Leads</h1>
  <?php include('menu.php'); ?>

  <a href="index.php">← Voltar ao painel</a>
  <hr>

  <h2>📊 Resumo Geral</h2>
  <p><strong>Total de leads:</strong> <?= $total ?></p>

  <h2>✅ Leads por Status</h2>
  <ul>
    <li>Novo: <?= $status_novo ?></li>
    <li>Em contato: <?= $status_em_contato ?></li>
    <li>Fechado: <?= $status_fechado ?></li>
  </ul>

  <h2>📲 Leads por Origem</h2>
  <ul>
    <?php while($o = $origens->fetch_assoc()) { ?>
      <li><?= $o['origem'] ?>: <?= $o['total'] ?></li>
    <?php } ?>
  </ul>
</body>
</html>
