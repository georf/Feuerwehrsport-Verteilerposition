<?php

ob_start();

require_once 'functions.php';

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Verteilerposition - Team MV</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="bootstrap/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="http://www.feuerwehrsport-teammv.de">Team-MV</a>
            <ul class="nav">
				<?php

if (!isset($_GET['page'])) $_GET['page'] = 'home';

				$menu = array(
					'home' => 'Startseite',
					'new' => 'Neuer Eintrag',
					'men' => 'Männer',
					'women' => 'Frauen',
				);

				foreach ($menu as $p => $k) {
					if ($p == $_GET['page']) {
						echo '<li class="active">';
					} else {
						echo '<li>';
					}
					echo '<a href="?page=',$p,'">',$k,'</a></li>';
				}
				?>
            </ul>
        </div>
      </div>
    </div>

    <div class="container">

        <?php


$hd = opendir('pages');
while ( $file = readdir($hd)) {
	if ($_GET['page'].'.php' == $file && is_file('pages/'.$file)) {
		include 'pages/'.$file;
		break;
	}
}
closedir($hd);
?>

      <hr>

      <footer>
        <p>&copy; Company 2012 - Feuerwehrsport - Team MV</p>
      </footer>

    </div> <!-- /container -->

<!--[if lt IE 8 ]>
<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script>window.attachEvent('onload',function(){
  var install = confirm('Es wurde erkannt, dass du einen veralteten Internet Explorer benutzt. Damit wird die Seite nicht funktionieren. Willst du Chrome Frame als Internet Explorer Plugin installieren?');
  if (install) {
    CFInstall.check({mode:'overlay'});
  } else {
    alert("Die Seite wird so nicht funktionieren. Bitte nutze Firefox oder Chrome oder einen neueren Internet Explorer.\nOder melde dich bei Georg, wenn es immer noch Probleme gibt: georf@georf.de");
  }
})</script>
<![endif]-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jquery-rotate.js"></script>
    <script src="script.js"></script>


  </body>
</html>
