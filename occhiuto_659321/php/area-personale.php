<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

// --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

// --- 2. RECUPERO DATI UTENTE: USO DI PREPARED STATEMENTS PER SICUREZZA ---
$stmt = $conn->prepare("SELECT nome, cognome, username, email FROM utenti WHERE id_utente = ?");
$stmt->bind_param("i", $_SESSION['id_utente']);
$stmt->execute();
$result = $stmt->get_result();

// --- 3. CHECK UTENTE ESISTENTE ---
if ($result->num_rows === 1) {
    $utente = $result->fetch_assoc();
} else {
    // --- SESSIONE VALIDA, MA UTENTE CANCELLATO DAL DB ---
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiakSiGira - Area Personale - <?php echo htmlspecialchars($utente['username']); ?></title>
    <link rel="icon" href="../icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/area-personale.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>
    <h2 class="titolo">IL MIO PROFILO</h2>
    <main class="content-page">
        <!-- MODALE PER LA CANCELLAZIONE DELL'ACCOUNT -->
        <div class="modal-overlay" id="delete-account-msg">
            <p class="modal-msg">Sei sicuro di voler eliminare il tuo account? Questa azione è irreversibile.</p>
            <div class="modal-button-area">
                <button type="button" class="btn-modal-cancel">Annulla</button>
                <button type="button" class="btn-modal-confirm">Conferma</button>
            </div>
        </div>
        <!-- AREA "I MIEI DATI" -->
        <div class="personal-details">
            <h3>I MIEI DATI</h3>
            <br>
            <span class="label-dati"><strong>Nome</strong>:</span> <p><?php echo htmlspecialchars($utente['nome']); ?></p>
            <span class="label-dati"><strong>Cognome</strong>:</span> <p><?php echo htmlspecialchars($utente['cognome']); ?></p>
            <span class="label-dati"><strong>Username</strong>:</span> <p><?php echo htmlspecialchars($utente['username']); ?></p>
            <span class="label-dati"><strong>E-mail</strong>:</span> <p><?php echo htmlspecialchars($utente['email']); ?></p>
        </div>
        <aside>
            <!-- DASHBOARD CON PRENOTAZIONI E PREFERITI DELL'UTENTE -->
            <div class="user-dashboard">
                <h3>DASHBOARD</h3>
                <a href="prenotazioni.php">LE MIE PRENOTAZIONI</a>
                <a href="preferiti.php">I MIEI PREFERITI</a>
            </div>

            <!-- AZIONI POSSIBILI DELL'UTENTE: LOGOUT O ELIMINA ACCOUNT -->
            <div class="user-action">
                <form action="logout.php">
                    <button type="submit" class="logout">Logout</button>
                </form>
                <form id="form-elimina" action="elimina_account.php" method="POST">
                    <button type="button" class="elimina-account">Elimina Account</button>
                </form>
            </div>
        </aside>
    </main>

    <?php include '../templates/footer.php'; ?>
    <script src="../js/area-personale.js"></script>
</body>
</html>