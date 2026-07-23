// --- SELEZIONE DEL CONTENITORE PER I MESSAGGI DI FEEDBACK ---
const containerMsg = document.querySelector(".modal-overlay");

document.addEventListener("DOMContentLoaded", () => {
    const listaPreferiti = [];
    const btnPreferiti = document.querySelector(".btn-modal-normal"); 

    // --- VERIFICA L'ESISTENZA DEL PULSANTE PRIMA DI ASSOCIARE L'EVENTO ---
    if (btnPreferiti) {
        btnPreferiti.addEventListener("click", () => {
            // --- RECUPERO DEI DATI DEL FILM MEDIANTE LE PROPRIETÀ DATASET DEL DOM ---
            // --- Questi dati provengono direttamente dagli attributi data-* stampati in PHP ---
            const idFilm = btnPreferiti.dataset.id;
            const titolo = btnPreferiti.dataset.titolo;
            const genere = btnPreferiti.dataset.genere;
            const durata = btnPreferiti.dataset.durata;
            const trama = btnPreferiti.dataset.trama;
            const stato = btnPreferiti.dataset.stato;
            const locandina = btnPreferiti.dataset.locandina;

            // --- FILTRO PER EVITARE AGGIUNTE REPLICATE NELL'ARRAY LOCALE DI SESSIONE ---
            const giaAggiunto = listaPreferiti.filter(f => f === idFilm).length;

            if (giaAggiunto === 0) {
                listaPreferiti.push(idFilm);
                
                // --- INVOCAZIONE DELLA FUNZIONE ASINCRONA PER IL SALVATAGGIO SUL DB ---
                salvaInPreferiti(idFilm, titolo, genere, durata, trama, stato, locandina);
            } else {
                showMsg("Il film è già presente nella lista locale dei preferiti.", containerMsg, false);
            }
        });
    }
});

// --- FUNZIONE ASINCRONA PER IL SALVATAGGIO DI TUTTI I DETTAGLI DEL FILM NEI PREFERITI ---
async function salvaInPreferiti(id, titolo, genere, durata, trama, stato, locandina) {
    // --- PREPARAZIONE DEL CORPO DELLA RICHIESTA TRAMITE FORMDATA ---
    const formData = new FormData();
    formData.append('id_film', id);
    formData.append('titolo', titolo);
    formData.append('genere', genere);
    formData.append('durata', durata);
    formData.append('trama', trama);
    formData.append('stato', stato);
    formData.append('locandina', locandina);
    
    try {
        // --- CHIAMATA ASINCRONA AL SERVER TRAMITE FETCH API (METODO POST) ---
        const response = await fetch('preferiti_api.php', {
            method: 'POST',
            body: formData
        });

        // --- GESTIONE DELLA RISPOSTA DEL SERVER E FEEDBACK ALL'UTENTE ---
        if (response.ok) {
            const risultatoText = await response.text(); 

            if (risultatoText.trim() === "Già presente") {
                showMsg("Il film è già presente nei preferiti", containerMsg, false);
            } else if (risultatoText.trim() === "Aggiunto") {
                showMsg("Film aggiunto ai preferiti!", containerMsg, false);
            } else {
                showMsg(risultatoText, containerMsg, true);
            }
        } else {
            showMsg("Errore di comunicazione col server.", containerMsg, true);
        }
    } catch (error) {
        // --- GESTIONE ERRORI DI RETE ED ECCEZIONI ---
        console.error("Errore di rete:", error);
        showMsg("Errore durante l'aggiunta.", containerMsg, true);
    }
}