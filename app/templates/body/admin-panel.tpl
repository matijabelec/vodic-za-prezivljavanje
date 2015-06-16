<section id="admin-tables" class="main-section">
    <h2>Virtualno vrijeme</h2>
    <p>Vrijeme sustava: <span class="time-current">{@trenutno_vrijeme}</span></p>
    <p>Vremenski pomak (u satima): <span class="time-offset">{@pomak_vremena}</span></p>
    
    <div>
        <a class="btn" href="{@project_root_path}/admin/time">Ažuriraj</a>
        <a class="btn" href="http://arka.foi.hr/WebDiP/pomak_vremena/vrijeme.html" target="_blank">Postavi</a>
    </div>
</section>
<section id="admin-tables" class="main-section">
    <h2>CRUD</h2>
    <div class="admin-table-controls">
        <a class="table-btn first-load" href="users">korisnici</a> | 
        <a class="table-btn" href="areas">područja</a> | 
        <a class="table-btn" href="articles">članci</a> | 
        <a class="table-btn" href="subscribes">pretplate/moderatori</a> | 
        <a class="table-btn" href="comments">komentari</a> | 
        <a class="table-btn" href="materials">materijali</a> | 
        <a class="table-btn" href="restrictions">zabrana pristupa</a>
    </div>
    <!--<div>
        <a class="btn" href="#create">Kreiraj</a>
        <a class="btn" href="#read">Pogledaj</a>
        <a class="btn" href="#update">Ažuriraj</a>
        <a class="btn" href="#delete">Izbriši</a>
    </div>-->
    <div class="table-informations"></div>
</section>
<section id="admin-login-statistics" class="main-section">
    <h2>Statistika prijava/odjava</h2>
    <div class="admin-table-controls">
        <a class="table-btn first-load" href="log-data">Osvježi</a>
    </div>
    <div class="table-informations"></div>
</section>