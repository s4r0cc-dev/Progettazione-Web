<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "COOKIE POLICY";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
            <p class="paragrafo">
            Il sito di <strong><u>CiakSiGira</u></strong> utilizza i cookie principalmente per garantirti una 
            navigazione fluida e gestire il tuo accesso. 
            <br><br>
            Usiamo cookie tecnici ed essenziali, che sono indispensabili, ad esempio, per mantenerti connesso 
            al tuo account mentre navighi tra le pagine e per ricordare quali posti hai scelto prima di confermare. 
            <br><br>
            Non usiamo cookie di profilazione per tracciare le tue abitudini commerciali. Se lo desideri, puoi disattivare 
            i cookie dalle impostazioni del tuo browser, ma in questo caso non potrai effettuare il login né prenotare i tuoi 
            posti sul sito.
            </p>';
// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>