<?php
//$link = mysql_connect('192.168.11.73', 'dhcp', 'lcf5y9qCZYQlC6h4');
$link = mysqli_connect('192.168.11.73', 'dhcp', 'lcf5y9qCZYQlC6h4');
if (!$link) {
//    die('MySQL connection error: ' . mysql_error());
    die('MySQL connection error: ' . mysqli_error());
}
//mysql_select_db('manager', $link);
mysqli_select_db('manager', $link);



function isAuthorized() {
    $headers = getallheaders();

    return empty($headers['Authorization'])
        ? false
        : ($headers['Authorization'] === 'Bearer huO789y87GG89GgF78F87F8');
}

/**
 * IP network (mask 24)
 *
 * @param $ip
 * @param int $mask
 * @return string
 */
function toNetwork($ip, $mask = 24)
{
    if (empty($ip))
        exit('Empty IP');

    return long2ip((ip2long($ip)) & ((-1 << (32 - (int)$mask))));
}

/**
 * get or change last IP octet
 *
 * @param $ip
 * @param null $value
 * @return string
 */
function lastOctet($ip, $value = null)
{
    $parts = explode('.', $ip);

    if ($value === null) {
        return $parts[3];
    } else {
        $parts[3] = $value;
    }

    return implode('.', $parts);
}
