<?php
function verifyEmail($email) {
  return preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email) == 1;
}

#mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
function sendEmail($to, $subject, $message, $headers) {
	return mail($to , $subject , $message, $headers);
}

// http://php.net/manual/en/function.mt-rand.php
function mt_rand_str ($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890') {
    for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
    return $s;
}

# recursively remove a directory
# thanks to longears at BLERG dot gmail dot com (http://us3.php.net/rmdir)
function rrmdir($dir) {
    foreach(glob($dir . '/*') as $file) {
        if(is_dir($file))
            rrmdir($file);
        else
            unlink($file);
    }
    rmdir($dir);
}
?>