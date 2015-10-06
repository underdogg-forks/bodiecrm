<?php

    /**
     * Return an array from string segmented by separator
     *
     * @param  String $separator
     * @param  String $string
     * @return Array
     */
    function get_array_from_string($separator = ',', $string)
    {
        $array     = explode(',', $string);
        $new_array = [];

        foreach ( $array as $key => $value) {
            $new_array[$key] = trim($value);
        }

        return $new_array;
    }
?>