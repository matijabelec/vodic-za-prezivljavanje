<section class="area-section area-active">
    <div class="area-img-out">
        <img class="area-img" src="{@slika}" onerror="if(this.src!='{@project_root_path}/site/gfx/area-error-img.png') this.src='{@project_root_path}/site/gfx/area-error-img.png';" alt="[slika područja {@naziv_podrucja}]">
    </div><div class="area-short-desc">
        <h2 class="area-title">{@naziv_podrucja}</h2>
        <p class="area-desc">{@opis}</p>
        
        <a class="btn area-subscribe" href="{@project_root_path}/subscribes{@subscribe-link}">{@subscribe}</a>
        <a class="btn area-more-information" href="{@project_root_path}/areas/read/{@id_podrucja}">Više</a>
    </div>
</section>