<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Novo Lead Manual</title>
</head>
<body>
  <h1>Cadastrar Novo Lead</h1>

  <form action="inserir.php" method="POST">
    <label>Nome:<br><input type="text" name="nome" required></label><br><br>
    <label>Telefone:<br><input type="text" name="telefone" required></label><br><br>
    <label>Origem:<br>
      <select name="origem" required>
        <option value="WhatsApp">WhatsApp</option>
        <option value="Instagram">Instagram</option>
        <option value="Facebook">Facebook</option>
        <option value="Google">Google</option>
        <option value="Indicação">Indicação</option>
        <option value="Outro">Outro</option>
      </select>
    </label><br><br>
    <label>Mensagem:<br><textarea name="mensagem" rows="5"></textarea></label><br><br>
    <label>Imóvel ID (opcional):<br><input type="number" name="imovel_id"></label><br><br>

    <button type="submit">Cadastrar Lead</button>
  </form>

  <p><a href="index.php">← Voltar para a lista</a></p>
</body>
</html>
