document.addEventListener("DOMContentLoaded", () => {
    // --- GESTIONE ELIMINAZIONE ACCOUNT ---
    const btnElimina = document.querySelector(".elimina-account");
    const overlay = document.getElementById("delete-account-msg");
    const btnAnnulla = document.querySelector(".btn-modal-cancel");
    const btnConferma = document.querySelector(".btn-modal-confirm");
    const formElimina = document.getElementById("form-elimina");

    if (btnElimina && overlay && btnAnnulla && btnConferma && formElimina) {
        // --- MOSTRA L'OVERLAY QUANDO SI CLICCA "ELIMINA ACCOUNT" ---
        btnElimina.addEventListener("click", (e) => {
            e.preventDefault(); 
            overlay.style.display = "block";
        });

        // --- NASCONDE L'OVERLAY SE ANNULLI ---
        btnAnnulla.addEventListener("click", () => {
            overlay.style.display = "none";
        });

        // --- CONFERMA ELIMINAZIONE INVIANDO IL FORM ---
        btnConferma.addEventListener("click", () => {
            formElimina.submit();
        });
    }
});