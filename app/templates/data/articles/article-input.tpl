<section class="frm-article">
    <form action="{@project_root_path}/{@link}" method="post">
        <div>
            <input type="text" name="naslov" value="{@naslov}">
            <label for="naslov">Naslov: </label>
        </div>
        
        <div>
            <textarea name="sadrzaj">{@sadrzaj}</textarea>
            <label for="sadrzaj">Sadržaj: </label>
        </div>
        
        <div style="text-align: right">
            <a class="btn" href="{@project_root_path}/{@link-back}">Natrag</a>
            <input class="btn" type="submit" value="Potvrdi">
        </div>
    </form>
</section>