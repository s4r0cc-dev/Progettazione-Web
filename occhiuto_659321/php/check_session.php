<?php
// --- AVVIA/RIPRENDE LA SESSIONE CORRENTE IN BASE AL COOKIE DEL BROWSER ---
session_start();

// --- COMUNICA CHE IL CONTENUTO E' JSON ---
header('Content-Type: application/json');

// --- VERIFICA SE L'UTENTE E' AUTENTICATO ---
if (isset($_SESSION['id_utente'])) {
    echo json_encode(["logged_in" => true]);
} else {
    echo json_encode(["logged_in" => false]);
}
exit();
?>