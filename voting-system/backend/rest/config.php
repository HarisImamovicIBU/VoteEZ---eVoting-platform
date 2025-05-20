<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));
class Config{
    public static function DB_NAME(){
        return "voting_system_db";
    }
    public static function DB_PORT(){
        return 3306;
    }
    public static function DB_USER(){
        return "root";
    }
    public static function DB_PASSWORD(){
        return 11235813;
    }
    public static function DB_HOST(){
        return "127.0.0.1";
    }
    public static function JWT_SECRET(){
        return "zf2d56d23e735cb104bd1fzb65924c9d6b1764z8c02ce7a3c21a849dz7808ddc198b862737z538efc31ea13383e012769z6d683767397d0754639c99783d539ac92e125653bf30a3603z02713f8d8aa4b96b4be4a2018b0dz49cf91c8fc9e6674fdc480b627az417a2bc038e8870zdd7e41f02742e33f425sfe1a87327fb9ef3675f2739763f1x97998705d4b24b9e284223912fd8af8abe46d5355d855e5855x0ed03cd6535dacc11162f208e966cdda4c6fe9824730408770f08e38e708dc8543f874d23c8595e22a48d45236b3b45b1ab60dbbb41c1f801xb5700019b01a47fdcb0aa9c73e0ekef396ecaf18423d6dc90ebbcd5f1dicbc1e08119e4d90cax";
    }
}