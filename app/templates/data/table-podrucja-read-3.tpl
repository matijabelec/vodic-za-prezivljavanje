<section class="area-section-detailed">
    <h2 class="area-title">{@naziv_podrucja}</h2>
    
    <img class="area-img" src="{@slika}" alt="[slika područja {@naziv_podrucja}]">
    
    <p class="area-desc">{@opis}</p>
    
    <section class="area-detailed-information">
        <h3>Popis članaka</h3>
        {@area-articles}
    </section>
    
    <div class="btn-out">
        <a class="btn" href="{@project_root_path}/subscribes/create/{@id_podrucja}">Pretplati se</a>
        <a class="btn" href="{@project_root_path}/areas/view">Ok</a>
    </div>
</section>
