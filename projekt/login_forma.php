<div class="form-wrapper">
    <h1>Prijava</h1>
    <form action="administracija.php" method="POST">

        <div class="form-item">
            <label for="username">Korisničko ime:</label>
            <div class="form-field">
                <input type="text" name="username" id="username" class="form-field-textual" required>
            </div>
        </div>

        <div class="form-item">
            <label for="lozinka">Lozinka:</label>
            <div class="form-field">
                <input type="password" name="lozinka" id="lozinka" class="form-field-textual" required>
            </div>
        </div>

        <div class="form-item">
            <button type="submit" name="prijava" value="1">Prijavi se</button>
        </div>

    </form>
</div>
