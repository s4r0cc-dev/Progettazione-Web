const msgContainer = document.querySelector(".msg-container");
const overlayAnnulla = document.getElementById("annulla-prenotazione-msg");
const testoConfermaCustom = document.getElementById("testo-conferma-custom");
const btnAnnulla = document.querySelector(".btn-modal-cancel");
const btnConferma = document.querySelector(".btn-modal-confirm");
const prenotazioniContainer = document.querySelector(".prenotazioni-container");

// --- VARIABILI GLOBALI TEMPORANEE PER SALVARE QUALE BIGLIETTO L'UTENTE VUOLE CANCELLARE ---
let idProiezioneDaAnnullare = null;
let postoDaAnnullare = null;

// --- 1. FUNZIONE AL CLICK DI "ANNULLA PRENOTAZIONE" DEL BIGLIETTO ---
// --- ATTIVA IL MODALE PER ANNULLARE LA PRENOTAZIONE ---
function annullaPrenotazione(idProiezione, posto) {
    idProiezioneDaAnnullare = idProiezione;
    postoDaAnnullare = posto;

    testoConfermaCustom.textContent = `Sei sicuro di voler annullare la prenotazione per il posto ${posto}?`;
    overlayAnnulla.style.display = "block";
}

document.addEventListener("DOMContentLoaded", () => {
    // --- 2. CLICK SU "ANNULLA", NASCONDE IL MODALE DELL'ANNULLAMENTO ---
    btnAnnulla.addEventListener("click", () => {
        overlayAnnulla.style.display = "none";
        idProiezioneDaAnnullare = null;
        postoDaAnnullare = null;
    });

    // --- 3. CLICK SU "CONFERMA", ESEGUE LA API DELETE ---
    btnConferma.addEventListener("click", async () => {
        if (!idProiezioneDaAnnullare || !postoDaAnnullare) return;

        overlayAnnulla.style.display = "none";
        msgContainer.style.display = "block";

        try {
            // --- INVIO DELLA RICHIESTA DELETE AL SERVER ---
            const response = await fetch("prenotazioni_api.php", {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_proiezione: idProiezioneDaAnnullare,
                    posto: postoDaAnnullare
                })
            });

            const result = await response.json();

            // --- GESTIONE DELLA RISPOSTA DAL SERVER ---
            if (response.ok) {
                showMsg("Prenotazione annullata con successo. Il posto è di nuovo libero!", msgContainer);

                // --- RIMUOVI IL BIGLIETTO DALL'INTERFACCIA ---
                const item = document.getElementById(`prenotazione-${idProiezioneDaAnnullare}-${postoDaAnnullare}`);
                if (item) {
                    item.remove();
                }

                // --- AGGIORNAMENTO DINAMICO: CONTROLLO SE LA LISTA È VUOTA ---
                const bigliettiRimasti = document.querySelectorAll(".item-prenotazione");
                if (bigliettiRimasti.length === 0) {
                    const msgVuoto = document.createElement("p");
                    msgVuoto.textContent = "Non hai ancora effettuato nessuna prenotazione.";
                    prenotazioniContainer.appendChild(msgVuoto);
                    msgContainer.style.display = "none";
                }

            } else {
                showMsg("Errore: " + (result.error || "Impossibile annullare la prenotazione."), msgContainer);
            }
        } catch (error) {
            console.error("Errore di rete:", error);
            showMsg("Errore di comunicazione col server.", msgContainer);
        } finally {
            // --- RESET VARIABILI DOPO IL COMPLETAMENTO ---
            idProiezioneDaAnnullare = null;
            postoDaAnnullare = null;
        }
    });
});