<?php
// --- 1. AVVIO/RECUPERO DELLA SESSIONE CORRENTE ---
// --- 2. RIMOZIONE DELLE VARIABILI DI SESSIONE (svuota $_SESSION) ---
// --- 3. DISTRUZIONE DELLA SESSIONE ---
// --- 4. REINDIRIZZAMENTO ---
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
exit();
?>