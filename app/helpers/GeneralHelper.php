<?php

namespace App\Helpers;

class GeneralHelper
{
    public function dump($data = null, $split_values = true, $prettify = true, $die = false)
    {
        $style = $prettify ? "background-color: #ccc;padding: 12px;border-radius: 4px;" : "";
        if ($prettify) {
            if ($split_values) {
                if (is_array($data)) {
                    foreach ($data as $part) {
                        echo "<pre style=\"$style\">";
                        print_r($part);
                        echo "</pre>";
                        echo "<br>";
                    }
                } else {
                    echo "<pre style=\"$style\">";
                    print_r($data);
                    echo "</pre>";
                }
            } else {
                echo "<pre style=\"$style\">";
                print_r($data);
                echo "</pre>";
            }
        } else {
            if ($split_values) {
                if (is_array($data)) {
                    foreach ($data as $part) {
                        var_dump($data);
                        echo "<br>";
                    }
                } else {
                    var_dump($data);
                }
            } else {
                var_dump($data);
            }
        }
        if ($die) die();
    }

    public function dd($data = null, $split_values = true, $prettify = true)
    {
        $this->dump($data, $split_values, $prettify, true);
    }
}
