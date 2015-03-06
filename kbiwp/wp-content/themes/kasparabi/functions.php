<?php

// include all PHP files in ./config/ directory:
foreach ( glob( dirname( __FILE__ ) . '/config/*.php' ) as $file )
    include $file;

// include all PHP files in ./business/ directory:
foreach ( glob( dirname( __FILE__ ) . '/business/*.php' ) as $file )
    include $file;