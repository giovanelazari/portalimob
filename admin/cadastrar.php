<?php
include('proteger.php');
include('../includes/conexao.php');

// Captura o ID do corretor logado (pode ser admin ou corretor)
$corretor_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Coleta e limpa os dados do formulário
  $titulo     = trim($_POST['titulo']);
  $descricao  = trim($_POST['descricao']);
  $tipo       = trim($_POST['tipo']);
  $bairro     = trim($_POST['bairro']);
  $preco      = floatval(str_replace(',', '.', str_replace('.', '', $_POST['preco'])));

  // Insere o imóvel com vínculo ao corretor
  $sql = "INSERT INTO imoveis (titulo, descricao, tipo, bairro, preco, corretor_id) 
          VALUES ('$titulo', '$descricao', '$tipo', '$bairro', $preco, $corretor_id)";

  if ($conn->query($sql) === TRUE) {
    $imovel_id = $conn->insert_id;

    // Se houver imagens enviadas
    if (!empty($_FILES['imagens']['name'][0])) {
      $total = count($_FILES['imagens']['name']);
      for ($i = 0; $i < $total; $i++) {
        // Valida tamanho da imagem (máximo 3.5MB)
        if ($_FILES['imagens']['error'][$i] === 0 && $_FILES['imagens']['size'][$i] <= 3.5 * 1024 * 1024) {
          $nome = uniqid() . '_' . basename($_FILES['imagens']['name'][$i]);
          $caminho = '../uploads/' . $nome;

          if (move_uploaded_file($_FILES['imagens']['tmp_name'][$i], $caminho)) {
            $conn->query("INSERT INTO imagens_imovel (imovel_id, nome_imagem) VALUES ($imovel_id, '$nome')");
          }
        }
      }
    }

    header('Location: index.php');
    exit;
  } else {
    echo "Erro ao cadastrar imóvel: " . $conn->error;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Novo Imóvel</title>
  <style>
    .preview-container {
      display: inline-block;
      position: relative;
      margin: 5px;
    }
    .preview-img {
      max-width: 150px;
      border: 1px solid #ccc;
    }
    .remove-btn {
      position: absolute;
      top: -5px;
      right: -5px;
      background: red;
      color: white;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      font-size: 14px;
      width: 22px;
      height: 22px;
    }
  </style>
</head>
<body>
  <?php include('menu.php'); ?>

  <h1>Cadastrar Novo Imóvel</h1>
  <a href="index.php">← Voltar</a>
  <hr>

  <form method="POST" enctype="multipart/form-data">
    <label>Título:<br>
      <input type="text" name="titulo" required>
    </label><br><br>

    <label>Descrição:<br>
      <textarea name="descricao" rows="5" required></textarea>
    </label><br><br>

    <!-- Campo de categoria -->
    <label>Categoria:<br>
      <select name="tipo" required>
        <option value="">Selecione uma categoria</option>
        <option value="Apartamento">Apartamento</option>
        <option value="Casa">Casa</option>
        <option value="Terreno">Terreno</option>
        <option value="Comercial">Comercial</option>
        <option value="Rural">Rural</option>
      </select>
    </label><br><br>

    <label>Bairro:<br>
      <input type="text" name="bairro" required>
    </label><br><br>

    <label>Preço (ex: 350000):<br>
      <input type="text" name="preco" required>
    </label><br><br>

    <label>Imagens (até 3.5MB cada):<br>
      <input type="file" name="imagens[]" id="inputImagens" multiple accept="image/*">
    </label><br><br>

    <div id="preview"></div><br>

    <button type="submit">Salvar</button>
  </form>

  <script>
    const input = document.getElementById('inputImagens');
    const preview = document.getElementById('preview');
    let filesSelecionados = [];

    input.addEventListener('change', () => {
      preview.innerHTML = '';
      filesSelecionados = Array.from(input.files);

      filesSelecionados.forEach((file, index) => {
        const container = document.createElement('div');
        container.classList.add('preview-container');

        if (file.size <= 3.5 * 1024 * 1024) {
          const img = document.createElement('img');
          img.src = URL.createObjectURL(file);
          img.classList.add('preview-img');

          const btn = document.createElement('button');
          btn.textContent = '×';
          btn.classList.add('remove-btn');
          btn.onclick = (e) => {
            e.preventDefault();
            filesSelecionados.splice(index, 1);
            atualizarInput();
          };

          container.appendChild(img);
          container.appendChild(btn);
          preview.appendChild(container);
        } else {
          const aviso = document.createElement('p');
          aviso.style.color = 'red';
          aviso.textContent = `${file.name} excede 3.5MB`;
          preview.appendChild(aviso);
        }
      });
    });

    function atualizarInput() {
      const dataTransfer = new DataTransfer();
      filesSelecionados.forEach(file => dataTransfer.items.add(file));
      input.files = dataTransfer.files;

      const event = new Event('change');
      input.dispatchEvent(event);
    }
  </script>
</body>
</html>
