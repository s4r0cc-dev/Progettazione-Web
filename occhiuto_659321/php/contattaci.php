<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "CONTATTACI";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
            <p class="paragrafo">È possibile contattare il servizio clienti attraverso i seguenti recapiti:</p>

            <ul class="lista-contatti">
                <li>Numero di telefono: <a href="tel:+0501234567">+050 1234567</a></li>
                <li>Email: <a href="mailto:supporto@ciaksigira.it">supporto@ciaksigira.it</a></li>
            </ul>

            <p class="paragrafo nota-orari">
                Il supporto telefonico è attivo dal Lunedì al Venerdì dalle 8:00 alle 18:00. 
                Le richieste via e-mail possono essere inviate tutti i giorni, con tempi di risposta garantiti entro 24 ore.
            </p>';
// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>