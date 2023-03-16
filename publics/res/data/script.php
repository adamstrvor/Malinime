<?php

$partials = scandir(FOLDER_JS_PARTIALS);
foreach($partials as $p) { if(str_split($p)[0] != '.'){ ?> <script src="<?= LFOLDER_JS_PARTIALS.$p; ?>"> </script> <?php }} 

?>

<!-- <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6927974030330071"
crossorigin="anonymous"></script> -->