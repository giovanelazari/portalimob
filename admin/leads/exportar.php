<?php
include('../../includes/conexao.php');

// Recebe os filtros
$status = $_GET['status'] ?? '';
$origem = $_GET['origem'] ?? '';
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

$filtros = [];

if ($status !== '') {
  $filtros[] = "leads.status = '$status'";
}
if ($origem !== '') {
  $filtros[] = "leads.origem = '$origem'";
}
if ($data_inicio !== '') {
  $filtros[] = "leads.data_contato >= '$data_inicio 00:00:00'";
}
if ($data_fim !== '') {
  $filtros[] = "leads.data_contato <= '$data_fim 23:59:59'";
}

$where = count($filtros) > 0 ? 'WHERE ' . implode(' AND ', $filtros) : '';

$sql = "SELECT leads.*, imoveis.titulo AS titulo_imovel 
        FROM leads 
        LEFT JOIN imoveis ON leads.imovel_id = imoveis.id 
        $where
        ORDER BY data_contato DESC";

$result = $conn->query($sql);

// Cabeçalhos para download do CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=leads.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Nome', 'Telefone', 'Origem', 'Status', 'Mensagem', 'Imóvel', 'Data de Contato']);

while ($row = $result->fetch_assoc()) {
  fputcsv($output, [
    $row['nome'],
    $row['telefone'],
    $row['origem'],
    $row['status'],
    $row['mensagem'],
    $row['titulo_imovel'],
    $row['data_contato']
  ]);
}
fclose($output);
exit;
