<?php

function cidr(&$data, $v)
{
    $last =  end($data);
    if($last == null) 
        return $data[] = $v;

    list($last_net,$last_sub) = explode("/", $last);
    list($net,$sub) = explode("/", $v);

    // big than old, can not merge.
    if($sub < $last_sub)
        return $data[] = $v;

    list($la,$lb,$lc,$ld) = explode(".", $last_net);
    list($a,$b,$c,$d) = explode(".", $net);

    // only merge class B.
    if($la != $a || $lb > $b)
        return $data[] = $v;

    // check in the range
    if($sub > $last_sub)
    {
        $range = netmask($last_net, $last_sub);
        list($max_a,$max_b,$max_c,$max_d) = explode(".", $range[1]);

        if($b <= $max_b && $c <= $max_c)
            return $data;

        return $data[] = $v;
    }

    // try to build a new one
    if($sub == $last_sub)
    {
        $range = netmask($last_net, $last_sub - 1);
        list($max_a,$max_b,$max_c,$max_d) = explode(".", $range[1]);

        if($b <= $max_b && $c <= $max_c)
            return $data[key($data)] = $last_net . "/" . ($last_sub - 1);

        return $data[] = $v;
    }
}

function netmask($ip, $mask = 24) 
{
    $mask = pow(2, 32 - $mask) - 1;
    $smask = $mask ^ ip2long('255.255.255.255');

    $min = ip2long($ip) & $smask;  
    $max = ip2long($ip) | $mask;  

    return array(long2ip($min), long2ip($max));
}