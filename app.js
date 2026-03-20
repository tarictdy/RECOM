document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('login');
  const emailInput = document.getElementById('ide_id');
  const passwordInput = document.getElementById('pwd_id');
  const rememberMeCheckbox = document.getElementById('remember-me');

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    if (!emailInput.value || !passwordInput.value) {
      alert("Veuillez remplir tous les champs.");
      return;
    }

    const formData = {
      ide: emailInput.value,
      pwd: passwordInput.value,
      persistent: rememberMeCheckbox.checked,
      csrf_token: form.querySelector('input[name="csrf_token"]').value
    };

    try {
      const response = await fetch('login.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
      });

      // 🔎 Lire d'abord la réponse en texte
      const text = await response.text();

      let responseData;

      try {
        responseData = JSON.parse(text);
      } catch (e) {
        console.error("Réponse non JSON reçue :", text);
        alert("Erreur serveur. Vérifiez login.php.");
        return;
      }

      if (response.ok && responseData.success) {
        alert('Connexion réussie !');
        window.location.href = 'https://Recomander.html';
      } else {
        alert('Erreur : ' + (responseData.message || 'Connexion échouée'));
      }

    } catch (error) {
      console.error('Erreur lors de la requête:', error);
      alert('Une erreur est survenue, veuillez réessayer.');
    }
  });
});
