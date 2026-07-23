<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiakSiGira - Dettaglio Film</title>
    <link rel="icon" href="../icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/film.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main>
        <div class="modal-overlay"></div>
        <?php
        // --- VERIFICA CHE L'IDENTIFICATIVO DEL FILM SIA STATO PASSATO TRAMITE URL (GET) ---
        if (isset($_GET['id_film'])) {
            $id_film = $_GET['id_film'];

            // --- 1. PRENDE I DETTAGLI DEL FILM DAL DB TRAMITE PREPARED STATEMENT ---
            $stmt = $conn->prepare("SELECT id_film, titolo, durata, genere, trama, stato FROM film WHERE id_film = ?");
            $stmt->bind_param("s", $id_film);
            $stmt->execute();
            $result = $stmt->get_result();

            // --- CONTROLLA SE IL FILM ESISTE NEL DATABASE ---
            if ($result->num_rows > 0) {
                $film = $result->fetch_assoc();
                
                // --- LOCANDINA FILM ---
                $percorso_locandina = "../img/" . $film['id_film'] . "_locandina.jpg";
                echo "<div class='content-page'>";
                    echo "<div class='locandina-container'>";
                        echo "<img src='" . $percorso_locandina . "' alt='" . htmlspecialchars($film['titolo']) . "'>";
                    echo "</div>";
                    
                    // --- DETTAGLI FILM ---
                    echo "<div class='dettagli-container'>";
                        echo "<h2 class='titolo'>" . htmlspecialchars($film['titolo']) . "</h2>";
                        echo "<p class='paragrafo'><strong>Genere:</strong> " . htmlspecialchars($film['genere']) . "</p>";
                        echo "<p class='paragrafo'><strong>Durata:</strong> " . htmlspecialchars($film['durata']) . " minuti</p>";
                        echo "<p class='paragrafo'><strong>Stato:</strong> " . htmlspecialchars($film['stato']) . "</p>";
                        echo "<p class='paragrafo'><strong>Trama:</strong> " . htmlspecialchars($film['trama']) . "</p>";
                        
                       // --- 1. PREPARAZIONE DELLE STRINGHE SICURE LATO HTML ---
                        $id_html        = htmlspecialchars($film['id_film']);
                        $titolo_html    = htmlspecialchars($film['titolo']);
                        $genere_html    = htmlspecialchars($film['genere']);
                        $durata_html    = htmlspecialchars($film['durata']);
                        $trama_html     = htmlspecialchars($film['trama']);
                        $stato_html     = htmlspecialchars($film['stato']);
                        $locandina_html = htmlspecialchars($percorso_locandina);

                        // --- 2. STAMPA DEL PULSANTE SENZA EVENTO ONCLICK INLINE ---
                        // Memorizza i valori dentro i relativi campi data-* dell'elemento
                        echo '<button class="btn-modal-normal" id="btn-normal" 
                                data-id="' . $id_html . '" 
                                data-titolo="' . $titolo_html . '" 
                                data-genere="' . $genere_html . '" 
                                data-durata="' . $durata_html . '" 
                                data-trama="' . $trama_html . '" 
                                data-stato="' . $stato_html . '" 
                                data-locandina="' . $locandina_html . '">Aggiungi ai Preferiti</button>';
                        echo '</div>';

                    // --- SEZIONE PROGRAMMAZIONE ---
                    echo "<section class='programmazione-film'>";
                    echo "<h3>PROGRAMMAZIONE DISPONIBILE</h3>";

                    // --- 2. RECUPERA LE PROIEZIONI FUTURE PER LO SPECIFICO FILM ---
                    $stmt_prog = $conn->prepare("SELECT id_proiezione, nome_sala, data_ora FROM programmazione WHERE id_film = ? AND data_ora >= NOW() ORDER BY data_ora ASC");
                    $stmt_prog->bind_param("s", $film['id_film']);
                    $stmt_prog->execute();
                    $res_prog = $stmt_prog->get_result();

                    // --- VERIFICA SE CI SONO PROIEZIONI DISPONIBILI ---
                    if ($res_prog->num_rows > 0) {
                        $data_precedente = null;

                        while ($prog = $res_prog->fetch_assoc()) {
                            // --- FORMATTAZIONE DI DATA E ORA ---
                            // --- Uso di date() e strtotime() per separare e formattare data e ora ---
                            $data_corrente = date('d/m/Y', strtotime($prog['data_ora']));
                            $ora = date('H:i', strtotime($prog['data_ora']));

                            // --- RAGGRUPPAMENTO DELLE PROIEZIONI PER DATA ---
                            if ($data_corrente !== $data_precedente) {
                                if ($data_precedente !== null) echo "</div>";
                                echo "<p class='data-film'><strong style='color: whitesmoke;'>$data_corrente</strong></p>";
                                echo "<div class='sale-container'>";
                                $data_precedente = $data_corrente;
                            }

                            // --- PULSANTE DELLA PROIEZIONE: EVENTO ONCLICK CHE REINDIRIZZA ALLA SCELTA POSTI (SALA CINEMA) ---
                            echo "<button class='prenotazione-button' onclick=\"window.location.href='sala-cinema.php?id_proiezione={$prog['id_proiezione']}'\">
                            Sala {$prog['nome_sala']} {$ora}</button>";
                        }
                        echo "</div>";
                    } else {
                        echo "<p>Nessuna proiezione programmata al momento.</p>";
                    }
                    echo "</section>";

                    echo "</div>";
            } else {
                echo "<p class='film-non-trovato'>Film non trovato nel database.</p>";
            }
            // --- CHIUSURA PREPARED STATEMENT ---
            $stmt->close();
        }
        ?>
    </main>

    <?php include '../templates/footer.php'; ?>
    <script src="../js/utility.js"></script>
    <script src="../js/film.js"></script>
</body>
</html>