<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{@title}</title>
    
    <!--<link rel="shortcut icon" href="/icon.ico"/>-->
    
    <link href='//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{@project_root_path}/site/css/style.css"/>
    {@head-data}
</head>
<body>
    <div id="user-type-identification"{@style-user-type-id}></div>
    <header id="header">
        {@project-title}
    </header>
    
    {@main-menu}
    
    <div id="main">
        {@body}
    </div>
    <footer id="footer">
        <div class="footnav">
            <ul id="footer-menu" class="menu-list">
                <li><a class="menu-option{@option-documentation}" href="{@project_root_path}/dokumentacija.html">Dokumentacija</a></li>
                <li><a class="menu-option{@option-about-author}" href="{@project_root_path}/o_autoru.html">O autoru</a></li>
            </ul>
        </div>
        <div id="copyright-info">{@copyright-info-data}</div>
    </footer>
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{@project_root_path}/site/js/jquery-2.1.4.min.js">\x3C/script>')</script>-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>
    {@foot-data}
</body>
</html>