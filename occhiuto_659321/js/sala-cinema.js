document.addEventListener("DOMContentLoaded", () => {
    const mappaPosti = document.getElementById("mappa-posti");
    const postiScelti = document.getElementById("posti-scelti");
    const btnConferma = document.getElementById("btn-conferma");
    const msgContainer = document.querySelector(".modal-overlay");
    
    // --- RECUPERA L'ID_PROIEZIONE DAL DATASET DELLA MAPPA ---
    const idProiezione = mappaPosti.dataset.proiezione; 
    const righe = ['A', 'B', 'C', 'D', 'E'];
    const postiPerRiga = 10;
    let postiSelezionati = [];

    // --- 1. COSTRUISCE LA GRIGLIA DEI POSTI NELLA SALA ---
    function costruisciSala() {
        righe.forEach(letteraRiga => {
            const divRiga = document.createElement("div");
            divRiga.classList.add("riga-posti");

            // --- CREA L'ETICHETTA PER LA RIGA (ES. A, B, C...) ---
            const etichetta = document.createElement("div");
            etichetta.classList.add("etichetta-riga");
            etichetta.textContent = letteraRiga;
            divRiga.appendChild(etichetta);

            // --- GENERA GLI ELEMENTI POSTO (1-10 PER RIGA) ---
            for (let i = 1; i <= postiPerRiga; i++) {
                const idPosto = `${letteraRiga}${i}`;
                const divPosto = document.createElement("div");
                divPosto.classList.add("posto", "libero");
                divPosto.id = `posto-${idPosto}`;
                divPosto.dataset.posto = idPosto;
                divPosto.textContent = i;

                // --- EVENT LISTENER PER LA SELEZIONE ---
                divPosto.addEventListener("click", () => selezionaPosto(divPosto, idPosto));
                divRiga.appendChild(divPosto);
            }
            mappaPosti.appendChild(divRiga);
        });
        caricaPostiOccupati();
    }

    // --- 2. INTERROGA L'API PER COLORARE I POSTI OCCUPATI --- 
    async function caricaPostiOccupati() {
        try {
            const response = await fetch(`prenotazioni_api.php?id_proiezione=${idProiezione}`);
            if (response.ok) {
                const postiOccupati = await response.json();
                postiOccupati.forEach(idPosto => {
                    const elementoPosto = document.getElementById(`posto-${idPosto}`);
                    if (elementoPosto) {
                        elementoPosto.classList.remove("libero");
                        elementoPosto.classList.add("occupato");
                    }
                });
            }
        } catch (error) {
            console.error("Errore nel caricamento dei posti occupati:", error);
        }
    }

    // --- 3. TOGGLE DELLA CLASSE 'SELEZIONATO' E GESTIONE ARRAY ---
    function selezionaPosto(elementoPosto, idPosto) {
        if (elementoPosto.classList.contains("occupato")) return;
        elementoPosto.classList.toggle("selezionato");
        if (elementoPosto.classList.contains("selezionato")) {
            postiSelezionati.push(idPosto);
        } else {
            postiSelezionati = postiSelezionati.filter(p => p !== idPosto);
        }
        aggiornaRiepilogo();
    }

    // --- 4. AGGIORNA IL TESTO DEL RIEPILOGO E ABILITA IL PULSANTE CONFERMA ---
    function aggiornaRiepilogo() {
        // --- NESSUNA SELEZIONE ---
        if (postiSelezionati.length === 0) {
            postiScelti.textContent = "Nessuno";
            btnConferma.disabled = true;
        } else {
            // --- ELENCO POSTI SELEZIONATI DIVISI DA , ---
            postiScelti.textContent = postiSelezionati.join(", ");
            btnConferma.disabled = false;
        }
    }

    // --- 5. INVIO DELLA PRENOTAZIONE AL SERVER TRAMITE API POST ---
    btnConferma.addEventListener("click", async () => {
        btnConferma.disabled = true;
        try {
            // --- RICHIESTA POST DELLA PRENOTAZIONE ---
            const response = await fetch("prenotazioni_api.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id_proiezione: idProiezione,
                    posti: postiSelezionati
                })
            });
            const result = await response.json();
            if (response.ok) {
                showMsg("Prenotazione effettuata con successo!", msgContainer);
                // --- REINDIRIZZAMENTO ALLA DASHBOARD PER VERIFICARE LE PRENOTAZIONI ---
                setTimeout(() => {
                    window.location.href = "../php/area-personale.php"; 
                }, 3000);
            } else {
                showMsg("Errore: " + (result.error || "Impossibile completare la prenotazione."), msgContainer);
                window.location.reload();
            }
        } catch (error) {
            console.error("Errore di rete durante l'invio della prenotazione:", error);
            btnConferma.disabled = false;
        }
    });
    costruisciSala();
});