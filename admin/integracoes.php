<?php
include('proteger.php');
include('../includes/conexao.php');

// Salva as configurações quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $gtm      = trim($_POST['gtm_id']);
  $pixel    = trim($_POST['meta_pixel_id']);
  $ads      = trim($_POST['google_ads_id']);
  $ga       = trim($_POST['google_analytics_id']);
  $whatsapp = isset($_POST['whatsapp_ativo']) ? 1 : 0;
  $whatsapp_numero = trim($_POST['whatsapp_numero']);

  $sql = "UPDATE configuracoes SET 
            google_tagmanager_id = '$gtm',
            meta_pixel_id = '$pixel',
            google_ads_id = '$ads',
            google_analytics_id = '$ga',
            whatsapp_ativo = $whatsapp,
            whatsapp_numero = '$whatsapp_numero'
          WHERE id = 1";

  $conn->query($sql);
  header("Location: integracoes.php?salvo=1");
  exit;
}

// Recupera os dados atuais salvos
$config = $conn->query("SELECT * FROM configuracoes WHERE id = 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Integrações</title>
</head>
<body>
  <h1>Integrações</h1>
  <?php include('menu.php'); ?>

  <?php if (isset($_GET['salvo'])): ?>
    <p style="color: green;">Configurações salvas com sucesso!</p>
  <?php endif; ?>

  <form method="POST">
    <label>Google Tag Manager (GTM ID):<br>
      <input type="text" name="gtm_id" value="<?= $config['google_tagmanager_id'] ?>" placeholder="GTM-XXXXXXX">
    </label><br><br>

    <label>Meta Pixel ID:<br>
      <input type="text" name="meta_pixel_id" value="<?= $config['meta_pixel_id'] ?>" placeholder="1234567890">
    </label><br><br>

    <label>Google Ads Conversion ID:<br>
      <input type="text" name="google_ads_id" value="<?= $config['google_ads_id'] ?>" placeholder="AW-XXXXXXX">
    </label><br><br>

    <label>Google Analytics (GA4 Measurement ID):<br>
      <input type="text" name="google_analytics_id" value="<?= $config['google_analytics_id'] ?>" placeholder="G-XXXXXXX">
    </label><br><br>

    <label>
      <input type="checkbox" name="whatsapp_ativo" value="1" <?= $config['whatsapp_ativo'] ? 'checked' : '' ?>>
      Ativar botão de WhatsApp nos imóveis
    </label><br><br>

    <label>Número do WhatsApp (com DDD, somente números):<br>
      <input type="text" name="whatsapp_numero" value="<?= $config['whatsapp_numero'] ?>" placeholder="5599999999999">
    </label><br><br>

    <button type="submit">Salvar</button>
  </form>
</body>
</html>
