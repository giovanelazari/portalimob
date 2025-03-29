<?php
include('../../includes/conexao.php');

$id = intval($_GET['id']);
$lead = $conn->query("SELECT leads.*, imoveis.titulo AS titulo_imovel 
                      FROM leads 
                      LEFT JOIN imoveis ON leads.imovel_id = imoveis.id 
                      WHERE leads.id = $id")->fetch_assoc();

// Buscar anotações
$anotacoes = $conn->query("SELECT * FROM anotacoes_lead WHERE lead_id = $id ORDER BY data DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lead - <?= $lead['nome'] ?></title>
</head>
<body>
  <h1>Detalhes do Lead</h1>
  <?php include('../menu.php'); ?>

  <p><strong>Nome:</strong> <?= $lead['nome'] ?></p>
  <p><strong>Telefone:</strong> <?= $lead['telefone'] ?></p>
  <p><strong>Origem:</strong> <?= $lead['origem'] ?></p>
  <p><strong>Mensagem:</strong><br><?= nl2br($lead['mensagem']) ?></p>
  <p><strong>Imóvel de interesse:</strong> <?= $lead['titulo_imovel'] ?></p>
  <p><strong>Data de contato:</strong> <?= $lead['data_contato'] ?></p>

  <form action="atualizar.php" method="POST">
    <input type="hidden" name="id" value="<?= $lead['id'] ?>">
    <label>Status:
      <select name="status">
        <option value="novo" <?= $lead['status'] == 'novo' ? 'selected' : '' ?>>Novo</option>
        <option value="em contato" <?= $lead['status'] == 'em contato' ? 'selected' : '' ?>>Em contato</option>
        <option value="fechado" <?= $lead['status'] == 'fechado' ? 'selected' : '' ?>>Fechado</option>
      </select>
    </label>
    <button type="submit">Atualizar</button>
  </form>

  <hr>

  <h2>Anotações</h2>

  <form action="salvar_anotacao.php" method="POST">
    <input type="hidden" name="lead_id" value="<?= $lead['id'] ?>">
    <textarea name="texto" rows="4" cols="50" placeholder="Escreva uma nova anotação..." required></textarea><br><br>
    <button type="submit">Salvar anotação</button>
  </form>

  <br>
  <?php while($a = $anotacoes->fetch_assoc()) { ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
      <small><?= date('d/m/Y H:i', strtotime($a['data'])) ?></small><br>
      <?= nl2br($a['texto']) ?>
    </div>
  <?php } ?>

  <p><a href="index.php">← Voltar para lista de leads</a></p>
</body>
</html>
