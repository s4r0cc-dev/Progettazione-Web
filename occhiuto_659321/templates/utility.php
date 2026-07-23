<?php
// --- FUNZIONE CENTRALIZZATA PER GENERARE LA STRUTTURA DELLE PAGINE INFORMATIVE ---
function renderInformationalPage($titolo, $immagine, $testo) {
    // --- SFRUTTO I PATH CALCOLATI IN CONFIG.PHP ---
    global $home_prefix;
    ?>
    <!-- STANDARD HTML PER LE PAGINE DEL FOOTER -->
    <!DOCTYPE html>
    <html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CiakSiGira - <?php echo htmlspecialchars($titolo); ?></title>
        <link rel="icon" href="<?php echo $home_prefix; ?>icona.ico">
        <link rel="stylesheet" href="<?php echo $home_prefix; ?>css/global.css">
        <link rel="stylesheet" href="<?php echo $home_prefix; ?>css/header.css">
        <link rel="stylesheet" href="<?php echo $home_prefix; ?>css/footer.css">
        <link rel="stylesheet" href="<?php echo $home_prefix; ?>css/footer-pages.css">
    </head>
    <body>
        <?php include '../templates/header.php'; ?>

        <h2 class="titolo"><?php echo htmlspecialchars($titolo); ?></h2>
        <main class="content-page">
            <img src="<?php echo htmlspecialchars($immagine); ?>" alt="<?php echo htmlspecialchars($titolo); ?>">
            <div class="paragrafo">
                <?php echo $testo; ?>
            </div>
        </main>
        <?php include '../templates/footer.php'; ?>
    </body>
    </html>
    <?php
}
?>