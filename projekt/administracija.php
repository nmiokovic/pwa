<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$uspjesnaPrijava = false;
$admin = false;


if (isset($_POST['prijava'])) {

    $prijavaImeKorisnika    = trim($_POST['username']);
    $prijavaLozinkaKorisnika = $_POST['lozinka'];

    $sql = "SELECT korisnicko_ime, lozinka, razina, ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $prijavaImeKorisnika);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $imeKorisnika, $lozinkaKorisnika, $levelKorisnika, $pravoIme);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_fetch($stmt);

            if (password_verify($prijavaLozinkaKorisnika, $lozinkaKorisnika)) {
                $uspjesnaPrijava = true;
                $admin = ((int)$levelKorisnika === 1);

                
                $_SESSION['username'] = $imeKorisnika;
                $_SESSION['ime']      = $pravoIme;
                $_SESSION['level']    = $levelKorisnika;
            } else {
                $uspjesnaPrijava = false;
            }
        } else {
            $uspjesnaPrijava = false;
        }
        mysqli_stmt_close($stmt);
    }
}


$prijavljen = isset($_SESSION['username']);
$jeAdmin = $prijavljen && (int)$_SESSION['level'] === 1;


if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: administracija.php');
    exit;
}


if ($jeAdmin && isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    $sql = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}


if ($jeAdmin && isset($_POST['update'])) {
    $id       = (int)$_POST['id'];
    $title    = trim($_POST['title']);
    $about    = trim($_POST['about']);
    $content  = trim($_POST['content']);
    $category = $_POST['category'];
    $archive  = isset($_POST['archive']) ? 1 : 0;

    
    $picture = trim($_POST['old_picture']);
    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === UPLOAD_ERR_OK && $_FILES['pphoto']['name'] !== '') {
        $picture = basename($_FILES['pphoto']['name']);
        move_uploaded_file($_FILES['pphoto']['tmp_name'], 'img/' . $picture);
    }

    $sql = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssssii', $title, $about, $content, $picture, $category, $archive, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$aktivna = 'admin';
$naslov_stranice = 'Administracija';
include 'header.php';
?>

<main>

<?php if ($jeAdmin): ?>

    
    <div class="form-wrapper" style="max-width:900px;">
        <h1>Administracija vijesti</h1>
        <p>Prijavljeni ste kao: <strong><?php echo htmlspecialchars($_SESSION['ime']); ?></strong>
            &middot; <a href="administracija.php?logout=1" style="color:#c0392b;">Odjava</a></p>
    </div>

    <?php
    $query = "SELECT * FROM vijesti ORDER BY id DESC";
    $result = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="admin-block">';
        echo '<form enctype="multipart/form-data" action="administracija.php" method="POST">';

        echo '  <div class="form-item">
                    <label for="title">Naslov vijesti:</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual" value="' . htmlspecialchars($row['naslov']) . '">
                    </div>
                </div>';

        echo '  <div class="form-item">
                    <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
                    <div class="form-field">
                        <textarea name="about" cols="30" rows="2" class="form-field-textual">' . htmlspecialchars($row['sazetak']) . '</textarea>
                    </div>
                </div>';

        echo '  <div class="form-item">
                    <label for="content">Sadržaj vijesti:</label>
                    <div class="form-field">
                        <textarea name="content" cols="30" rows="6" class="form-field-textual">' . htmlspecialchars($row['tekst']) . '</textarea>
                    </div>
                </div>';

        echo '  <div class="form-item">
                    <label for="pphoto">Slika (ostavi prazno za zadržavanje postojeće):</label>
                    <div class="form-field">
                        <input type="file" class="input-text" name="pphoto">
                        <br><img class="thumb-preview" src="' . UPLPATH . htmlspecialchars($row['slika']) . '" width="120">
                    </div>
                </div>';

        $sport_sel  = $row['kategorija'] === 'mundo' ? 'selected' : '';
        $kultura_sel = $row['kategorija'] === 'deporte' ? 'selected' : '';

        echo '  <div class="form-item">
                    <label for="category">Kategorija vijesti:</label>
                    <div class="form-field">
                        <select name="category" class="form-field-textual">
                            <option value="mundo" ' . $sport_sel . '>Mundo</option>
                            <option value="deporte" ' . $kultura_sel . '>Deporte</option>
                        </select>
                    </div>
                </div>';

        echo '  <div class="form-item">
                    <label>';
        if ((int)$row['arhiva'] === 0) {
            echo '<input type="checkbox" name="archive"> Arhiviraj?';
        } else {
            echo '<input type="checkbox" name="archive" checked> Arhiviraj?';
        }
        echo '      </label>
                </div>';

        echo '  <input type="hidden" name="id" value="' . (int)$row['id'] . '">';
        echo '  <input type="hidden" name="old_picture" value="' . htmlspecialchars($row['slika']) . '">';

        echo '  <div class="form-item">
                    <button type="submit" name="update" value="Prihvati">Izmjeni</button>
                    <button type="submit" name="delete" value="Izbriši" onclick="return confirm(\'Sigurno želiš obrisati ovu vijest?\');">Izbriši</button>
                </div>';

        echo '</form>';
        echo '</div>';
    }
    ?>

<?php elseif ($prijavljen && !$jeAdmin): ?>

  
    <div class="form-wrapper">
        <p>Bok, <strong><?php echo htmlspecialchars($_SESSION['ime']); ?></strong>!
            Uspješno ste prijavljeni, ali nemate dovoljna prava za pristup ovoj stranici.</p>
        <p style="margin-top:10px;"><a href="administracija.php?logout=1" style="color:#1859b5;">Odjava</a></p>
    </div>

<?php elseif (isset($_POST['prijava']) && !$uspjesnaPrijava): ?>

   
    <div class="form-wrapper">
        <p class="bojaPoruke">Pogrešno korisničko ime ili lozinka, ili se morate prvo registrirati.</p>
        <p style="margin-top:10px;"><a href="registracija.php" style="color:#1859b5;">Registriraj se &rarr;</a></p>
    </div>

    <?php include 'login_forma.php'; ?>

<?php else: ?>

    <div class="form-wrapper">
        <p>Za pristup administraciji potrebno je prijaviti se.
           Nemaš račun? <a href="registracija.php" style="color:#1859b5;">Registriraj se</a></p>
    </div>

    <?php include 'login_forma.php'; ?>

<?php endif; ?>

</main>

<?php
mysqli_close($dbc);
include 'footer.php';
?>
