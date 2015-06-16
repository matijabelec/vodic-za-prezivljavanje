<section class="frm-moderators">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <select name="id_korisnika">
                <option value="0" selected disabled>-- odaberi korisnika --</option>
                {@korisnici}
            </select>
            <label for="naziv_podrucja">Moderator: </label>
        </div>
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="Potvrdi">
        </div>
    </form>
</section>