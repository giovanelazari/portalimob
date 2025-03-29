<?php
include('includes/conexao.php');

// Verifica se o ID foi enviado
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "Imóvel não encontrado.";
  exit;
}

$id = intval($_GET['id']);

// Consulta com JOIN para buscar o nome do corretor
$sql = "SELECT imoveis.*, usuarios.nome AS nome_corretor 
        FROM imoveis 
        LEFT JOIN usuarios ON imoveis.corretor_id = usuarios.id 
        WHERE imoveis.id = $id";

$imovel = $conn->query($sql)->fetch_assoc();

if (!$imovel) {
  echo "Imóvel não encontrado.";
  exit;
}

// Busca todas as imagens do imóvel
$imagens = $conn->query("SELECT nome_imagem FROM imagens_imovel WHERE imovel_id = $id");

// Busca configurações (número e ativação do WhatsApp)
$config = $conn->query("SELECT * FROM configuracoes WHERE id = 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= $imovel['titulo'] ?> - Detalhes do Imóvel</title>
  <?php include('includes/tagmanager.php'); ?>

  <style>
    .whatsapp-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: #25D366;
      color: white;
      padding: 12px 20px;
      border-radius: 50px;
      font-weight: bold;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
      z-index: 999;
    }

    #whatsPopup {
      display: none;
      position: fixed;
      bottom: 90px;
      right: 20px;
      background: #fff;
      padding: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      z-index: 1000;
      width: 250px;
    }

    #whatsPopup input {
      width: 100%;
      margin-bottom: 10px;
      padding: 6px;
      box-sizing: border-box;
    }

    #whatsPopup button {
      width: 100%;
      background: #25D366;
      color: white;
      padding: 8px;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    #whatsPopup button:hover {
      background: #1ebe5d;
    }
  </style>
</head>
<body>

  <h1><?= $imovel['titulo'] ?></h1>

  <?php while($img = $imagens->fetch_assoc()): ?>
    <img src="uploads/<?= $img['nome_imagem'] ?>" width="300" style="margin-bottom: 10px;"><br>
  <?php endwhile; ?>

  <p><strong>Tipo:</strong> <?= $imovel['tipo'] ?></p>
  <p><strong>Bairro:</strong> <?= $imovel['bairro'] ?></p>
  <p><strong>Preço:</strong> R$ <?= number_format($imovel['preco'], 2, ',', '.') ?></p>
  <p><strong>Descrição:</strong><br><?= nl2br($imovel['descricao']) ?></p>

  <?php if (!empty($imovel['nome_corretor'])): ?>
    <p><strong>Responsável pela angariação:</strong> <?= $imovel['nome_corretor'] ?></p>
  <?php endif; ?>

  <p><a href="index.php">← Voltar para a lista de imóveis</a></p>

  <?php if (!empty($config['whatsapp_ativo']) && $config['whatsapp_ativo']): ?>
    <!-- POPUP -->
    <div id="whatsPopup">
      <label>Nome:<br><input type="text" id="leadNome"></label>
      <label>Telefone:<br><input type="text" id="leadFone"></label>
      <button onclick="enviarWhatsLead()">Ir para o WhatsApp</button>
    </div>

    <!-- BOTÃO FLUTUANTE -->
    <a href="#" class="whatsapp-button" onclick="document.getElementById('whatsPopup').style.display='block'; return false;">
      💬 WhatsApp
    </a>

    <!-- JS -->
    <script>
      function enviarWhatsLead() {
        const nome = document.getElementById('leadNome').value;
        const telefone = document.getElementById('leadFone').value;
        const numero = '<?= preg_replace("/\D/", "", $config['whatsapp_numero']) ?>';
        const imovelId = <?= $imovel['id'] ?>;

        // Envia o lead para o banco
        fetch(`registrar_lead_whatsapp.php?id=${imovelId}&nome=${encodeURIComponent(nome)}&telefone=${encodeURIComponent(telefone)}`);

        // Evento de conversão via GTM
        if (typeof dataLayer !== 'undefined') {
          dataLayer.push({ event: 'lead_whatsapp' });
        }

        // Abre o WhatsApp e fecha o pop-up
        const url = `https://wa.me/${numero}?text=Olá, me chamo ${encodeURIComponent(nome)} e gostaria de mais informações sobre o imóvel.`;
        window.open(url, '_blank');
        document.getElementById('whatsPopup').style.display = 'none';
      }
    </script>
  <?php endif; ?>

</body>
</html>
