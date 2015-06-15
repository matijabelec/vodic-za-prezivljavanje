<section class="frm-areas">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <input type="text" name="naziv_podrucja" value="{@naziv_podrucja}">
            <label for="naziv_podrucja">Naziv područja: </label>
        </div>
        
        <div>
            <textarea name="opis">{@opis}</textarea>
            <label for="opis">Opis: </label>
        </div>
        
        <div>
            <input type="text" name="slika" value="{@slika}">
            <label for="slika">Slika: </label>
        </div>
        
        <input type="hidden" name="id_podrucja" value="{@id_podrucja}">
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="Potvrdi">
        </div>
    </form>
</section>