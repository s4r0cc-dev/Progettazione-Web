<?php
// --- AVVIO DELLA SESSIONE ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- CONFIGURAZIONE DB ---
$host = 'localhost';
$db   = 'occhiuto_659321';
$user = 'root'; 
$pass = '';  
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

// --- GESTIONE DEI PATH ---
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
if ($current_dir === 'php') {
    $path_prefix = "";
    $home_prefix = "../"; 
    $html_prefix = "../html/"; 
} else {
    $path_prefix = "php/";
    $home_prefix = "";
    $html_prefix = "html/";
}
?>