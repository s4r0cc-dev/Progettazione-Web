<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';

// --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
if (!isset($_SESSION['id_utente'])) {
    echo "Devi prima fare l'accesso";
    exit();
}

$id_utente = $_SESSION['id_utente'];

// --- GET: RECUPERA I FILM PREFERITI DALL'UTENTE ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare("SELECT f.id_film, f.titolo, f.genere, f.durata, f.trama, f.stato 
                            FROM preferiti p JOIN film f ON p.id_film = f.id_film 
                            WHERE p.id_utente = ?");
    $stmt->bind_param("i", $id_utente);
    $stmt->execute();
    echo json_encode($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
}

// --- POST: AGGIUNGE UN NUOVO FILM PREFERITO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_film = $_POST['id_film'];
    
    // --- CHECK SE IL FILM E' GIA' TRA I PREFERITI ---
    $check = $conn->prepare("SELECT * FROM preferiti WHERE id_utente = ? AND id_film = ?");
    $check->bind_param("is", $id_utente, $id_film);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        echo "Già presente";
    } else {
        $stmt = $conn->prepare("INSERT INTO preferiti (id_utente, id_film) VALUES (?, ?)");
        $stmt->bind_param("is", $id_utente, $id_film);
        $stmt->execute();
        echo "Aggiunto";
    }
}

// --- DELETE: RIMUOVE UN FILM DAI PREFERITI ---
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $id_film = $data['id_film'];
    $stmt = $conn->prepare("DELETE FROM preferiti WHERE id_utente = ? AND id_film = ?");
    $stmt->bind_param("is", $id_utente, $id_film);
    $stmt->execute();
}
?>