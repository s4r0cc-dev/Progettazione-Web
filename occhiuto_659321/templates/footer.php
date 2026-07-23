<?php
// --- DICHIARAZIONE VARIABILI GLOBALI PER I PATH ---
// $path_prefix viene usato per i file PHP, $home_prefix per le risorse radice, 
// e $html_prefix per le guide statiche.
global $path_prefix, $home_prefix, $html_prefix;
?>
<footer>
    <div class="grid-container">
        <section id="ciaksigira">
            <h3>CiakSiGira</h3>
            <p>La tua web app per prenotare i tuoi film preferiti.</p>
        </section>

        <section id="informazioni">
            <h3>Informazioni</h3>
            <ul>
                <li><a href="<?php echo $path_prefix; ?>chi-siamo.php">Chi siamo?</a></li>
                <li><a href="<?php echo $path_prefix; ?>termini-e-condizioni.php">Termini e condizioni</a></li>
                <li><a href="<?php echo $path_prefix; ?>privacy-policy.php">Privacy policy</a></li>
                <li><a href="<?php echo $path_prefix; ?>cookie-policy.php">Cookie policy</a></li>
            </ul>
        </section>

        <section id="assistenza">
            <h3>Assistenza</h3>
            <ul>
                <li><a href="<?php echo $path_prefix; ?>FAQ.php">FAQ</a></li>
                <li><a href="<?php echo $path_prefix; ?>contattaci.php">Contattaci</a></li>
                <li><a href="<?php echo $html_prefix; ?>guida-utente.html">Guida utente</a></li>
            </ul>
        </section>
    </div>
    <div class="footer-bottom">
        <p>CiakSiGira &copy; 2026 Tutti i diritti riservati</p>
        <p>P.IVA: 123456789, Sede legale: Piazzale Arnaldo, 2 - 25121 Brescia</p>
    </div>
</footer>
