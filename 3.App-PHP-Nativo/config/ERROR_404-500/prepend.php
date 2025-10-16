<?php
register_shutdown_function(function(){
    if(error_get_last()['type'] === E_ERROR){
        header("HTTP/1.0 500 Internal Server Error");
        include($_SERVER['DOCUMENT_ROOT'].'/ERROR_404-500/500.html');
        exit();
    }
});
?>