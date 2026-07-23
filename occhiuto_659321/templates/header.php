<?php
// --- DICHIARAZIONE VARIABILI GLOBALI PER I PATH ---
global $path_prefix, $home_prefix;
?>
<header>
    <nav>
        <h1 class="logo">CiakSiGira</h1>
        <div class="navbar">
        <?php
            // --- RECUPERO NOME DEL FILE CORRENTE PER LA NAVIGAZIONE ---
            $current_page = basename($_SERVER['PHP_SELF']);

            // --- GESTIONE HOME-BUTTON SE NON SIAMO NELLA HOME ---
            if ($current_page !== 'index.php') {
                echo '<a href="' . $home_prefix . 'index.php" class="back-home-link">Home</a>';
            }
            ?>
            <a href="<?php echo $path_prefix;?>programmazione.php">Programmazione</a>
            <a href="<?php echo $path_prefix;?>prossimamente.php">Prossimamente</a>
            
            <?php
            // --- GESTIONE DINAMICA DEL MENU: "IL MIO PROFILO" SE LOGGATO, ALTRIMENTI "ACCEDI/REGISTRATI" ---
            if (isset($_SESSION['username'])): ?>
                <a href="<?php echo $path_prefix;?>area-personale.php">Il mio profilo</a>
            <?php else: ?>
                <a href="<?php echo $path_prefix;?>login.php">Accedi/Registrati</a>
            <?php endif; ?>
        </div>
    </nav>
</header>