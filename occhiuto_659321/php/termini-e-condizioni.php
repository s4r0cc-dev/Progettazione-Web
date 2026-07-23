<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "TERMINI E CONDIZIONI";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
            <p class="paragrafo">
            Benvenuto su <strong><u>CiakSiGira</u></strong>. Il nostro sito ti offre 
            un servizio di prenotazione dei posti totalmente gratuito, pensato 
            per farti scegliere la poltrona perfetta senza alcun pagamento anticipato 
            online. 
            <br><br>
            Effettuando una prenotazione, il tuo posto verrà riservato a tuo 
            nome per lo spettacolo selezionato. 
            <br><br>
            Il pagamento del biglietto avverrà direttamente ed esclusivamente 
            presso la biglietteria fisica del cinema al momento del tuo arrivo. 
            <br><br>
            Ti chiediamo la massima correttezza: se non puoi più venire, ti invitiamo 
            a cancellare la tua prenotazione per lasciare il posto ad altri spettatori.
            </p>';
            
// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>
