<?php
class FileHelper {
    private static $folder = __DIR__ . "/../public/uploads/";

    public static function uploadFile($origin, $destiny) {
        if (!is_dir(self::$folder)) {
            mkdir(self::$folder, 0777, true);
        }

        $name = basename($destiny);
        $target = self::$folder . $name;

        if (move_uploaded_file($origin, $target)) {
            return true;
        }

        return false;
    }
}