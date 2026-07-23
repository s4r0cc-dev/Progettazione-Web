<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
header('Content-Type: application/json');

// --- 1. VERIFICA AUTENTICAZIONE: ACCESSO CONSENTITO SOLO A UTENTI LOGGATI ---
if (!isset($_SESSION['id_utente'])) {
    http_response_code(401);
    exit(json_encode(["error" => "Non autorizzato"]));
}

$id_utente = $_SESSION['id_utente'];

// --- 1. GET: RECUPERA I POSTI GIA' PRENOTATI PER QUESTA PROIEZIONE --- 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['id_proiezione'])) {
        http_response_code(400);
        exit(json_encode(["error" => "ID proiezione mancante"]));
    }
    
    $id_proiezione = $_GET['id_proiezione'];
    $stmt = $conn->prepare("SELECT posto FROM prenotazioni WHERE id_proiezione = ?");
    $stmt->bind_param("i", $id_proiezione);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // --- CREAZIONE ARRAY POSTI OCCUPATI ---
    $posti_occupati = [];
    while ($row = $result->fetch_assoc()) {
        $posti_occupati[] = $row['posto'];
    }
    
    echo json_encode($posti_occupati);
    exit();
}

// --- 2. POST: INSERISCE NUOVE PRENOTAZIONI NEL DB ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($input['id_proiezione']) || !isset($input['posti']) || empty($input['posti'])) {
        http_response_code(400);
        exit(json_encode(["error" => "Dati incompleti"]));
    }
    
    $id_proiezione = $input['id_proiezione'];
    $posti = $input['posti']; // Array di stringhe (es. ['A1', 'A2'])

    // --- TRANSAZIONE AVVIATA PER EVITARE SALVATAGGI PARZIALI/PRENOTAZIONI CONTEMPORANEE ---
    $conn->begin_transaction();
    try {
        foreach ($posti as $posto) {
            // --- CHECK PREVENTIVO PER VERIFICARE CHE IL POSTO SIA ANCORA LIBERO ---
            $check = $conn->prepare("SELECT id_prenotazione FROM prenotazioni WHERE id_proiezione = ? AND posto = ?");
            $check->bind_param("is", $id_proiezione, $posto);
            $check->execute();
            if ($check->get_result()->num_rows > 0) {
                throw new Exception("Il posto $posto è già stato occupato.");
            }

            // --- INSERIMENTO DELLA NUOVA PRENOTAZIONE ---
            $stmt = $conn->prepare("INSERT INTO prenotazioni (id_utente, id_proiezione, posto) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $id_utente, $id_proiezione, $posto);
            $stmt->execute();
        }
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // --- IN CASO DI ECCEZIONE, CANCELLA L'OPERAZIONE: O VIENE COMPLETATA TUTTA O VIENE ANNULLATA ---
        $conn->rollback();
        http_response_code(409);
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}
// --- 3. DELETE: RIMUOVE LA SINGOLA PRENOTAZIONE ---
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // --- DATI INVIATI NEL CORPO DELLA RICHIESTA ---
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (!isset($input['id_proiezione']) || !isset($input['posto'])) {
        http_response_code(400);
        exit(json_encode(["error" => "Dati incompleti per la cancellazione"]));
    }

    $id_proiezione = $input['id_proiezione'];
    $posto = $input['posto'];

    // --- ESEGUE L'ELIMINAZIONE ASSICURANDOSI CHE IL POSTO APPARTENGA ALL'UTENTE LOGGATO ---
    $stmt = $conn->prepare("DELETE FROM prenotazioni WHERE id_utente = ? AND id_proiezione = ? AND posto = ?");
    $stmt->bind_param("iis", $id_utente, $id_proiezione, $posto);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Prenotazione annullata"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Prenotazione non trovata o non autorizzata"]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Errore durante l'eliminazione"]);
    }
    exit();
}
?>