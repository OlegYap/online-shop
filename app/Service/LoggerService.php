<?php

namespace Service;

class LoggerService
{
    public function error($error): bool|int
    {
        $file = '../Storage/logs/error.txt';
        $data = date('D.M.Y. H:i:s') ;
        $message = $error->getMessage() . $error->getLine() . $error->getFile();

        return file_put_contents($file, $data . $message . FILE_APPEND);
    }
}