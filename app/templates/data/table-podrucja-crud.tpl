<section class="frm-areas">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <input type="text" name="naziv_podrucja" value="{@naziv_podrucja}" {@readonly}>
            <label for="naziv_podrucja">Naziv područja: </label>
        </div>
        
        <div>
            <textarea name="opis" {@readonly}>{@opis}</textarea>
            <label for="opis">Opis: </label>
        </div>
        
        <div>
            <input type="text" name="slika" value="{@slika}" {@readonly}>
            <label for="slika">Slika: </label>
        </div>
        
        <!--<div>
            <select name="status" {@readonly}>
                <option value="1" {@status-1}>Aktivno</option>
                <option value="0" {@status-0}>Izbrisano</option>
            </select>
            <label for="status">Status: </label>
        </div>-->
        
        <input type="hidden" name="id_podrucja" value='{@id_podrucja}' {@readonly}>
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="{@btn-submit}">
        </div>
    </form>
</section>