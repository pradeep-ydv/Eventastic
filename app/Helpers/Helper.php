<?php

if (!function_exists('sanitize_string')) {
    function sanitize_string($var = '')
    {
        if (empty($var)) {
            return $var;
        }

        if (is_array($var)) {
            foreach ($var as $key => $value) {
                $var[$key] = sanitize_string($value);
            }
            return $var;
        }

        $var = trim($var);
        $var = stripslashes($var);
        $var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
        return $var;
    }
}

if (!function_exists('array_to_object')) {
    function array_to_object($array)
    {
        if (!is_array($array) && !is_object($array)) {
            return new \stdClass();
        }
        return json_decode(json_encode((object)$array));
    }
}

if (!function_exists('formated_time')) {
    function formated_time($targetDate)
    {
        $dateFormat = date('d-m-Y H:i:s');

        if (empty($targetDate)) {
            return "Unknown";
        }

        // Current time as MySQL datetime value
        $currentDateTime = date('Y-m-d H:i:s');
        // Target time as Unix timestamp
        $targetTimestamp = strtotime($targetDate);
        $currentTimestamp = strtotime($currentDateTime);

        // Calculate the time difference in minutes
        $timeDifferenceInMinutes = floor(abs($currentTimestamp - $targetTimestamp) / 60);

        // Determine whether the time difference needs to be in minutes, hours, or days
        if ($timeDifferenceInMinutes < 2) {
            return "Just now";
        } elseif ($timeDifferenceInMinutes < 60) {
            return $timeDifferenceInMinutes . " minutes ago";
        } elseif ($timeDifferenceInMinutes < 120) {
            return floor(abs($timeDifferenceInMinutes / 60)) . " hour ago";
        } elseif ($timeDifferenceInMinutes < 1440) {
            return floor(abs($timeDifferenceInMinutes / 60)) . " hours ago";
        } elseif ($timeDifferenceInMinutes < 2880) {
            return floor(abs($timeDifferenceInMinutes / 1440)) . " day ago";
        } else {
            return date($dateFormat, $targetTimestamp);
        }
    }
}

if (!function_exists('include_css_cdn')) {
    function include_css_cdn()
    {
        global $css_cdn_urls;
        if (isset($css_cdn_urls) && is_array($css_cdn_urls)) {
            foreach ($css_cdn_urls as $url) {
                echo '<link href="' . base_url($url) . '" rel="stylesheet" type="text/css">' . "\n";
            }
        }
    }
}

if (!function_exists('add_css_cdn')) {

    function add_css_cdn(...$urls)
    {
        global $css_cdn_urls;
        foreach ($urls as $url) {
            $css_cdn_urls[] = $url;
        }
    }
}

if (!function_exists('include_js_cdn')) {
    function include_js_cdn()
    {
        global $js_cdn_urls;
        if (isset($js_cdn_urls) && is_array($js_cdn_urls)) {
            foreach ($js_cdn_urls as $url) {
                echo '<script src="' . base_url($url) . '"></script>' . "\n";
            }
        }
    }
}

if (!function_exists('add_js_cdn')) {

    function add_js_cdn(...$urls)
    {
        global $js_cdn_urls;
        foreach ($urls as $url) {
            $js_cdn_urls[] = $url;
        }
    }
}

if (!function_exists('printArr')) {

    /**
     * Prints an array or object in a readable format.
     *
     * @param mixed $data The data to be printed.
     * @return void
     */
    function printArr($data)
    {
        // Open a <pre> tag for formatted output
        echo "<pre>";

        // Print the data in a readable format
        print_r($data);

        // Close the <pre> tag
        echo "</pre>";
    }
}