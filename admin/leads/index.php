<?php
include('../../includes/conexao.php');
include('../proteger.php');

$usuario_id = $_SESSION['usuario_id'];
$nivel = $_SESSION['usuario_nivel'];

// Admin vê todos os leads
if ($nivel === 'admin') {
  $leads = $conn->query("SELECT leads.*, imoveis.titulo AS titulo_imovel 
                         FROM leads 
                         LEFT JOIN imoveis ON leads.imovel_id = imoveis.id 
                         ORDER BY data_contato DESC");
} else {
  // Corretor vê apenas seus leads
  $leads = $conn->query("SELECT leads.*, imoveis.titulo AS titulo_imovel 
                         FROM leads 
                         LEFT JOIN imoveis ON leads.imovel_id = imoveis.id 
                         WHERE leads.corretor_id = $usuario_id
                         ORDER BY data_contato DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Leads - CRM</title>
</head>
<body>
  <?php include('../menu.php'); ?>

  <h1><?= $nivel === 'admin' ? 'Todos os Leads' : 'Meus Leads' ?></h1>

  <!-- Botão de voltar para o painel -->
  <a href="../index.php" style="display: inline-block; margin-bottom: 15px; color: purple; text-decoration: none;">← Voltar</a>
  <hr>

  <?php if ($leads->num_rows === 0): ?>
    <p>Nenhum lead encontrado.</p>
  <?php else: ?>
    <?php while($lead = $leads->fetch_assoc()) { ?>
      <div style="margin-bottom: 20px;">
        <strong><?= $lead['nome'] ?></strong> - <?= $lead['telefone'] ?><br>
        Interesse: <?= $lead['titulo_imovel'] ?><br>
        Status: <strong><?= ucfirst($lead['status']) ?></strong><br>
        Origem: <?= $lead['origem'] ?><br>
        <small><?= date('d/m/Y H:i', strtotime($lead['data_contato'])) ?></small><br>

        <!-- Se for admin, mostrar corretor responsável -->
        <?php if ($nivel === 'admin' && $lead['corretor_id']): ?>
          <?php
            $corretor = $conn->query("SELECT nome FROM usuarios WHERE id = {$lead['corretor_id']}")->fetch_assoc();
          ?>
          <small><strong>Corretor:</strong> <?= $corretor['nome'] ?? '---' ?></small><br>
        <?php endif; ?>

        <a href="visualizar.php?id=<?= $lead['id'] ?>">Ver detalhes</a>
      </div>
      <hr>
    <?php } ?>
  <?php endif; ?>
</body>
</html>
