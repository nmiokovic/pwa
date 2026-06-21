<?php

if (!isset($aktivna)) { $aktivna = ''; }
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($naslov_stranice) ? $naslov_stranice . ' - El Debate' : 'El Debate'; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<header>
    <div class="logo-container">
        <a href="index.php">de<span class="logo-accent">bate</span></a>
    </div>
    <nav class="main_nav" role="navigation">
        <ul>
            <li><a href="index.php" class="<?php echo $aktivna=='home'?'active':''; ?>">Home</a></li>
            <li><a href="kategorija.php?kategorija=mundo" class="<?php echo $aktivna=='mundo'?'active':''; ?>">Mundo</a></li>
            <li><a href="kategorija.php?kategorija=deporte" class="<?php echo $aktivna=='deporte'?'active':''; ?>">Deporte</a></li>
            <li><a href="unos.php" class="<?php echo $aktivna=='unos'?'active':''; ?>">Unos vijesti</a></li>
            <li><a href="administracija.php" class="<?php echo $aktivna=='admin'?'active':''; ?>">Administracija</a></li>
        </ul>
    </nav>
</header>
