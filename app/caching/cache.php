<?php

namespace App\caching;

class cache
{
    public static function file ($name, $data) {
        self::removeCache();
        $path = 'app/caching/cache/'. md5($name) . '.json';
        $dirname = dirname($path);
        if (!is_dir($dirname))
        {
            mkdir($dirname, 0777, true);
        }
        if (file_exists($path)) {
            $path = file_get_contents($path);
            return $path;
        }
        $file_name_cache = fopen($path,'w');
        fwrite($file_name_cache, json_encode($data));
        fclose($file_name_cache);
    }

    public static function check ($name) {
        $path = 'app/caching/cache/'. md5($name) . '.json';
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return false;
    }

    public static function removeCache () {
        $path = 'app/caching/cache/';
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                $filelastmodified = filemtime($path . $file);
                if((time() - $filelastmodified) > 24*3600)
                {
                    unlink($path . $file);
                }
            }
            closedir($handle);
        }
    }

}