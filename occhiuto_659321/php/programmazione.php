<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CiakSiGira - Programmazione</title>
        <link rel="icon" href="../icona.ico">
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/programmazione.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>
    <body>
        <?php include '../templates/header.php';?>
        <main>
            <h2 class="titolo">PROGRAMMAZIONE</h2>
            <div class="content-page"></div>
        </main>
        <?php include '../templates/footer.php';?>
        <script src="../js/programmazione.js"></script>
    </body>
</html>