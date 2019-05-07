<?php

if (!function_exists('thumbnail')) {
    /**
     * Returns a thumbnail path
     *
     * @param string $path
     *
     * @param string $thumbnail
     *
     * @return string a thumbnail path
     *
     * */
    function thumbnail($path, $thumbnail)
    {
        return $thumbnail . '-' . $path;
 
    }
}