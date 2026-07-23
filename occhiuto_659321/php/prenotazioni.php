<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

// --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_utente = $_SESSION['id_utente'];

// --- QUERY PER RACCOGLIERE I DATI DELLE PRENOTAZIONI DELL'UTENTE LOGGATO ---
$stmt = $conn->prepare("
    SELECT p.id_proiezione, p.posto, pr.data_ora, pr.nome_sala, f.titolo 
    FROM prenotazioni p
    JOIN programmazione pr ON p.id_proiezione = pr.id_proiezione
    JOIN film f ON pr.id_film = f.id_film
    WHERE p.id_utente = ?
    ORDER BY pr.data_ora DESC
");

$stmt->bind_param("i", $id_utente);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiakSiGira - Le Mie Prenotazioni</title>
    <link rel="icon" href="../icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/prenotazioni.css">
    <link rel="stylesheet" href="../css/footer.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2 class="titolo">LE MIE PRENOTAZIONI</h2>
    <main class="prenotazioni-container">
        <!-- ANNULLA PRENOTAZIONE -->
        <div class="modal-overlay" id="annulla-prenotazione-msg" style="display: none;">
            <p class="modal-msg" id="testo-conferma-custom"></p>
            <div class="modal-button-area">
                <button type="button" class="btn-modal-cancel">Annulla</button>
                <button type="button" class="btn-modal-confirm">Conferma</button>
            </div>
        </div>

        <div class="msg-container" style="display: none"></div>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="item-prenotazione" id="prenotazione-<?php echo $row['id_proiezione'] . '-' . $row['posto']; ?>">
                    <h3><?php echo htmlspecialchars($row['titolo']); ?></h3>
                    <p>Sala: <strong><?php echo htmlspecialchars($row['nome_sala']); ?></strong> | Posto: <strong><?php echo htmlspecialchars($row['posto']); ?></strong></p>
                    <p>Data Spettacolo: <span><?php echo date('d/m/Y H:i', strtotime($row['data_ora'])); ?></span></p>
                    
                    <button class="btn-modal-elimina" onclick="annullaPrenotazione(<?php echo $row['id_proiezione']; ?>, '<?php echo $row['posto']; ?>')">
                        Cancella Prenotazione
                    </button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Non hai ancora effettuato nessuna prenotazione.</p>
        <?php endif; ?>
    </main>
    <?php include '../templates/footer.php'; ?>
    <script src="../js/prenotazioni.js"></script>
    <script src="../js/utility.js"></script>
</body>
</html>

