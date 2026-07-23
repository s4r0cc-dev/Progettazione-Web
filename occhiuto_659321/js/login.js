document.addEventListener("DOMContentLoaded", function() {
    // --- RECUPERA I PARAMETRI DALL'URL CORRENTE (es: ?error=user_exists) ---
    const urlParams = new URLSearchParams(window.location.search);
    const regMsg = document.getElementById('reg-msg');
    const loginMsg = document.getElementById('login-msg');

    // --- GESTIONE MESSAGGI BASATA SU PARAMETRI URL ---
    if(urlParams.has('success_reg')) {
        // --- SUCCESSO ---
        showMsg('Registrazione avvenuta con successo!', regMsg, false);
        const formReg = document.querySelector('.registrazione-section form');
        if(formReg) formReg.reset();
    } 
    // --- UTENTE GIA' ESISTENTE ---
    else if (urlParams.has('error') && urlParams.get('error') === 'user_exists') {
        showMsg('Errore: Username o Email già in uso.', regMsg, true);
    }
    // --- CREDENZIALI NON VALIDE ---
    else if (urlParams.has('error') && urlParams.get('error') === 'invalid_creds') {
        showMsg('Credenziali non valide.', loginMsg, true);
    }

    // --- RIPULISCE L'URL DOPO AVER MOSTRATO IL MESSAGGIO PER EVITARE CHE RIAPPAIA AL REFRESH ---
    if(urlParams.has('success_reg') || urlParams.has('error')){
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});