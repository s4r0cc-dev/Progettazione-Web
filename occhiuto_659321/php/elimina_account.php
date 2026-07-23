<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

// --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
if (!isset($_SESSION['id_utente'])) {
    header("Location: login.php");
    exit();
}

$id_utente = $_SESSION['id_utente'];

// --- ELIMINAZIONE DELL'UTENTE DAL DB ---
$stmt = $conn->prepare("DELETE FROM utenti WHERE id_utente = ?");
$stmt->bind_param("i", $id_utente);

// --- SUCCESSO: REINDIRIZZA ALLA HOME ---
if ($stmt->execute()) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
} else {
    // --- ERRORE ---
    header("Location: area_personale.php?error=eliminazione_fallita");
}
exit();
?>