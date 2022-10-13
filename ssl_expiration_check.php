<?php

// URL: https://qiita.com/nwsoyogi/items/3e3c4d7dd4f45169628b
function ssl_expiration_check($domain_name)
{
    $stream_context = stream_context_create(array(
    'ssl' => array('capture_peer_cert' => true)
    ));
    $resource = stream_socket_client(
        'ssl://' . $domain_name . ':443',
        $errno,
        $errstr,
        30,
        STREAM_CLIENT_CONNECT,
        $stream_context
    );
    $cont = stream_context_get_params($resource);
    $parsed = openssl_x509_parse($cont['options']['ssl']['peer_certificate']);

    if (strpos($parsed['subject']['CN'], $domain_name) !== false) {
        return date('Y年m月d日', $parsed['validTo_time_t']);
    } else {
        return 'not contract.';
    }
}

$domain = 'sgym.online';
$date = ssl_expiration_check($domain);
echo "https://" . $domain . ":SSL証明書の有効期限は【" . $date ."】です";