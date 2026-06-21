<?php
include 'connect.php';
define('UPLPATH', 'img/');

$dozvoljene_kategorije = ['mundo', 'deporte'];
$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';

if (!in_array($kategorija, $dozvoljene_kategorije)) {
    $kategorija = 'mundo'; 
}

$aktivna = $kategorija; 
$naslov_stranice = ucfirst($kategorija);
include 'header.php';
?>

<main>
    <section class="kategorija">
        <h2 class="section-title"><?php echo htmlspecialchars(ucfirst($kategorija)); ?></h2>
        <div class="articles-row">
            <?php
            $sql = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija=? ORDER BY id DESC";
            $stmt = mysqli_stmt_init($dbc);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 's', $kategorija);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<article class="clanak-kratki">';
                        echo '  <div class="thumb">';
                        echo '      <img src="' . UPLPATH . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                        echo '  </div>';
                        echo '  <div class="kategorija-label">' . htmlspecialchars($row['kategorija']) . '</div>';
                        echo '  <h3><a href="clanak.php?id=' . (int)$row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a></h3>';
                        echo '  <div class="meta">' . htmlspecialchars($row['datum']) . '</div>';
                        echo '</article>';
                    }
                } else {
                    echo '<p>Trenutno nema vijesti u ovoj kategoriji.</p>';
                }
                mysqli_stmt_close($stmt);
            }
            ?>
        </div>
    </section>
</main>

<?php
mysqli_close($dbc);
include 'footer.php';
?>
