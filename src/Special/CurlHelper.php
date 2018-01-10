<?php

namespace OSSchools\Extensions\CommonMark\Special;

/**
 * This class helps curl with caching and general other purposes related to curl
 *
 * Class CurlHelper
 * @package OSSchools\Extensions\CommonMark\Special
 */
class CurlHelper
{

    private $curl;
    private $args;
    private $cacheTime;
    private $ignoreCache;

    public function __construct($url, $args = [], $cacheTime = 64000, $ignoreCache = false)
    {
        $this->cacheTime = $cacheTime;
        $this->ignoreCache = $ignoreCache;
        $this->args = $args;
        $this->curl = $this->request($url, $args);
    }

    private function request($url, $args)
    {
        $where = sys_get_temp_dir() . "/commonmark-ext-cache";
        if (!is_dir($where)) {
            mkdir($where);
        }
        $hash = sha1($url);
        $file = "$where/$hash.cache";
        $modifiedTime = 0;
        if (file_exists($file)) {
            $mtime = filemtime($file);
        }
        $filetimemod = $modifiedTime + $this->cacheTime;
        if ($filetimemod < time()) {

            $curl_handle = curl_init();
            curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)');
            curl_setopt($curl_handle, CURLOPT_URL, $url);
            if (count($args) > 0) {
                foreach ($args as $name => $value) {
                    curl_setopt($curl_handle, $name, $value);
                }
            }

            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
            if ($buffer) {
                file_put_contents($file, $buffer);
            }
        } else {
            $buffer = file_get_contents($file);
        }
        return $buffer;
    }

    public function getCache()
    {

    }

    public function putCache()
    {

    }
}
