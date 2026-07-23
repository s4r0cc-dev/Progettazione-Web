<?php
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CiakSiGira - Preferiti</title>
        <link rel="icon" href="../icona.ico">
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/preferiti.css">
    </head>
    <body>
        <?php include '../templates/header.php';?>
        <main>
            <h2 class="titolo">PREFERITI</h2>
            <div class="container-preferiti">
                <div id="lista-preferiti" class="lista-preferiti"></div>
            </div>
        </main>
        <?php include '../templates/footer.php';?>
        <script src="../js/preferiti.js"></script>
    </body>
</html>