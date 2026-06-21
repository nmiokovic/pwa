<?php
$aktivna = 'unos';
$naslov_stranice = 'Unos vijesti';
include 'header.php';
?>

<main>
    <div class="form-wrapper">
        <h1>Unos nove vijesti</h1>

        <form enctype="multipart/form-data" action="skripta.php" method="POST">

            <div class="form-item">
                <label for="title">Naslov vijesti:</label>
                <div class="form-field">
                    <input type="text" id="title" name="title" class="form-field-textual" required>
                </div>
            </div>

            <div class="form-item">
                <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
                <div class="form-field">
                    <textarea name="about" id="about" cols="30" rows="3" class="form-field-textual" maxlength="50" required></textarea>
                </div>
            </div>

            <div class="form-item">
                <label for="content">Sadržaj vijesti:</label>
                <div class="form-field">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-field-textual" required></textarea>
                </div>
            </div>

            <div class="form-item">
                <label for="pphoto">Slika:</label>
                <div class="form-field">
                    <input type="file" accept="image/jpg,image/jpeg,image/png,image/gif" class="input-text" id="pphoto" name="pphoto" required>
                </div>
            </div>

            <div class="form-item">
                <label for="category">Kategorija vijesti:</label>
                <div class="form-field">
                    <select name="category" id="category" class="form-field-textual">
                        <option value="mundo">Mundo</option>
                        <option value="deporte">Deporte</option>
                    </select>
                </div>
            </div>

            <div class="form-item">
                <label>
                    <input type="checkbox" name="archive" id="archive">
                    Sakrij vijest (arhiviraj)
                </label>
            </div>

            <div class="form-item">
                <button type="reset">Poništi</button>
                <button type="submit">Prihvati</button>
            </div>

        </form>
    </div>
</main>

<?php include 'footer.php'; ?>
