<?php
$host = "localhost";
$usuario = "root";
$senha = "root"; // senha padrão do MAMP
$banco = "portal_imobiliario";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
