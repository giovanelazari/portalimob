<?php
include('proteger.php');
include('../includes/conexao.php');

// Dados do formulário
$titulo     = $_POST['titulo'];
$descricao  = $_POST['descricao'];
$tipo       = $_POST['tipo'];
$bairro     = $_POST['bairro'];
$preco      = $_POST['preco'];

$sql = "INSERT INTO imoveis (titulo, descricao, tipo, bairro, preco)
        VALUES ('$titulo', '$descricao', '$tipo', '$bairro', '$preco')";

if ($conn->query($sql) === TRUE) {
    $imovel_id = $conn->insert_id;

    // Verificação das imagens
    echo "<h2>Processando imagens...</h2>";
    if (isset($_FILES['imagens'])) {
        $total = count($_FILES['imagens']['name']);
        echo "Total de arquivos recebidos: $total<br>";

        for ($i = 0; $i < $total; $i++) {
            $erro    = $_FILES['imagens']['error'][$i];
            $nome    = $_FILES['imagens']['name'][$i];
            $tmp     = $_FILES['imagens']['tmp_name'][$i];
            $tamanho = $_FILES['imagens']['size'][$i];

            echo "Arquivo $i: $nome | Erro: $erro | Tamanho: $tamanho bytes<br>";

            if ($erro === 0 && $tamanho <= 3.5 * 1024 * 1024) {
                $extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
                $permitidos = ['jpg', 'jpeg', 'png'];

                if (in_array($extensao, $permitidos)) {
                    $nomeFinal = uniqid() . '.' . $extensao;
                    $destino = '../uploads/' . $nomeFinal;

                    if (move_uploaded_file($tmp, $destino)) {
                        $conn->query("INSERT INTO imagens_imovel (imovel_id, nome_imagem)
                                      VALUES ($imovel_id, '$nomeFinal')");
                        echo "✔️ Imagem salva como: $nomeFinal<br>";
                    } else {
                        echo "❌ Falha ao mover: $nome<br>";
                    }
                } else {
                    echo "❌ Extensão não permitida: $extensao<br>";
                }
            } else {
                echo "❌ Arquivo inválido ou muito grande: $nome<br>";
            }
        }
    }

    echo "<br><a href='index.php'>Voltar ao painel</a>";

} else {
    echo "Erro ao cadastrar imóvel: " . $conn->error;
}
?>
