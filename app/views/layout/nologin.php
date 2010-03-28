<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dashboard - Admin Template</title>
<link rel="stylesheet" type="text/css" href="/css/theme.css" />
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<script>
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
   document.writeln('<link rel="stylesheet" type="text/css" href="css/' + StyleFile + '">');
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->
</head>

<body>

    <!-- container -->
    <div id="container">
      
      <!-- header -->
      <div id="header">
       	<h2><?php echo SITE_NAME_TT; ?></h2>
          <div id="topmenu">
           	<ul>
              <li class="current"><a href="/">Top</a></li>
              <li><a href="/teams/">Teams</a></li>
            </ul>
          </div>
          <!-- /topmenu  -->
      </div>
      <!-- /header -->


      <!-- wrapper -->
      <div id="wrapper">

          <div id="nologin_content">

          <?php echo $this->content(); ?>

          </div>
            
      </div>
      <!-- /wrapper -->

      <!-- footer -->
      <div id="footer">
          &copy; 2010 <a href="http://www.growthsquare.co.jp/">growthsquare</a> All Rights Reserved.
        <div id="styleswitcher">
            <ul>
                <li><a href="javascript: document.cookie='theme='; window.location.reload();" title="Default" id="defswitch">d</a></li>
                <li><a href="javascript: document.cookie='theme=1'; window.location.reload();" title="Blue" id="blueswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=2'; window.location.reload();" title="Green" id="greenswitch">g</a></li>
                <li><a href="javascript: document.cookie='theme=3'; window.location.reload();" title="Brown" id="brownswitch">b</a></li>
                <li><a href="javascript: document.cookie='theme=4'; window.location.reload();" title="Mix" id="mixswitch">m</a></li>
                <li><a href="javascript: document.cookie='theme=5'; window.location.reload();" title="Mix" id="defswitch">m</a></li>
            </ul>
        </div><br />

      </div>
      <!-- /footer -->
    </div>
    <!-- /container -->
</body>
</html>
