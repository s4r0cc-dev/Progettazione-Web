<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

$step = 1;
$username = '';
$domanda_sicurezza = '';
$errore = '';
$successo = '';

// --- MAPPATURA DELLE CHIAVI INTERNE AL DB CON DOMANDE LEGGIBILI A SCHERMO ---
$domande_mappate = [
    'squadra_cuore' => 'Qual è la tua squadra del cuore?',
    'nome_animale' => 'Come si chiama il tuo primo animale domestico?',
    'citta_nascita' => 'In quale città sei nato/a?',
    'colore_preferito' => 'Qual è il tuo colore preferito?'
];

// --- GESTIONE FASE 1: INSERIMENTO USERNAME PER RECUPERO DOMANDA DI SICUREZZA ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fase_username'])) {
    $username = trim($_POST['username']);
    
    if (empty($username)) {
        $errore = "Inserisci il tuo username.";
    } else {
        // --- PREPARED STATEMENT PER RECUPERO DELLA DOMANDA DI SICUREZZA ---
        $stmt = $conn->prepare("SELECT domanda_sicurezza FROM utenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            
            $chiave_domanda = $row['domanda_sicurezza'];
            $domanda_sicurezza = isset($domande_mappate[$chiave_domanda]) ? $domande_mappate[$chiave_domanda] : $chiave_domanda;
            
            $step = 2; // --- FASE DUE --- 
        } else {
            $errore = "Username non trovato nel sistema.";
        }
    }
}

// --- GESTIONE FASE 2: RISPOSTA ALLA DOMANDA E IMPOSTAZIONE NUOVA PASSWORD ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fase_recupero'])) {
    $username = trim($_POST['username']);
    $risposta_utente = trim($_POST['risposta_sicurezza']);
    $nuova_password = $_POST['nuova_password'];
    $conferma_password = $_POST['conferma_password'];
    
    // --- RECUPERO LA DOMANDA PER NON PERDERLA IN CASO DI ERRORE ---
    $stmt = $conn->prepare("SELECT domanda_sicurezza, risposta_sicurezza FROM utenti WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $utente = $result->fetch_assoc();
    
    $domanda_sicurezza = $domande_mappate[$utente['domanda_sicurezza']];
    $step = 2; // --- RESTA NELLA FASE DUE FINCHE' NON E' TUTTO CORRETTO ---
    $risposta_pulita = strtolower(trim($risposta_utente));

    // --- CHECK DEI CAMPI: RISPOSTA, PASSWORD, CONFERMA PASSWORD ---
    if (empty($risposta_utente) || empty($nuova_password) || empty($conferma_password)) {
        $errore = "Tutti i campi sono obbligatori.";
    } elseif ($nuova_password !== $conferma_password) {
        $errore = "Le due password non coincidono.";
    } elseif (!password_verify($risposta_pulita, $utente['risposta_sicurezza'])) { 
        $errore = "Risposta di sicurezza errata.";
    } else {
        $password_hash = password_hash($nuova_password, PASSWORD_BCRYPT);
        
        $update = $conn->prepare("UPDATE utenti SET password = ? WHERE username = ?");
        $update->bind_param("ss", $password_hash, $username);
        
        if ($update->execute()) {
            $successo = "Password reimpostata con successo! Verrai reindirizzato al login...";
            $step = 3;
            header("refresh:3;url=login.php");
        } else {
            $errore = "Errore durante il salvataggio. Riprova più tardi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiakSiGira - Recupero Password</title>
    <link rel="icon" href="icona.ico">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/recupero_password.css"> 
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main>
        <h2 class="titolo">RECUPERO PASSWORD</h2>
        <div class="recupero-container">
            <?php if (!empty($errore)): ?>
                <div class="alert-errore"><?php echo $errore; ?></div>
            <?php endif; ?>

            <?php if (!empty($successo)): ?>
                <div class="alert-successo"><?php echo $successo; ?></div>
            <?php endif; ?>

            <?php if ($step === 1): ?>
                <form action="recupero_password.php" method="POST">
                    <input type="hidden" name="fase_username" value="1">
                    <div class="form-group">
                        <label for="username">Inserisci il tuo Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>
                    <button type="submit" class="btn-recupero">Verifica Account</button>
                </form>
            <?php endif; ?>

            <?php if ($step === 2): ?>
                <form action="recupero_password.php" method="POST">
                    <input type="hidden" name="fase_recupero" value="1">
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">

                    <div class="form-group">
                        <label>Domanda di sicurezza del tuo account:</label>
                        <p style="color: var(--keyword-color); font-size: 18px; font-weight: bold; margin: 5px 0;">
                            <?php echo htmlspecialchars($domanda_sicurezza); ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="risposta_sicurezza">La tua risposta:</label>
                        <input type="text" id="risposta_sicurezza" name="risposta_sicurezza" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="nuova_password">Nuova Password:</label>
                        <input type="password" id="nuova_password" name="nuova_password" required>
                    </div>

                    <div class="form-group">
                        <label for="conferma_password">Conferma Nuova Password:</label>
                        <input type="password" id="conferma_password" name="conferma_password" required>
                    </div>

                    <button type="submit" class="btn-recupero">Aggiorna Password</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>