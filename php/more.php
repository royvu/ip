<?php

$data = trim(file_get_contents("more.txt"));
$data = explode("\n", $data);

$more = [];
foreach ($data as $v)
{
    list($net,$sub) = explode(" ", $v);

    if($sub != '')
        $more[] = $net;
}

$data = trim(file_get_contents("tmp.more.txt"));
$data = explode("\n", $data);

$tmp = [];
foreach ($data as  $v)
{
    list($net,$sub) = explode(" ", $v);

    if($sub != '')
        $tmp[] = $net;
}
foreach ($tmp as $v) {
    if(in_array($v, $more))
        echo $v.".0.0/16\n";
}