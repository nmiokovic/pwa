<?php
include 'connect.php';

$msg = '';
$registriranKorisnik = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ime      = trim($_POST['ime']);
    $prezime  = trim($_POST['prezime']);
    $username = trim($_POST['username']);
    $lozinka  = $_POST['pass'];
    $lozinkaRep = $_POST['passRep'];

    if ($ime === '' || $prezime === '' || $username === '' || $lozinka === '') {
        $msg = 'Sva polja su obavezna!';
    } elseif ($lozinka !== $lozinkaRep) {
        $msg = 'Lozinke se ne podudaraju!';
    } else {


        $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $msg = 'Korisničko ime već postoji!';
            } else {
                mysqli_stmt_close($stmt);


                $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);
                $razina = 0; // svi novi korisnici su obični korisnici

                $sql2 = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina)
                         VALUES (?, ?, ?, ?, ?)";
                $stmt2 = mysqli_stmt_init($dbc);

                if (mysqli_stmt_prepare($stmt2, $sql2)) {
                    mysqli_stmt_bind_param($stmt2, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                    if (mysqli_stmt_execute($stmt2)) {
                        $registriranKorisnik = true;
                    } else {
                        $msg = 'Dogodila se pogreška prilikom registracije.';
                    }
                    mysqli_stmt_close($stmt2);
                }
            }
        }
    }
}

mysqli_close($dbc);

$aktivna = '';
$naslov_stranice = 'Registracija';
include 'header.php';
?>

<main>
<?php if ($registriranKorisnik): ?>

    <div class="form-wrapper">
        <p class="poruka-uspjeh">Korisnik je uspješno registriran!</p>
        <p style="margin-top:15px;"><a href="administracija.php" style="color:#1859b5;">Prijavi se &rarr;</a></p>
    </div>

<?php else: ?>

    <div class="form-wrapper">
        <h1>Registracija korisnika</h1>

        <?php if ($msg): ?>
            <p class="bojaPoruke" style="margin-bottom:15px;"><?php echo htmlspecialchars($msg); ?></p>
        <?php endif; ?>

        <form action="registracija.php" method="POST">

            <div class="form-item">
                <label for="ime">Ime:</label>
                <div class="form-field">
                    <input type="text" name="ime" id="ime" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="prezime">Prezime:</label>
                <div class="form-field">
                    <input type="text" name="prezime" id="prezime" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="username">Korisničko ime:</label>
                <div class="form-field">
                    <input type="text" name="username" id="username" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="pass">Lozinka:</label>
                <div class="form-field">
                    <input type="password" name="pass" id="pass" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="passRep">Ponovite lozinku:</label>
                <div class="form-field">
                    <input type="password" name="passRep" id="passRep" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <button type="submit">Registriraj se</button>
            </div>

        </form>
    </div>

<?php endif; ?>
</main>

<?php include 'footer.php'; ?>
