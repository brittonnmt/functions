<?php
/**
 * Class JSONCache
 */
class JSONCache
{
    /**
     * The cache refresh time.
     *
     * @var string
     */
    public $refresh_time;

    /**
     * The directory for the cache file.
     *
     * @var string
     */
    public $cache_directory;

    /**
     * The cache filename
     *
     * @var string
     */
    public $cache_file;


    /**
     * JSONCache constructor.
     *
     * @param string $cache_directory
     * @param string $cache_file
     * @param string $refresh_time
     */
    public function __construct($cache_directory, $cache_file, $refresh_time = '-1 hour')
    {
        $this->cache_directory = $cache_directory;
        $this->cache_file = $cache_directory . $cache_file;
        $this->refresh_time = $refresh_time;
    }

    /**
     * Check to see if the cache file needs to be updated.
     *
     * @return bool
     */
    public function cacheNeedUpdate()
    {
        $update_cache = $this->_checkDirectoryAndFile();

        $last_modified = date("Y-m-d H:i:s", filemtime($this->cache_file));
        $refresh_time = date("Y-m-d H:i:s", strtotime($this->refresh_time));

        if ($last_modified < $refresh_time) {
            $update_cache = TRUE;
        }

        return $update_cache;
    }

    /**
     * Updates the cache file with new contents.
     *
     * @param      $content
     * @param bool $return
     *
     * @return bool|mixed|string
     */
    public function updateCacheFile($content, $return = FALSE)
    {
        $this->_checkDirectoryAndFile();

        $content = json_encode($content);

        file_put_contents($this->cache_file, $content);

        if ($return) {
            return $this->readCacheFile();
        }
    }

    /**
     * Reads the file contents, decodes the JSON, and returns it as an Object.
     *
     * @return bool|mixed|string
     */
    public function readCacheFile()
    {
        $file_contents = file_get_contents($this->cache_file);

        if ($file_contents) {
            $data = json_decode($file_contents);

            return $data;
        }

        return FALSE;
    }


    /**
     * Creates Cache Directory and File if needed.
     *
     * @return bool
     */
    private function _checkDirectoryAndFile()
    {
        $file = file_exists($this->cache_file);

        if ( ! $file) {
            mkdir($this->cache_directory, 0755);
            touch($this->cache_file); // Create the file since it does not exist.

            return TRUE;
        }

        return FALSE;
    }
}