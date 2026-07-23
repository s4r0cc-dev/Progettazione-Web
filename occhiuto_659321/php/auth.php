<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once '../php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    
    // --- 1. LOGICA REGISTRAZIONE UTENTE ---
    if ($_POST['action'] === 'registrati') {
        $email = $_POST['email'];
        $username = $_POST['username']; 

        // --- PREPARED STATEMENT PER VERIFICARE L'ESISTENZA DI EMAIL O USERNAME ---
        $check = $conn->prepare("SELECT id_utente FROM utenti WHERE email = ? OR username = ?");
        $check->bind_param("ss", $email, $username);
        $check->execute();
        
        // --- SE L'UTENTE ESISTE GIÀ, REINDIRIZZA CON UN MESSAGGIO DI ERRORE ---
        if ($check->get_result()->num_rows > 0) {
            header("Location: ../php/login.php?error=user_exists");
            exit();
        }

        // --- HASHING DELLA PASSWORD E NORMALIZZAZIONE DELLA RISPOSTA DI SICUREZZA ---
        // --- password_hash garantisce che la password non sia salvata in chiaro nel DB ---
        $hash_password = password_hash($_POST['reg-password'], PASSWORD_BCRYPT);
        $risposta_pulita = strtolower(trim($_POST['risposta-sicurezza']));
        $hash_risposta = password_hash($risposta_pulita, PASSWORD_BCRYPT);
        
        // --- INSERIMENTO DEI DATI UTENTE TRAMITE PREPARED STATEMENT PER SICUREZZA SQL ---
        $stmt = $conn->prepare("INSERT INTO utenti (nome, cognome, username, email, password, domanda_sicurezza, risposta_sicurezza) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $_POST['reg-nome'], $_POST['reg-cognome'], $username, $email, $hash_password, $_POST['domanda-sicurezza'], $hash_risposta);
        
        // --- ESECUZIONE DELLA QUERY E GESTIONE DEGLI ESITI ---
        if ($stmt->execute()) {
            header("Location: ../php/login.php?success_reg=1");
        } else {
            header("Location: ../php/login.php?error=db_error");
        }
        exit();
    }

    // --- 2. LOGICA LOGIN UTENTE ---
    if ($_POST['action'] === 'login') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // --- RECUPERO DELL'HASH DAL DATABASE PER L'UTENTE SPECIFICATO ---
        $stmt = $conn->prepare("SELECT id_utente, password FROM utenti WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // --- VERIFICA ESISTENZA UTENTE E CORRISPONDENZA PASSWORD ---
        if ($result->num_rows === 1) {
            $utente = $result->fetch_assoc();

            // --- CHECK DELLA PASSWORD DEL FORM CON L'HASHING NEL DB ---
            // --- password_verify gestisce in modo sicuro il confronto dell'hash ---
            if (password_verify($password, $utente['password'])) {
                $_SESSION['id_utente'] = $utente['id_utente'];
                $_SESSION['username'] = $username;
                header("Location: ../index.php");
                exit();
            }
        }
        // --- REINDIRIZZAMENTO IN CASO DI CREDENZIALI NON VALIDE ---
        header("Location: ../php/login.php?error=invalid_creds");
        exit();
    }
}
?>