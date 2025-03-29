<?php
include('includes/conexao.php');

// Captura os dados
$imovel_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$nome = $_GET['nome'] ?? 'Lead WhatsApp';
$telefone = $_GET['telefone'] ?? '';

// Sanitiza os dados
$nome = $conn->real_escape_string($nome);
$telefone = $conn->real_escape_string($telefone);

// Busca o próximo corretor da fila
$buscaCorretor = $conn->query("SELECT id FROM usuarios WHERE nivel = 'corretor' ORDER BY ultima_distribuicao ASC LIMIT 1");

if ($buscaCorretor->num_rows > 0) {
  $corretor = $buscaCorretor->fetch_assoc();
  $corretor_id = $corretor['id'];

  // Insere o lead
  $conn->query("INSERT INTO leads (nome, telefone, mensagem, origem, imovel_id, status, data_contato, corretor_id)
                VALUES ('$nome', '$telefone', 'Contato via botão de WhatsApp', 'WhatsApp', $imovel_id, 'novo', NOW(), $corretor_id)");

  // Atualiza a data da última distribuição do corretor
  $conn->query("UPDATE usuarios SET ultima_distribuicao = NOW() WHERE id = $corretor_id");
}

// Retorna resposta OK
http_response_code(200);
?>
