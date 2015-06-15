<section class="main-section">
    <h2>Registracija</h2>
    <div id="div-errors">{@errors}</div>
    <div>
        <form name="frm-registration" action="{@project_root_path}/auth/registration" method="post">
            <div>
                <input type="text" name="korisnicko_ime"><br>
                <label for="korisnicko_ime">Korisničko ime: </label>
            </div>
            
            <div>
                <input type="mail" name="mail"><br>
                <label for="mail">Vaš e-mail: </label>
            </div>
            
            <div>
                <input type="mail" name="mail2"><br>
                <label for="mail2">Ponovni unos e-maila: </label>
            </div>
            
            <div>
                <input type="password" name="lozinka"><br>
                <label for="lozinka">Vaša lozinka: </label>
            </div>
            
            <div>
                <input type="password" name="lozinka2"><br>
                <label for="lozinka2">Ponovni unos lozinke: </label>
            </div>
            
            <input type="submit" value="Registriraj se">
        </form>
    </div>
</section>
