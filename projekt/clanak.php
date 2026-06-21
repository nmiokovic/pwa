<?php
include 'connect.php';
define('UPLPATH', 'img/');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM vijesti WHERE id = ?";
$stmt = mysqli_stmt_init($dbc);
$row = null;

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    mysqli_stmt_close($stmt);
}

$aktivna = isset($row['kategorija']) ? $row['kategorija'] : '';
$naslov_stranice = $row ? $row['naslov'] : 'Članak nije pronađen';
include 'header.php';
?>

<main>
<?php if ($row): ?>

    <section class="clanak-header">
        <p class="category"><span><?php echo htmlspecialchars(ucfirst($row['kategorija'])); ?></span></p>
        <h1 class="title"><?php echo htmlspecialchars($row['naslov']); ?></h1>
        <p class="about"><i><?php echo htmlspecialchars($row['sazetak']); ?></i></p>
        <p class="autor-info">OBJAVLJENO: <?php echo htmlspecialchars($row['datum']); ?></p>
    </section>

    <section class="clanak-slika">
        <img src="<?php echo UPLPATH . htmlspecialchars($row['slika']); ?>" alt="<?php echo htmlspecialchars($row['naslov']); ?>">
    </section>

    <section class="clanak-sadrzaj">
        <?php
    
        $paragrafi = explode("\n", $row['tekst']);
        foreach ($paragrafi as $p) {
            $p = trim($p);
            if ($p !== '') {
                echo '<p>' . nl2br(htmlspecialchars($p)) . '</p>';
            }
        }
        ?>
    </section>

<?php else: ?>
    <p style="padding:40px;text-align:center;">Traženi članak ne postoji.</p>
<?php endif; ?>
</main>

<?php
mysqli_close($dbc);
include 'footer.php';
?>
