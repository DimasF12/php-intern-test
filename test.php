<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$size = 7;

for ($i = 0; $i < $size; $i++) {
    for ($j = 0; $j < $size; $j++) {
        if ($j == $i || $j == ($size - 1 - $i)) {
            echo "X ";
        } else {
            echo "O ";
        }
    }
    echo PHP_EOL;
}
