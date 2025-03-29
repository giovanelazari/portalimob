<!-- POPUP + SCRIPT -->
<style>
#popup-whatsapp {
  display: none;
  position: fixed;
  z-index: 99999;
  inset: 0;
  background: rgba(0, 0, 0, 0.7);
}

#popup-whatsapp .box {
  background: white;
  padding: 24px;
  max-width: 360px;
  margin: 80px auto;
  border-radius: 10px;
  font-family: sans-serif;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  position: relative;
  text-align: center;
}

#popup-whatsapp input {
  width: 100%;
  padding: 10px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

#popup-whatsapp button {
  background-color: #25D366;
  color: white;
  border: none;
  padding: 10px 16px;
  border-radius: 6px;
  cursor: pointer;
}

#popup-whatsapp .close-btn {
  position: absolute;
  top: 8px;
  right: 10px;
  cursor: pointer;
  font-size: 18px;
}
</style>

<div id="popup-whatsapp">
  <div class="box">
    <span class="close-btn" onclick="fecharPopupWhatsapp()">✖</span>
    <h3>Antes de falar no WhatsApp</h3>
    <p>Informe seu nome e telefone. Vamos te atender rapidinho 😊</p>
    <form onsubmit="enviarLeadEIrParaWhatsapp(event)">
      <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
      <input type="text" id="telefone" name="telefone" placeholder="Seu telefone" required>
      <button type="submit">Falar agora</button>
    </form>
  </div>
</div>

<script>
  const numeroWhatsapp = "<?= $config['whatsapp_numero'] ?>";
  const imovelId = typeof imovelId !== 'undefined' ? imovelId : 0;

  function abrirPopupWhatsapp() {
    document.getElementById('popup-whatsapp').style.display = 'block';
  }

  function fecharPopupWhatsapp() {
    document.getElementById('popup-whatsapp').style.display = 'none';
  }

  function enviarLeadEIrParaWhatsapp(event) {
    event.preventDefault();
    const nome = document.getElementById('nome').value;
    const telefone = document.getElementById('telefone').value;

    fetch('registrar_lead_whatsapp.php?id=' + imovelId + '&nome=' + encodeURIComponent(nome) + '&telefone=' + encodeURIComponent(telefone))
      .then(() => {
        dataLayer.push({ event: 'whatsapp_click' });
        window.location.href = 'https://wa.me/' + numeroWhatsapp;
      });
  }
</script>
