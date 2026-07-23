<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "DOMANDE FREQUENTI - FAQ";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
            <div class="paragrafo">           
            <h3>1. Come posso prenotare un posto per un film?</h3>
            Per prenotare ti basta registrarti o accedere al tuo account, scegliere 
            il film e l\'orario che preferisci dal palinsesto, selezionare i posti sulla 
            mappa della sala e cliccare su "<strong><u>Conferma Prenotazione</u></strong>".
            <br><br>

            <h3>2. Devo pagare online al momento della prenotazione?</h3>
            No. Il nostro sito gestisce esclusivamente la prenotazione gratuita dei posti. 
            Il pagamento dei biglietti avverrà direttamente ed esclusivamente in contanti o 
            con carta presso la biglietteria fisica del cinema prima dell\'inizio del film.
            <br><br>

            <h3>3. Posso cancellare una prenotazione se cambio idea?</h3>
            Certamente. Se non puoi più venire al cinema, ti chiediamo la massima correttezza: 
            accedi alla tua area personale sul sito, vai alla sezione "<strong><u>Le mie prenotazioni</u></strong>" e 
            clicca su "<strong><u>Cancella Prenotazione</u></strong>". In questo modo il posto tornerà subito disponibile per altri 
            spettatori.
            <br><br>

            <h3>4. È obbligatorio registrarsi per prenotare?</h3>
            Sì, la registrazione è necessaria per poter associare i posti a un nome reale. 
            Creando un account potrai gestire le tue prenotazioni in totale autonomia e mostrare 
            rapidamente il tuo profilo alla cassa del cinema.
            <br><br>

            <h3>5. Cosa succede se arrivo in ritardo al cinema?</h3>
            Il tuo posto rimarrà riservato a tuo nome. Tuttavia, ti consigliamo di arrivare con un 
            po\' di anticipo rispetto all\'orario di inizio del film per evitare code alla biglietteria 
            e non perdere l\'inizio dello spettacolo.
            </div>';

// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>