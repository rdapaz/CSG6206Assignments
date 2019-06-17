<?php 

function longestWord($word_arr) {
    $longestWord = NULL;
    $longestWordLen = 0;
    foreach ($word_arr[0] as $word) {
        if (strlen($word) > $longestWordLen)  {
           $longestWord = $word;
           $longestWordLen = strlen($word);
        }
    }
    return array($longestWord, $longestWordLen);
}

function countWords($word_arr) {
    $count = 0;
    foreach ($word_arr[0] as $word) {
        $count++;
    }
    return $count;
}

function output($lw, $word, $wordCount){
    print "The longest word is $word, $lw characters long.\n";
    print "The number of words is $wordCount\n";
    return 0;
}

$filename = "/home/rdapaz/projects/CSG6206/lorem.txt";
$handle = fopen($filename, 'r');
$contents = fread($handle, filesize($filename));
fclose($handle);

preg_match_all('/\w+/', $contents, $matches);

$arr = longestWord($matches);
$word=$arr[0];
$lw=$arr[1];
$wordCount = countWords($matches);
output($lw, $word, $wordCount);

?>