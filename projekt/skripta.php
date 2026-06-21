<?php
include 'connect.php';
define('UPLPATH', 'img/');

$title   = isset($_POST['title']) ? trim($_POST['title']) : '';
$about   = isset($_POST['about']) ? trim($_POST['about']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
$category = isset($_POST['category']) ? $_POST['category'] : 'mundo';
$date    = date('d.m.Y.');
$archive = isset($_POST['archive']) ? 1 : 0;

$picture = '';
$upload_ok = true;


if (isset($_FILES['pphoto']) && $_FILES['pphoto']['error'] === UPLOAD_ERR_OK) {
    $picture = basename($_FILES['pphoto']['name']);
    $target  = 'img/' . $picture;
    $upload_ok = move_uploaded_file($_FILES['pphoto']['tmp_name'], $target);
} else {
    $upload_ok = false;
}


$spremljeno = false;

if ($title !== '' && $about !== '' && $content !== '' && $upload_ok) {
    $sql = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssssssi', $date, $title, $about, $content, $picture, $category, $archive);
        $spremljeno = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($dbc);

$aktivna = 'unos';
$naslov_stranice = 'Pregled unesene vijesti';
include 'header.php';
?>

<main>
    <?php if ($spremljeno): ?>
        <p class="poruka-uspjeh" style="text-align:center;margin-top:20px;">Vijest je uspješno spremljena u bazu podataka!</p>
    <?php else: ?>
        <p class="bojaPoruke" style="text-align:center;margin-top:20px;">Dogodila se pogreška prilikom spremanja vijesti. Provjeri jesi li ispunio sva polja i odabrao sliku.</p>
    <?php endif; ?>

  
    <section class="clanak-header">
        <p class="category"><span><?php echo htmlspecialchars(ucfirst($category)); ?></span></p>
        <h1 class="title"><?php echo htmlspecialchars($title); ?></h1>
        <p class="about"><i><?php echo htmlspecialchars($about); ?></i></p>
        <p class="autor-info">OBJAVLJENO: <?php echo htmlspecialchars($date); ?></p>
    </section>

    <?php if ($picture): ?>
    <section class="clanak-slika">
        <img src="<?php echo UPLPATH . htmlspecialchars($picture); ?>" alt="<?php echo htmlspecialchars($title); ?>">
    </section>
    <?php endif; ?>

    <section class="clanak-sadrzaj">
        <p><?php echo nl2br(htmlspecialchars($content)); ?></p>
    </section>

    <p style="text-align:center;margin-bottom:30px;">
        <a href="index.php" style="color:#1859b5;">&larr; Povratak na naslovnicu</a>
    </p>
</main>

<?php include 'footer.php'; ?>
