<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{@title}</title>
    
    <!--<link rel="shortcut icon" href="/picek.ico"/>-->
    
    <link rel="stylesheet" href="{@project_root_path}/site/css/style.css"/>
    {@head-data}
</head>
<body>
    <div id="user-type-identification"{@style-user-type-id}></div>
    <header id="header">
        {@project-title}
    </header>
    <nav id="nav">
        <ul id="main-menu" class="menu-list">
            <li><a class="menu-option{@option-home}" href="{@project_root_path}/">Početna</a></li>
            <li><a class="menu-option{@option-users}" href="{@project_root_path}/users">Korisnici</a></li>
            <li><a class="menu-option{@option-areas}" href="{@project_root_path}/areas">Područja</a></li>
        </ul>
        
        {@user-profile-menu}
    </nav>
    <div id="main">
        {@body}
    </div>
    <footer id="footer">
        <ul id="footer-menu" class="menu-list">
            <li><a class="menu-option{@option-documentation}" href="{@project_root_path}/dokumentacija.html">Dokumentacija</a></li>
            <li><a class="menu-option{@option-about-author}" href="{@project_root_path}/o_autoru.html">O autoru</a></li>
        </ul>
        <div id="copyright-info">{@copyright-info-data}</div>
    </footer>
</body>
</html>