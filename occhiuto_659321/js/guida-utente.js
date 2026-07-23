document.addEventListener("DOMContentLoaded", async () => {
    const linkProfilo = document.getElementById("nav-profilo");

    try {
        // --- EFFETTUA UNA CHIAMATA ASINCRONA AL SERVER PER VERIFICARE LA SESSIONE ---
        // --- in questo modo il browser non deve aspettare la fine dell'operazione ---
        const response = await fetch("../php/check_session.php");
        if (response.ok) {
            // --- CONVERTE IL CORPO DELLA RISPOSTA DA JSON A OGGETTO JAVASCRIPT ---
            const status = await response.json();

            // --- SE LA PROPRIETÀ 'logged_in' È FALSA, L'UTENTE NON È AUTENTICATO ---
            if (!status.logged_in) {
                linkProfilo.textContent = "Accedi/Registrati";
                linkProfilo.href = "../php/login.php";
            }
        }
    } catch (error) {
        console.error("Errore nel controllo della sessione:", error);
    }
});