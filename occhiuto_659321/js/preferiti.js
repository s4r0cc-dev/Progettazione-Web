document.addEventListener("DOMContentLoaded", renderizzaPreferiti);

async function renderizzaPreferiti() {
    const container = document.getElementById("lista-preferiti");

    // --- RICHIESTA ASINCRONA DEI DATI AL SERVER ---
    const response = await fetch('preferiti_api.php');
    const preferiti = await response.json();

    // --- GESTIONE LISTA VUOTA ---
    if (preferiti.length === 0) {
        container.innerHTML = "<p class='empty-msg'>Nessun preferito.</p>";
        return;
    }

    // --- PULIZIA DEL CONTENITORE E GENERAZIONE DINAMICA DEGLI ELEMENTI ---
    container.innerHTML = "";
    preferiti.forEach(film => {
        const filmCard = document.createElement("div");
        filmCard.className = "film-card";
        filmCard.innerHTML = `
            <img src="../img/${film.id_film}_locandina.jpg" alt="${film.id_film}" class="preferito-locandina">
            <div class="preferito-info">
                <h2 class="preferito-titolo">${film.titolo}</h2>
                <p class="preferito-durata"><strong>Durata</strong>: ${film.durata} minuti</p>
                <p class="preferito-genere"><strong>Genere</strong>: ${film.genere}</p>
                <p class="preferito-stato"><strong>Stato</strong>: ${film.stato}</p>
                <p class="preferito-trama"><strong>Trama</strong>: ${film.trama}</p>
                <button class="btn-modal-confirm" onclick="eliminaPreferito('${film.id_film}')">Elimina</button>
            </div>
        `;
        container.appendChild(filmCard);
    });
}
// --- FUNZIONE ASINCRONA CHE GESTISCE L'ELIMINAZIONE DEL FILM DAI PREFERITI ---
async function eliminaPreferito(idFilm) {
    // --- ESECUZIONE DELLA CHIAMATA DELETE AL SERVER ---
    await fetch('preferiti_api.php', {
        method: 'DELETE',
        body: 'id_film=' + idFilm
    });
    // --- AGGIORNAMENTO INTERFACCIA DOPO L'ELIMINAZIONE ---
    renderizzaPreferiti();
}