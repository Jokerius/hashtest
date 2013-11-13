<?php
$start = microtime();
$md5 = array();
$sha1 = array();
$crypt = array();



for($i=0;$i<100000;$i++){
    $num = mt_rand(0, getrandmax());
    $md5s .= md5($num);
    $sha1s .= sha1($num);
    $crypts .= hash('sha512',$num);
}

$md5len = strlen($md5s);
for($i=0;$i<$md5len;$i++){
    $md5[$md5s[$i]]++;
}

$sha1len = strlen($sha1s);
for($i=0;$i<$sha1len;$i++){
    $sha1[$sha1s[$i]]++;
}

$cryptlen = strlen($crypts);
for($i=0;$i<$cryptlen;$i++){
    $crypt[$crypts[$i]]++;
}

ksort($md5);
ksort($sha1);
ksort($crypt);

foreach($md5 as $key=>&$value){
    $value = round($value/$md5len,4);
}

foreach($sha1 as $key=>&$value){
    $value = round($value/$sha1len,4);
}

foreach($crypt as $key=>&$value){
    $value = round($value/$cryptlen,4);
}

$out .= '<table border="1px solid black"><th>symbol</th><th>md5<th>sha1</th><th>sha512</th>';

foreach($md5 as $key=>$value){
    $md5color = $value>0.0625 ? '#d99' : '#9d9';
    $shacolor = $sha1[$key]>0.0625 ? '#d99' : '#9d9';
    $cryptcolor = $crypt[$key]>0.0625 ? '#d99' : '#9d9';
    $out .= <<< HERE
<tr>
<td>{$key}</td><td bgcolor="{$md5color}">{$value}</td><td bgcolor="{$shacolor}">{$sha1[$key]}</td><td bgcolor="{$cryptcolor}">{$crypt[$key]}</td>
</tr>
HERE;
}
$out .= '</table>';
echo $out;
$end = microtime() - $start;
var_dump($end);

?>