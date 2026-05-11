const appUrl = (route) => `${window.APP_BASE_URL || '/'}${route}`;

document.querySelectorAll('[data-toggle-password]').forEach((button) => {
  button.addEventListener('click', () => {
    const input = button.parentElement.querySelector('input');
    input.type = input.type === 'password' ? 'text' : 'password';
    button.textContent = input.type === 'password' ? 'Voir' : 'Masquer';
  });
});

document.querySelectorAll('[data-validate]').forEach((form) => {
  form.addEventListener('submit', (event) => {
    if (!form.checkValidity()) {
      event.preventDefault();
      form.reportValidity();
    }
  });
});

document.querySelectorAll('[data-imc-form]').forEach((form) => {
  const height = form.querySelector('[name="taille_cm"]');
  const weight = form.querySelector('[name="poids_kg"]');
  const output = form.querySelector('[data-imc-result]');

  const refreshImc = async () => {
    if (!height.value || !weight.value) return;

    const body = new FormData();
    body.append('taille_cm', height.value);
    body.append('poids_kg', weight.value);

    const response = await fetch(appUrl('ajax/imc'), { method: 'POST', body });
    const data = await response.json();
    output.textContent = `IMC : ${data.imc} - ${data.label}`;
  };

  height.addEventListener('input', refreshImc);
  weight.addEventListener('input', refreshImc);
  refreshImc();
});

document.querySelectorAll('[data-suggestion-form]').forEach((form) => {
  const target = document.querySelector('[data-suggestions]');
  const objective = form.querySelector('[name="objectif_id"]');
  const duration = form.querySelector('[name="duree_jours"]');

  const render = (data) => {
    const firstActivity = data.activites[0];
    if (!data.regimes.length || !firstActivity) {
      target.innerHTML = '<p>Aucune suggestion trouvée pour cet objectif.</p>';
      return;
    }

    const regimes = data.regimes.map((regime) => `
      <article class="suggestion">
        <h2>${regime.nom}</h2>
        <p>${regime.description}</p>
        <p>${regime.duree_jours} jours - ${Number(regime.prix).toLocaleString('fr-FR')} Ar - évolution ${regime.variation_poids_kg} kg</p>
        <form method="post" action="${appUrl('program')}">
          <input type="hidden" name="regime_id" value="${regime.id}">
          <input type="hidden" name="activite_id" value="${firstActivity.id}">
          <input type="hidden" name="duree_jours" value="${duration.value || '30'}">
          <button class="button" type="submit">Créer ce programme</button>
        </form>
      </article>
    `).join('');

    const activities = data.activites.map((activity) => `
      <li>${activity.nom} : ${activity.frequence_semaine} fois/semaine, ${activity.duree_minutes} min</li>
    `).join('');

    target.innerHTML = `
      <h2>Suggestions</h2>
      <div class="suggestion-grid">${regimes}</div>
      <h2>Activités adaptées</h2>
      <ul>${activities}</ul>
    `;
  };

  const loadSuggestions = async () => {
    const body = new FormData();
    body.append('objectif_id', objective.value);
    body.append('duree_jours', duration.value || '30');

    const response = await fetch(appUrl('ajax/suggestions'), { method: 'POST', body });
    render(await response.json());
  };

  objective.addEventListener('change', loadSuggestions);
  duration.addEventListener('input', loadSuggestions);
  loadSuggestions();
});

document.querySelectorAll('[data-recharge-form]').forEach((form) => {
  const result = form.querySelector('[data-recharge-result]');
  const balance = document.querySelector('[data-wallet-balance]');

  form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const response = await fetch(appUrl('ajax/recharge'), {
      method: 'POST',
      body: new FormData(form),
    });
    const data = await response.json();

    result.textContent = data.message;
    result.classList.toggle('error', !data.success);

    if (data.success) {
      balance.textContent = Number(data.solde).toLocaleString('fr-FR');
      form.reset();
    }
  });
});
