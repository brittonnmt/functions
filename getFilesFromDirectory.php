<?php
/**
 * @param       $directory
 * @param array $extensions
 * @param int   $limit
 *
 * @return array|bool
 */
function getFilesFromDirectory($directory, $extensions = array('csv'), $limit = 0)
{
    $date_format = 'Y-m-d H:i:s';
    $extensions = implode($extensions, ',');

    $glob_search = $directory . '*.{' . $extensions . '}';
    $files = glob($glob_search, GLOB_BRACE);

    if ( ! $files) {
        return FALSE;
    }

    $files = array_combine($files, array_map('filemtime', $files));
    arsort($files);

    if ($limit) {
        $files = array_slice($files, 0, $limit);
    }

    $file_list = array();

    foreach ($files as $k => $v) {
        $file_list[] = (object) array(
            'name' => str_replace($directory, '', $k),
            'path' => $k,
            'time' => date($date_format, $v),
        );
    }

    return $file_list;
}
?>