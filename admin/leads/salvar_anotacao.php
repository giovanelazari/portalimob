<?php
include('../../includes/conexao.php');

$lead_id = intval($_POST['lead_id']);
$texto = trim($_POST['texto']);

if ($texto != '') {
  $sql = "INSERT INTO anotacoes_lead (lead_id, texto) VALUES ($lead_id, '$texto')";
  $conn->query($sql);
}

header("Location: visualizar.php?id=$lead_id");
exit;
