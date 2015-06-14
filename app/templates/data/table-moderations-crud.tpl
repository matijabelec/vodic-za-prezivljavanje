<section class="frm-moderations">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <input type="text" name="id_korisnika" value="{@id_korisnika}">
            <label for="id_korisnika">Korisnik: </label>
        </div>
        
        <div>
            <input type="text" name="id_podrucja" value="{@id_podrucja}">
            <label for="id_podrucja">Područje: </label>
        </div>
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="{@btn-submit}">
        </div>
    </form>
</section>