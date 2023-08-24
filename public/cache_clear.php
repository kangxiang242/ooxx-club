<?php
exec("/usr/local/sh/rsyncd.sh",$output);
exec("/usr/local/php/bin/php /data/wwwroot/special-fun.com/artisan cache:clear",$output);

