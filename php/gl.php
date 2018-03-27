<?php

## define
include dirname(__FILE) . "/tools.php";

// class c more than $max will be ignored
$max = 200;

$data = trim(file_get_contents("tmp.txt"));
$data = explode("\n", $data);

$tmp = [];

foreach ($data as $v)
{
    list($net,$sub) = explode("/", $v);
    list($a,$b,$c,$d) = explode(".", $net);

    $range = netmask($net, $sub);
    list($a,$mb,$mc,$d) = explode(".", $range[1]);

    if(empty($tmp[$a]))
        $tmp[$a] = range(0, 255);

    // first remove class b
    unset($tmp[$a][$b]);

    // remove big than 16
    if($sub < 16)
        for($i=$b; $i <=$mb; $i++)
            unset($tmp[$a][$i]);

    // proccess class c
    if($sub > 16)
    {
        $k = "$a.$b";
        if(empty($tmp[$k]))
            $tmp[$k] = range(0, 255);

#        if($sub == 24)
#            unset($tmp[$k][$c]);
#        else
        if($sub < 24)
            for($i=$c; $i <=$mc; $i++)
                unset($tmp[$k][$i]);
    }
}

$data = '';
$more = '';
$count = '';

foreach ($tmp as $a=>$v) 
{
    if (is_int($a) && $a < 224)
    {
        foreach ($v as $b)
            $data[] = "$a.$b.0.0/16";
    }
    if(!is_int($a))
    {
        $i = 0;
        foreach ($v as $b)
        {
            $i++;
            $data[] = "$a.$b.0/24";
        }

        if($i > $max)
            $more  .= "$a $i\n";
    }
}
file_put_contents('more.txt', trim($more));

for($i=0;$i<10;$i++)
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

