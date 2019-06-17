<?php 

function word_filter($word_arr) {
    $target_words = Array();
    foreach ($word_arr[0] as $word) {
        if (! preg_match('/^[A-Z]/', $word) ) {
            array_push($target_words, $word);
        }
    }
    return $target_words;
}

function output($arr){
    return implode(" ", $arr);
}

$filename = "/home/rdapaz/projects/CSG6206/lorem.txt";
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize($filename));
fclose($handle);

preg_match_all('/[a-zA-Z0-9,.!?]+/', $contents, $matches);

$word_arr = word_filter($matches);
print output($word_arr);
?>