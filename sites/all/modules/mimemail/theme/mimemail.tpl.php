<?php
// $Id: mimemail.tpl.php,v 1.1.2.2 2009/04/14 23:09:01 jerdavis Exp $

/**
 * @file mimemail.tpl.php
 */
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if ($css): ?>
    <style type="text/css">
      <!--
      <?php print $css ?>
      -->
    </style>
    <?php endif; ?>
  </head>
  <body id="mimemail-body">
    <div id="center">
      <div id="main">
        <?php print $body ?>
      </div>
    </div>
  </body>
</html>
