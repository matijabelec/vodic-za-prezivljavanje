<section class="main-section">
    <h2>Prijava</h2>
    <div id="div-errors">{@errors}</div>
    <div>
        <form name="frm-login" action="{@project_root_path}/auth/login" method="post">
            <div>
                <input type="text" name="username"><br>
                <label for="username">Korisničko ime: </label>
            </div>
            
            <div>
                <input type="password" name="password"><br>
                <label for="password">Lozinka: </label>
            </div>
            
            <div>
                <input type="submit" value="Prijavi se">
            </div>
        </form>
    </div>
</section>