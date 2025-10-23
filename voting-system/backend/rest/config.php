<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ (E_NOTICE | E_DEPRECATED));

class Config{
    private static $db_config = null;
    public static function DB() {
        if (self::$db_config !== null) {
            return self::$db_config;
        }
        
        $dbUrl = getenv('DB_URL');
        if (!$dbUrl) {
            throw new Exception("DB_URL environment variable not set");
        }
        
        $components = parse_url($dbUrl);
        
        self::$db_config = [
            'host' => $components['host'] ?? null,
            'user' => $components['user'] ?? null,
            'pass' => $components['pass'] ?? null,
            'port' => $components['port'] ?? 3306,
            'name' => ltrim($components['path'] ?? '', '/')
        ];
        
        return self::$db_config;
    }
    
    // Helper methods for accessing DB config
    public static function DB_HOST() {
        $config = self::DB();
        return $config['host'];
    }
    
    public static function DB_USER() {
        $config = self::DB();
        return $config['user'];
    }
    
    public static function DB_PASSWORD() {
        $config = self::DB();
        return $config['pass'];
    }
    
    public static function DB_PORT() {
        $config = self::DB();
        return $config['port'];
    }
    
    public static function DB_NAME() {
        $config = self::DB();
        return $config['name'];
    }
    
    public static function JWT_SECRET(){
        return Config::get_env("JWT_SECRET", "fc69a388fe84b7052d2c5b8636f61cfdbb797e6455b77128d16376536d3fdf170bd9e6f7635da29bfc4a050a7e96484c3afde70c78806bce643ec88058cc3f350dd9806431cc97e3d17b023e3e2f431f7e91517ea622dec09b84d3e2014632669df097ab6a8e6962f89edf7dbe95523f972e14133b8023d7d723067b5356009a0f632e9b9c49786cba4ddf7c20fac40e628f5853876af83a67a4f969ff3a8581b3a9e4c4887d2f327dad2b2ea8b6d08ec98a433f7edeb7949f24ddc803c9da65ac23c21ec6ee4021a2a41ab3de3d7f9bd223f18762ffa9c109897313210da37c1153118093e07d99db87ffb0ba42851f710a74ea6380b5ca874cfba704a30a5a");
    }
    
    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name])!="" ? $_ENV[$name] : $default;
    }
}