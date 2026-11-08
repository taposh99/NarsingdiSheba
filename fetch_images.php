<?php
$url = 'https://commons.wikimedia.org/w/api.php?action=query&list=search&srsearch=Parulia+Mosque+OR+Ashrafpur+Narsingdi&srnamespace=6&format=json';
$opts = ['http' => ['method' => 'GET', 'header' => "User-Agent: NarsingdiShebaApp/1.0 (info@narsingdisheba.com)\r\n"]];
$res = @file_get_contents($url, false, stream_context_create($opts));
print_r(json_decode($res, true));
