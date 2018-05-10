<?php
$cache_directory = '/var/www/public/cache/';
$cache_file = 'test.json';

$data = array(
    'numbers' => array(0, 1, 2, 3, 4, 5, 6),
    'people'  => array(
        array('name' => 'Bob Bobson'),
        array('name' => 'Tom Tomson'),
    ),
);

/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////

$cache = new JSONCache($cache_directory, $cache_file);

// Check if a cache file update is needed.
$update_cache = $cache->cacheNeedUpdate();

if ($update_cache) {
    // Update the cache file with the new data.
    $cache_data = $cache->updateCacheFile($data, TRUE);
} else {
	// Read the cache file data.
    $cache_data = $cache->readCacheFile();
}