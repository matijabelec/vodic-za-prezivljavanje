<section class="frm-comments">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <textarea name="sadrzaj">{@sadrzaj}</textarea>
            <label for="sadrzaj">Komentar: </label>
        </div>
        
        <input type="hidden" name="id_clanka" value="{@id_clanka}">
        <input type="hidden" name="id_korisnika" value="{@id_korisnika}">
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="Potvrdi">
        </div>
    </form>
</section>