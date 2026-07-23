<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "PRIVACY POLICY";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
            <p class="paragrafo">
            La tutela dei tuoi dati è importante per <strong><u>CiakSiGira</u></strong>. 
            <br><br>
            Quando ti registri sul nostro sito, creiamo un profilo personale sicuro in cui conserviamo 
            i dati minimi necessari (come nome, cognome, indirizzo email e password cifrata). 
            <br><br>
            Queste informazioni servono a farti accedere al tuo account, a gestire le tue prenotazioni e 
            a permettere al personale in cassa di rintracciarle al tuo arrivo. 
            <br><br>
            I tuoi dati rimarranno salvati nel nostro database finché deciderai di mantenere attivo il tuo account. 
            Non condivideremo mai le tue informazioni con terze parti e potrai richiedere la cancellazione del 
            tuo profilo in qualsiasi momento tramite le impostazioni del sito.
            </p>';

// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>