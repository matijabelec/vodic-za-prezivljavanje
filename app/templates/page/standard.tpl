<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{@title}</title>
    
    <!--<link rel="shortcut icon" href="/picek.ico"/>-->
    
    <link rel="stylesheet" href="/site/css/newstyle.css"/>
    <link rel="stylesheet" href="/site/css/newstyle-mobile.css" media="screen and (max-width: 400px)"/>
    <link rel="stylesheet" href="/site/css/newstyle-tablet.css" media="screen and (min-width: 401px) and (max-width: 720px)"/>
    {@head-data}
</head>
<body>
    <header id="header">Priručnik za preživljavanje</header>
    <nav id="nav">
        <script>function showmenu(){var m=document.getElementById('main-menu');m.className.match(/(?:^|\s)show-menu(?!\S)/)?m.className=m.className.replace(/(?:^|\s)show-menu(?!\S)/g ,''):m.className=m.className+' show-menu';}</script>
        <span id="show-nav" onclick="showmenu()"></span>
        <ul id="main-menu" class="menu-list">
            <li><a class="menu-option{@option1}" href="/">Početna</a></li>
            <li><a class="menu-option{@option2}" href="/tutorials">Teorija</a></li>
            <li><a class="menu-option{@option3}" href="/tutorials">Zadaci</a></li>
            <li><a class="menu-option{@option4}" href="/fun">Zabava</a></li>
            <li><a class="menu-option{@option5}" href="/impressum">Impressum</a></li>
        </ul>
    </nav>
    <div id="main">
        {@body}
    </div>
    <footer id="footer">
        <div class="social-links">
            <a class="sociallink-img sociallink-fb" target="_blank" href="https://www.facebook.com/pages/I-piceki-to-znaju/343811279109196/"></a>
            <a class="sociallink-img sociallink-yt" target="_blank" href="https://www.youtube.com/channel/UCcE7QFv3Aqb8xNvURSXgylg/"></a>
        </div>
        <div id="copyright-info">
            <p>Copyright &copy; 2015 <a href="https://plus.google.com/100603684622190187147?rel=author">Matija Belec</a>.</p>
            <p>Sva prava zadržana.</p>
        </div>
    </footer>
</body>
</html>