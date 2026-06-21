<?php
include 'connect.php';
define('UPLPATH', 'img/');
$aktivna = 'home';
$naslov_stranice = 'Naslovnica';
include 'header.php';
?>

<main>

    <!-- ===================== MUNDO ===================== -->
    <section class="kategorija mundo">
        <h2 class="section-title">Mundo</h2>
        <div class="articles-row">
            <?php
            $query = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='mundo' ORDER BY id DESC LIMIT 4";
            $result = mysqli_query($dbc, $query);

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
            ?>
        </div>
        <hr class="divider">
    </section>

    <!-- ===================== DEPORTE ===================== -->
    <section class="kategorija deporte">
        <h2 class="section-title">Deporte</h2>
        <div class="articles-row">
            <?php
            $query2 = "SELECT * FROM vijesti WHERE arhiva=0 AND kategorija='deporte' ORDER BY id DESC LIMIT 4";
            $result2 = mysqli_query($dbc, $query2);

            while ($row = mysqli_fetch_array($result2)) {
                echo '<article class="clanak-kratki">';
                echo '  <div class="thumb">';
                echo '      <img src="' . UPLPATH . htmlspecialchars($row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '">';
                echo '  </div>';
                echo '  <div class="kategorija-label">' . htmlspecialchars($row['kategorija']) . '</div>';
                echo '  <h3><a href="clanak.php?id=' . (int)$row['id'] . '">' . htmlspecialchars($row['naslov']) . '</a></h3>';
                echo '  <div class="meta">' . htmlspecialchars($row['datum']) . '</div>';
                echo '</article>';
            }
            ?>
        </div>
        <hr class="divider">
    </section>

</main>

<?php
mysqli_close($dbc);
include 'footer.php';
?>
