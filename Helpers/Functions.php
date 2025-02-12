<?php
namespace Helpers;

class Functions {
    public static function view($path, $data = []) {
        extract($data);
        require \base_path("Views/$path");
    }
}
