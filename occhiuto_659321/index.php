<?php 
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'php/config.php'; 
?>
<!DOCTYPE HTML>

<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <title>CiakSiGira - Home</title>
        <link rel="icon" href="icona.ico">
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/home.css">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/footer.css">
    </head>
    <body>
        <!-- HEADER -->
        <?php include 'templates/header.php';?>
        <main>
        <!-- CAROSELLO -->
        <div class="carousel-container">
            <button id="prevBtn" aria-label="precedente">&#10094;</button>
            <div class="carousel-track">
                
                <?php
                // --- QUERY CHE RESTITUISCE I FILM PER GESTIRE IL CAROSELLO ---
                $sql = "SELECT id_film, titolo FROM film";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo "<div class='film-card' data-url='php/film.php?id_film={$row['id_film']}'>
                    <img src='img/{$row['id_film']}_copertina.jpg' alt='" . htmlspecialchars($row['titolo']) . "'>
                    </div>";
                }
                ?>

            </div>
            <button id="nextBtn" aria-label="successivo">&#10095;</button>
            </div>

        <!-- SEZIONE PROGRAMMAZIONE SETTIMANALE -->
        <div class="programmazione">
            <h2>Programmazione Settimanale</h2>
            <ul class="lista-film">
                
                <?php
                // --- CALCOLO INTERVALLO TEMPORALE TRA OGGI E 14 GIORNI ---
                $oggi = date('Y-m-d');
                $tra_due_settimane = date('Y-m-d', strtotime('+14 days'));

                // --- QUERY CHE RESTITUISCE I DETTAGLI DEI FILM E LA PROGRAMMAZIONE NELL'INTERVALLO ---
                $sql_prog = "SELECT f.id_film, f.titolo, p.data_ora, p.nome_sala 
                            FROM programmazione p 
                            JOIN film f ON p.id_film = f.id_film 
                            WHERE DATE(p.data_ora) BETWEEN '$oggi' AND '$tra_due_settimane' 
                            ORDER BY p.data_ora ASC";
                
                $res_prog = $conn->query($sql_prog);
                
                // --- GESTIONE ERRORE QUERY E VISUALIZZAZIONE PROGRMMAZIONE ---
                if (!$res_prog) {
                    echo "<li style='color:red;'>Errore SQL: " . $conn->error . "</li>";
                } elseif ($res_prog->num_rows > 0) {
                    while($row = $res_prog->fetch_assoc()){
                        // --- FORMATTAZIONE DATA-ORA PER LA VISUALIZZAZIONE ---
                        $data_ora = date('d/m/Y - H:i', strtotime($row['data_ora']));
                        
                        echo "<li>";
                        echo "<span class='ora-film'>$data_ora</span> | ";
                        echo "<strong class='titolo-film' data-url='php/film.php?id_film={$row['id_film']}'>" . htmlspecialchars($row['titolo']) . "</strong> | ";
                        echo "<span class='sala-film'>Sala: <strong>" . htmlspecialchars($row['nome_sala']) . "</strong></span>";
                        echo "</li>";
                    }
                } else {
                    echo "<li class='nessun-film'>Nessun film in programmazione nei prossimi 14 giorni.</li>";
                }
                ?>
            </ul>
            </div>
    </main>
    <?php include 'templates/footer.php'; ?>
    <script src="js/home.js"></script>
    </body>
</html>

    