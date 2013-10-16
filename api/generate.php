<?php
require_once 'core/common.inc.php';
$publicKey = sha1(mt_rand_str(40));
$privateKey = sha1(mt_rand_str(40));
echo json_encode(array('public' => $publicKey, 'private' => $privateKey));
#echo "Public key: <b>" . $publicKey . "</b>";
#echo "<br />";
#echo "Private key: <b>" . $privateKey. "</b>";
?>