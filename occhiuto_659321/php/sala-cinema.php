<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

    // --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
    if (!isset($_SESSION['id_utente'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_GET['id_proiezione'])) {
        header("Location: index.php");
        exit();
    }

    $id_proiezione = $_GET['id_proiezione'];

    // --- RECUPERO INFORMAZIONI SULLA PROIEZIONE DI QUEL FILM ---
    $stmt = $conn->prepare("
        SELECT f.titolo, p.nome_sala, p.data_ora 
        FROM programmazione p 
        JOIN film f ON p.id_film = f.id_film 
        WHERE p.id_proiezione = ?
    ");
    $stmt->bind_param("i", $id_proiezione);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        exit("Proiezione non trovata.");
    }
    $proiezione = $result->fetch_assoc();
    $data_formattata = date('d/m/Y H:i', strtotime($proiezione['data_ora']));
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenotazione - <?php echo htmlspecialchars($proiezione['titolo']); ?></title>
    <link rel="icon" href="../icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/sala-cinema.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main class="container-sala">
        <div class="modal-overlay"></div>
        <h2 class="titolo-film"><?php echo htmlspecialchars($proiezione['titolo']); ?></h2>
        <div class="info-proiezione">
            <p><strong>Sala</strong>: <?php echo htmlspecialchars($proiezione['nome_sala']); ?> | <strong>Data e Ora</strong>: <?php echo $data_formattata; ?></p>
        </div>
        <h3 class="titolo-prenotazione">Prenota il tuo posto</h3>
        <div class="schermo-cinema">SCHERMO</div>
        
        <div id="mappa-posti" class="mappa-posti" data-proiezione="<?php echo $id_proiezione; ?>"></div>

        <div class="legenda">
            <div class="posto libero"></div> <span>Libero</span>
            <div class="posto selezionato"></div> <span>Selezionato</span>
            <div class="posto occupato"></div> <span>Occupato</span>
        </div>

        <div class="riepilogo-prenotazione">
            <p>Posti selezionati: <span id="posti-scelti">Nessuno</span></p>
            <button id="btn-conferma" class="btn-conferma" disabled>Conferma Prenotazione</button>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>
    <script src="../js/utility.js"></script>
    <script src="../js/sala-cinema.js"></script>
</body>
</html>