<section class="main-section">
    <h2>Registracija</h2>
    <div id="div-errors">{@errors}</div>
    <div>
        <form name="frm-registration" action="{@project_root_path}/auth/registration" method="post">
            <label for="username">Korisničko ime: </label>
            <input type="text" name="username"><br>
            
            <label for="email">Vaš e-mail: </label>
            <input type="email" name="email"><br>
            
            <label for="email2">Ponovni unos e-maila: </label>
            <input type="email" name="email2"><br>
            
            <label for="password">Vaša lozinka: </label>
            <input type="password" name="password"><br>
            
            <label for="password2">Ponovni unos lozinke: </label>
            <input type="password" name="password2"><br>
            
            <input type="submit" value="Registriraj se">
        </form>
    </div>
</section>
