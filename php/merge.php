<?php

include dirname(__FILE) . "/tools.php";

$file =  $argv[1];

if(!is_file($file)) exit("file is null\n");

$data = trim(file_get_contents($file));
$data = explode("\n", $data);

$count = '';
for($i=0;$i<16;$i++)
{
    $tmp = [];
    $count .= count($data) . "\n";
    foreach ($data as $v) {
        cidr($tmp, $v);
    }
    $data = $tmp;
}

$msg = '';
foreach ($data as $v)
    $msg .= $v . "\n";

echo trim($msg);
