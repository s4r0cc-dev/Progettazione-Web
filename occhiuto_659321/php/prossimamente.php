<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiakSiGira - Prossimamente</title>
    <link rel="icon" href="../icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/prossimamente.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2 class="titolo">PROSSIMAMENTE</h2
    >
    <main>
        <?php
        // --- FILM 'NOVITA'' CON TUTTE LE INFORMAZIONI E LA PRIMA DISPONIBILITA' ---
        $sql = "SELECT f.id_film, f.titolo, f.genere, f.durata, f.trama, f.stato, MIN(p.data_ora) as prima_data 
                FROM film f 
                LEFT JOIN programmazione p ON f.id_film = p.id_film 
                WHERE f.stato = 'novità' 
                GROUP BY f.id_film, f.titolo, f.genere, f.durata, f.trama, f.stato";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($film = $result->fetch_assoc()) {
                $percorso_locandina = "../img/" . $film['id_film'] . "_locandina.jpg";
                
                echo "<div class='content-page' onclick=\"window.location.href='film.php?id_film=" . $film['id_film'] . "'\">";
                    
                    // --- LOCANDINA FILM ---
                    echo "<div class='locandina-container'>";
                        echo "<img src='" . $percorso_locandina . "' alt='" . htmlspecialchars($film['titolo']) . "'>";
                    echo "</div>";
                    
                    // --- DETTAGLI FILM ---
                    echo "<div class='dettagli-container'>";
                        echo "<h2 class='titolo-film'>" . htmlspecialchars($film['titolo']) . "</h2>";
                        echo "<p class='paragrafo'><strong>Genere</strong>: " . htmlspecialchars($film['genere']) . "</p>";
                        echo "<p class='paragrafo'><strong>Durata</strong>: " . htmlspecialchars($film['durata']) . " minuti</p>";
                        echo "<p class='paragrafo'><strong>Stato</strong>: " . htmlspecialchars($film['stato']) . "</p>";
                        
                        // --- PRIMA DATA DISPONIBILE ---
                        if ($film['prima_data']) {
                            $data_formattata = date('d/m/Y', strtotime($film['prima_data']));
                            echo "<p class='paragrafo'><strong>Disponibile dal</strong>: <span class='data-evidenza'>" . $data_formattata . "</span></p>";
                        } else {
                            echo "<p class='paragrafo'><strong>Disponibile dal</strong>: <span class='data-evidenza'>Data in fase di definizione</span></p>";
                        }
                        echo "<p class='paragrafo'><strong>Trama</strong>: " . htmlspecialchars($film['trama']) . "</p>";
                    echo "</div>";

                echo "</div>";
            }
        } else {
            echo "<p class='nessun-risultato'>Al momento non ci sono nuove uscite in arrivo.</p>";
        }
        ?>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>