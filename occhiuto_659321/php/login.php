<?php 
// --- INCLUSIONE FILE DI CONFIGURAZIONE PER LA CONNESSIONE AL DATABASE ---
require_once 'config.php';
    
// --- CHECK UTENTE LOGGATO: SE GIA' LOGGATO, REINDIRIZZATO ALL'AREA PERSONALE ---
if(isset($_SESSION['username']))
    header('Location: ../php/area-personale.php');
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CiakSiGira - Autenticazione</title>
        <link rel="icon" href="../icona.ico">
        <link rel="stylesheet" href="../css/global.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <?php include '../templates/header.php';?>
        <main class="content-page">
            <div class="modal-overlay" id="nascosto"></div>
            
            <!-- SEZIONE ACCEDI -->
            <section class="login-section">
                <h2 class="titolo">ACCEDI</h2>
                <form action="../php/auth.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <!-- USERNAME: PRIMA LETTERA MAIUSCOLA, SUCCESSIVE MINUSCOLE O NUMERI -->
                        <input type="text" name="username" id="username" placeholder="Username" 
                            pattern="^(?=.*[0-9])[A-Z][a-z0-9]{5,7}$" 
                            title="L'username deve essere lungo tra 6 e 8 caratteri, iniziare con una maiuscola, seguita da minuscole o numeri" 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <!-- PASSWORD FORTE: ALMENO UNA MAIUSCOLA, ALMENO UNA MINUSCOLA, ALMENO UN NUMERO, ALMENO UN CARATTERE SPECIALE -->
                        <input type="password" name="password" id="password" placeholder="Password" 
                        title="La password deve avere una lunghezza compresa tra 8 e 12 caratteri e contenere almeno una maiuscola, una minuscola, un numero e un carattere speciale."
                        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,12}$" required>
                    </div>
                    <div class="submit-area">
                        <button type="submit" id="accedi" name="action" value="login">Accedi</button>
                        <a href="recupero_password.php">Password dimenticata?</a>
                    </div>
                    <div id="login-msg"></div>
                </form>
            </section>
            <!-- SEZIONE REGISTRAZIONE -->
            <section class="registrazione-section">
            <h2 class="titolo">REGISTRAZIONE</h2>
                <form action="../php/auth.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="reg-nome">Nome</label>
                        <input type="text" name="reg-nome" id="reg-nome" placeholder="Nome" pattern="^[A-Z][a-z]+$" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-cognome">Cognome</label>
                        <input type="text" name="reg-cognome" id="reg-cognome" placeholder="Cognome" pattern="^[A-Z][a-z]+$" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="reg-username" placeholder="Username" 
                            pattern="^(?=.*[0-9])[A-Z][a-z0-9]{5,7}$" 
                            title="L'username deve essere lungo tra 6 e 8 caratteri, iniziare con una maiuscola, seguita da minuscole o numeri, con almeno una cifra totale." 
                            required>
                    </div>
                    <div class="form-group">
                        <label for="reg-email">E-mail</label>
                        <input type="text" name="email" id="reg-email" placeholder="E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-password">Password</label>
                        <input type="password" name="reg-password" id="reg-password" placeholder="Password" 
                        title="La password deve avere una lunghezza compresa tra 8 e 12 caratteri e contenere almeno una maiuscola, una minuscola, un numero e un carattere speciale."
                        pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*]).{8,12}$" required>
                    </div>
                    <div class="form-group">
                        <label for="domanda-sicurezza">Domanda di sicurezza</label>
                        <select name="domanda-sicurezza" id="domanda-sicurezza" required>
                            <option value="">Seleziona una domanda...</option>
                            <option value="citta_nascita">In che città sei nato?</option>
                            <option value="nome_animale">Come si chiamava il tuo primo animale domestico?</option>
                            <option value="scuola_elementare">Qual è il nome della tua prima scuola elementare?</option>
                            <option value="squadra_cuore">Qual è la tua squadra del cuore?</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="risposta-sicurezza">Risposta</label>
                        <input type="text" name="risposta-sicurezza" id="risposta-sicurezza" placeholder="La tua risposta" required>
                    </div>
                    <div class="submit-area">
                        <button type="submit" name="action" value="registrati">Registrati</button>
                    </div>
                    <div id="reg-msg" class="nascosto"></div>
                </form>
            </section>
        </main>
        <?php include '../templates/footer.php';?>
        <script src="../js/utility.js"></script>
        <script src="../js/login.js"></script>
    </body>
</html>