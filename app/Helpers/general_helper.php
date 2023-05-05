<?php
if (!function_exists('load_js')) {
  if (!function_exists('load_js')) {

    function load_js(array $array)
    {
      foreach ($array as $uri) {
        echo "<script type='text/javascript'  src='" . base_url($uri) . "'></script>";
      }
    }
  }
}

if (!function_exists('load_css')) {

  function load_css(array $array)
  {
    foreach ($array as $uri) {
      echo "<link rel='stylesheet' type='text/css' href='" . base_url($uri) . "' />";
    }
  }
}
