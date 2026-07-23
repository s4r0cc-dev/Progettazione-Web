<?php
// --- INCLUSIONE FILE DI TEMPLATE E FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../templates/utility.php';
require_once 'config.php';

// --- DEFINIZIONE DELLE VARIABILI DI CONFIGURAZIONE DELLA PAGINA ---
$titoloPagina = "CHI SIAMO?";
$percorsoImmagine = "../img/ciaksigira2.png";
$testoPagina = '
    <p class="paragrafo">
        Luci in sala, smartphone in silenzio e... <strong><u>CiakSiGira</u></strong>! 
        Nato dalla passione viscerale per la settima arte, il 
        nostro cinema è molto più di uno schermo: è un punto d\'incontro 
        per famiglie, cinefili e sognatori che amano condividere grandi 
        emozioni.
        <br><br>
        Abbiamo unito l\'atmosfera magica e accogliente delle sale di una 
        volta alle tecnologie audio e video di ultima generazione, per 
        farti vivere ogni film in modo totale e immersivo. Dalle spettacolari 
        saghe hollywoodiane alle gemme del cinema d\'autore, fino agli eventi 
        speciali e alle rassegne a tema, la nostra programmazione è pensata 
        per farti battere il cuore.
        <br><br>
        Prendi i tuoi popcorn, lasciati alle spalle il mondo esterno e mettiti 
        comodo: su <strong>CiakSiGira</strong>, il viaggio sta per iniziare!
    </p>';
// --- INVOCAZIONE DELLA FUNZIONE DI RENDERING BASATO SUL TEMPLATE ---
renderInformationalPage($titoloPagina, $percorsoImmagine, $testoPagina);
?>