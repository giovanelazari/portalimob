<?php
include('proteger.php');

// Define o caminho base para links (funciona mesmo com includes em subpastas)
$base = (basename(__DIR__) === 'admin') ? '' : '../';
?>

<ul>
  <li><a href="<?= $base ?>index.php">🏠 Início</a></li>

  <?php if ($_SESSION['usuario_nivel'] === 'admin'): ?>
    <li><a href="<?= $base ?>leads/index.php">📋 Leads</a></li>
    <li><a href="<?= $base ?>usuarios/index.php">👥 Usuários</a></li>
    <li><a href="<?= $base ?>integracoes.php">⚙️ Integrações</a></li>
    <li><a href="<?= $base ?>logs.php">🗂 Logs de Exclusões</a></li>
  <?php else: ?>
    <li><a href="<?= $base ?>cadastrar.php">➕ Cadastrar Imóvel</a></li>
    <li><a href="<?= $base ?>leads/index.php">📋 Meus Leads</a></li>
    <li><a href="<?= $base ?>../index.php">🏘 Imóveis</a></li>
  <?php endif; ?>

  <li><a href="<?= $base ?>logout.php">📓 Sair</a></li>
</ul>
<hr>
