<?php

use Illuminate\Support\Str;

// Build a map of PDO MySQL attribute constants to use the namespaced
// variants introduced in PHP 8.5 when available, falling back to the
// legacy `PDO::...` constants to avoid deprecation warnings.
$mysqlPdoConstMap = [];
if (class_exists(\Pdo\Mysql::class)) {
    // namespaced constants (PHP 8.5+)
    foreach ([
        'ATTR_SSL_CA' => 'MYSQL_ATTR_SSL_CA',
        'ATTR_SSL_CERT' => 'MYSQL_ATTR_SSL_CERT',
        'ATTR_SSL_KEY' => 'MYSQL_ATTR_SSL_KEY',
        'ATTR_SSL_CIPHER' => 'MYSQL_ATTR_SSL_CIPHER',
        'ATTR_SSL_VERIFY_SERVER_CERT' => 'MYSQL_ATTR_SSL_VERIFY_SERVER_CERT',
    ] as $ns => $legacy) {
        $const = \Pdo\Mysql::class."::$ns";
        if (defined($const)) {
            $mysqlPdoConstMap[$legacy] = constant($const);
        }
    }
}

// Fallback to legacy PDO constants if namespaced ones are not available
foreach ([
    'MYSQL_ATTR_SSL_CA',
    'MYSQL_ATTR_SSL_CERT',
    'MYSQL_ATTR_SSL_KEY',
    'MYSQL_ATTR_SSL_CIPHER',
    'MYSQL_ATTR_SSL_VERIFY_SERVER_CERT',
] as $legacyConst) {
    if (! isset($mysqlPdoConstMap[$legacyConst]) && defined('PDO::'.$legacyConst)) {
        $mysqlPdoConstMap[$legacyConst] = constant('PDO::'.$legacyConst);
    }
}

// Build options array from environment variables (if present).
$mysqlPdoOptions = [];
foreach ($mysqlPdoConstMap as $envName => $constKey) {
    // Environment variable names follow the pattern MYSQL_ATTR_<...>
    $value = env($envName);
    if (! empty($value)) {
        $mysqlPdoOptions[$constKey] = $value;
    }
}

// Helper to resolve a namespaced PDO driver constant then fallback to legacy PDO::CONST
$resolvePdoConst = function ($driverClass, $constName, $legacyConstName) {
    if (class_exists($driverClass)) {
        $fqcn = $driverClass.'::'.$constName;
        if (defined($fqcn)) {
            return constant($fqcn);
        }
    }
    $legacy = 'PDO::'.$legacyConstName;
    if (defined($legacy)) {
        return constant($legacy);
    }
    return null;
};

// Build pgsql options (example: PGSQL_ATTR_DISABLE_PREPARES)
$pgsqlOptions = [];
$pgDisablePrepares = $resolvePdoConst(\Pdo\Pgsql::class, 'ATTR_DISABLE_PREPARES', 'PGSQL_ATTR_DISABLE_PREPARES');
if ($pgDisablePrepares && env('PGSQL_ATTR_DISABLE_PREPARES') !== null) {
    $pgsqlOptions[$pgDisablePrepares] = env('PGSQL_ATTR_DISABLE_PREPARES');
}

// Build sqlsrv options (example: SQLSRV_ATTR_ENCODING)
$sqlsrvOptions = [];
$sqlsrvEncoding = $resolvePdoConst(\Pdo\Sqlsrv::class, 'ATTR_ENCODING', 'SQLSRV_ATTR_ENCODING');
if ($sqlsrvEncoding && env('SQLSRV_ATTR_ENCODING') !== null) {
    $sqlsrvOptions[$sqlsrvEncoding] = env('SQLSRV_ATTR_ENCODING');
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for database operations. This is
    | the connection which will be utilized unless another connection
    | is explicitly specified when you execute a query / statement.
    |
    */

    'default' => env('DB_CONNECTION', 'sqlite'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Below are all of the database connections defined for your application.
    | An example configuration is provided for each database system which
    | is supported by Laravel. You're free to add / remove connections.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DB_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter($mysqlPdoOptions) : [],
        ],

        'mariadb' => [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter($mysqlPdoOptions) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
            'options' => extension_loaded('pdo_pgsql') ? array_filter($pgsqlOptions) : [],
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'laravel'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => '',
            'prefix_indexes' => true,
            'options' => extension_loaded('pdo_sqlsrv') ? array_filter($sqlsrvOptions) : [],
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run on the database.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as Memcached. You may define your connection settings here.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
            'persistent' => env('REDIS_PERSISTENT', false),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
