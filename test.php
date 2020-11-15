<?php
/**
 * Simple tests
 */

require (__DIR__.'/config.php');
require (__DIR__.'/components/autoloader.php');

$folder = __DIR__.'/tests';

if (!file_exists($folder) || !is_dir($folder) || !is_readable($folder)) {
    echo 'Cannot read tests folder'."\n";
    die();
}

$files = glob($folder.'/*Test.php');

foreach ($files as $file) {

    echo $file."\n";

    require($file);

    $name = basename($file);
    $name = substr($name, 0, strrpos($name, '.'));

    echo 'Test ['.$name.']'."\n";

    $test = new $name();

    $methods = get_class_methods($test);

    foreach ($methods as $method) {
        if ('test'==substr($method, 0, 4)) {
            echo ' > '.$method;

            if (!$test->$method()) {
                echo ' - FAIL'."\n";
                break 2;
            }
            else {
                echo ' - OK'."\n";
            }
        }
    }

    echo '=='."\n";
}

echo 'done'."\n";