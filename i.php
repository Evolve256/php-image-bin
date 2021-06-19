<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (0 === error_reporting()) {
        return false;
    }
    http_response_code(500);
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
if(isset($_GET["i"])) {
    $file = getcwd() . "/i/" . $_GET["i"];
    if (file_exists($file)) {
        header('Content-Type: ' . mime_content_type($file));
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        unlink($file);
        exit;
    } else {
        http_response_code(404);
        echo "File does not exist or has been deleted.";
        exit;
    }
} else {
    header("location: index.php");
        exit;
}
?>