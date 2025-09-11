<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

// 获取微秒时间的函数
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}

// 记录脚本开始时间
$time_start = microtime_float();

// 语言检测和设置
function detectLanguage() {
    // 检查浏览器语言设置
    $lang = 'en'; // 默认英文
    
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $browserLang = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        // 检查是否包含中文
        if (strpos($browserLang, 'zh') !== false || strpos($browserLang, 'cn') !== false) {
            $lang = 'zh';
        }
    }
    
    // URL参数可以覆盖自动检测
    if (isset($_GET['lang'])) {
        $lang = $_GET['lang'] === 'zh' ? 'zh' : 'en';
    }
    
    return $lang;
}

// 语言包
function getLanguagePack($lang) {
    $languages = array(
        'zh' => array(
            'title' => 'PHP服务器探针',
            'subtitle' => 'Server Probe Dashboard',
            'website' => 'OpenLXMP官网',
            'github' => 'GitHub项目',
            'server_info' => '服务器基本信息',
            'cpu_model' => 'CPU型号',
            'cpu_cores' => 'CPU核数',
            'system_load' => '系统负载',
            'server_time' => '服务器时间',
            'uptime' => '运行时间',
            'current_user' => '当前用户',
            'server_domain' => '服务器域名/IP地址',
            'server_hostname' => '服务器主机名',
            'operating_system' => '操作系统',
            'web_server' => 'Web服务器',
            'server_port' => '服务端口',
            'admin' => '管理员邮箱',
            'memory_usage' => '内存使用情况',
            'total_memory' => '总内存',
            'used_memory' => '已使用',
            'cached_memory' => '缓存',
            'buffer_memory' => '缓冲区',
            'swap_total' => 'Swap总量',
            'swap_used' => 'Swap已使用',
            'disk_space' => '磁盘空间',
            'total_space' => '总空间',
            'used_space' => '已使用',
            'free_space' => '剩余空间',
            'script_path' => '脚本路径',
            'network_monitor' => '网络流量监控',
            'download_traffic' => '下载流量',
            'upload_traffic' => '上传流量',
            'download_speed' => '下载速率',
            'upload_speed' => '上传速率',
            'php_config' => 'PHP配置信息',
            'php_version' => 'PHP版本',
            'run_mode' => '运行方式',
            'zend_engine' => 'Zend引擎',
            'safe_mode' => '安全模式',
            'register_globals' => '自动定义全局变量',
            'allow_url_fopen' => '允许URL打开文件',
            'enable_dl' => '允许动态加载链接库',
            'display_errors' => '显示错误信息',
            'short_open_tag' => '短标记支持',
            'asp_tags' => 'ASP标记支持',
            'ignore_repeated_errors' => '忽略重复错误',
            'magic_quotes_gpc' => '自动字符串转义',
            'magic_quotes_runtime' => '外部字符串转义',
            'cookie_support' => 'Cookie支持',
            'session_support' => 'Session支持',
            'precision' => '浮点精度',
            'float_precision' => '浮点精度',
            'max_execution_time' => '最长执行时间',
            'socket_timeout' => 'Socket超时',
            'memory_limit' => '内存限制',
            'post_max_size' => 'POST最大大小',
            'upload_max_filesize' => '上传文件限制',
            'smtp_support' => 'SMTP支持',
            'disabled_functions' => '被禁用的函数',
            'no_disabled_functions' => '无禁用函数',
            'php_features' => 'PHP功能',
            'builtin_functions' => '内置函数列表',
            'view_details' => '查看详情',
            'php_config_info' => 'PHP配置信息',
            'view_phpinfo' => '查看PHPINFO',
            'php_modules' => 'PHP模块支持',
            'function_tests' => '功能测试',
            'mysql_connection' => 'MySQL数据库连接检测',
            'server_address' => '服务器地址',
            'port' => '端口',
            'username' => '用户名',
            'password' => '密码',
            'connection_test' => '连接测试',
            'function_detection' => '函数检测',
            'function_name' => '函数名',
            'function_test' => '函数检测',
            'function_examples' => '常用函数示例：curl_init, imagecreate, gd_info, fsockopen, mail, mysqli_connect 等',
            'email_test' => '邮件发送检测',
            'email_address' => '邮件地址',
            'email_test_btn' => '邮件测试',
            'email_note' => '注意：需要服务器配置邮件发送功能才能正常工作',
            'execution_time' => '脚本执行时间',
            'memory_usage_footer' => '内存使用',
            'memory_peak' => '内存峰值',
            'php_version_footer' => 'PHP版本',
            'copyright' => 'OpenLXMP',
            'official_website' => '官网',
            'github_project' => 'GitHub',
            'footer_desc' => 'PHP服务器探针 - 专为OpenLXMP环境优化设计',
            'seconds' => '秒',
            'days' => '天',
            'hours' => '小时',
            'minutes' => '分钟',
            'testing_connection' => '正在测试连接...',
            'testing_function' => '正在检测函数...',
            'sending_email' => '正在发送测试邮件...',
            'test_failed' => '测试失败',
            'mysql_username_required' => '用户名不能为空',
            'function_name_required' => '请输入要检测的函数名',
            'email_required' => '请输入邮件地址',
            'invalid_email' => '邮件地址格式不正确'
        ),
        'en' => array(
            'title' => 'PHP Server Probe',
            'subtitle' => 'Server Probe Dashboard',
            'website' => 'OpenLXMP Website',
            'github' => 'GitHub Project',
            'server_info' => 'Server Information',
            'cpu_model' => 'CPU Model',
            'cpu_cores' => 'CPU Cores',
            'system_load' => 'System Load',
            'server_time' => 'Server Time',
            'uptime' => 'Uptime',
            'current_user' => 'Current User',
            'server_domain' => 'Server Domain/IP',
            'server_hostname' => 'Server Hostname',
            'operating_system' => 'Operating System',
            'web_server' => 'Web Server',
            'server_port' => 'Server Port',
            'admin' => 'Admin Email',
            'memory_usage' => 'Memory Usage',
            'total_memory' => 'Total Memory',
            'used_memory' => 'Used',
            'cached_memory' => 'Cached',
            'buffer_memory' => 'Buffers',
            'swap_total' => 'Swap Total',
            'swap_used' => 'Swap Used',
            'disk_space' => 'Disk Space',
            'total_space' => 'Total Space',
            'used_space' => 'Used',
            'free_space' => 'Free Space',
            'script_path' => 'Script Path',
            'network_monitor' => 'Network Traffic Monitor',
            'download_traffic' => 'Download Traffic',
            'upload_traffic' => 'Upload Traffic',
            'download_speed' => 'Download Speed',
            'upload_speed' => 'Upload Speed',
            'php_config' => 'PHP Configuration',
            'php_version' => 'PHP Version',
            'run_mode' => 'Run Mode',
            'zend_engine' => 'Zend Engine',
            'safe_mode' => 'Safe Mode',
            'register_globals' => 'Register Globals',
            'allow_url_fopen' => 'Allow URL fopen',
            'enable_dl' => 'Enable DL',
            'display_errors' => 'Display Errors',
            'short_open_tag' => 'Short Open Tag',
            'asp_tags' => 'ASP Tags',
            'ignore_repeated_errors' => 'Ignore Repeated Errors',
            'magic_quotes_gpc' => 'Magic Quotes GPC',
            'magic_quotes_runtime' => 'Magic Quotes Runtime',
            'cookie_support' => 'Cookie Support',
            'session_support' => 'Session Support',
            'precision' => 'Precision',
            'float_precision' => 'Float Precision',
            'max_execution_time' => 'Max Execution Time',
            'socket_timeout' => 'Socket Timeout',
            'memory_limit' => 'Memory Limit',
            'post_max_size' => 'POST Max Size',
            'upload_max_filesize' => 'Upload Max Filesize',
            'smtp_support' => 'SMTP Support',
            'disabled_functions' => 'Disabled Functions',
            'no_disabled_functions' => 'No Disabled Functions',
            'php_features' => 'PHP Features',
            'builtin_functions' => 'Built-in Functions',
            'view_details' => 'View Details',
            'php_config_info' => 'PHP Configuration',
            'view_phpinfo' => 'View PHPINFO',
            'php_modules' => 'PHP Modules Support',
            'function_tests' => 'Function Tests',
            'mysql_connection' => 'MySQL Database Connection Test',
            'server_address' => 'Server Address',
            'port' => 'Port',
            'username' => 'Username',
            'password' => 'Password',
            'connection_test' => 'Connection Test',
            'function_detection' => 'Function Detection',
            'function_name' => 'Function Name',
            'function_test' => 'Function Test',
            'function_examples' => 'Common functions: curl_init, imagecreate, gd_info, fsockopen, mail, mysqli_connect, etc.',
            'email_test' => 'Email Sending Test',
            'email_address' => 'Email Address',
            'email_test_btn' => 'Email Test',
            'email_note' => 'Note: Server must be configured for email sending to work properly',
            'execution_time' => 'Script Execution Time',
            'memory_usage_footer' => 'Memory Usage',
            'memory_peak' => 'Memory Peak',
            'php_version_footer' => 'PHP Version',
            'copyright' => 'OpenLXMP',
            'official_website' => 'Website',
            'github_project' => 'GitHub',
            'footer_desc' => 'PHP Server Probe - Optimized for OpenLXMP Environment',
            'seconds' => 'seconds',
            'days' => ' days',
            'hours' => ' hours',
            'minutes' => ' minutes',
            'testing_connection' => 'Testing connection...',
            'testing_function' => 'Testing function...',
            'sending_email' => 'Sending test email...',
            'test_failed' => 'Test failed',
            'mysql_username_required' => 'Username cannot be empty',
            'function_name_required' => 'Please enter function name',
            'email_required' => 'Please enter email address',
            'invalid_email' => 'Invalid email format'
        )
    );
    
    return $languages[$lang];
}

// 设置当前语言
$current_lang = detectLanguage();
$lang = getLanguagePack($current_lang);

class PHPProbe {
    private $network_stats = array();
    private $prev_stats = array();
    public static $start_time;
    
    public function __construct() {
        // 如果还没有记录开始时间，使用全局变量
        global $time_start;
        if (!self::$start_time) {
            self::$start_time = $time_start ? $time_start : microtime_float();
        }
        session_start();
        $this->initNetworkStats();
    }
    
    private function initNetworkStats() {
        if (isset($_SESSION['network_stats'])) {
            $this->prev_stats = $_SESSION['network_stats'];
        }
        $this->network_stats = $this->getNetworkStats();
        $_SESSION['network_stats'] = $this->network_stats;
    }
    
    private function getCPUInfo() {
        $cpu_info = array('model' => 'Unknown', 'cores' => 'Unknown');
        
        if (file_exists('/proc/cpuinfo')) {
            $cpuinfo = file_get_contents('/proc/cpuinfo');
            if (preg_match('/model name\s*:\s*(.+)/i', $cpuinfo, $matches)) {
                $cpu_info['model'] = trim($matches[1]);
            }
            $cpu_info['cores'] = substr_count($cpuinfo, 'processor');
        } elseif (stripos(PHP_OS, 'WIN') === 0) {
            $wmi = shell_exec('wmic cpu get name /value');
            if (preg_match('/Name=(.+)/i', $wmi, $matches)) {
                $cpu_info['model'] = trim($matches[1]);
            }
            $cores = shell_exec('wmic cpu get NumberOfCores /value');
            if (preg_match('/NumberOfCores=(\d+)/i', $cores, $matches)) {
                $cpu_info['cores'] = intval($matches[1]);
            }
        } elseif (stripos(PHP_OS, 'Darwin') === 0) {
            $cpu_info['model'] = trim(shell_exec('sysctl -n machdep.cpu.brand_string'));
            $cpu_info['cores'] = intval(shell_exec('sysctl -n hw.ncpu'));
        }
        
        return $cpu_info;
    }
    
    public function getSystemLoad() {
        $load = array(0, 0, 0);
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
        } elseif (file_exists('/proc/loadavg')) {
            $loadavg = file_get_contents('/proc/loadavg');
            $load = explode(' ', $loadavg);
        }
        return array_slice($load, 0, 3);
    }
    
    public function getMemoryInfo() {
        $memory = array(
            'total' => 0,
            'free' => 0,
            'used' => 0,
            'cached' => 0,
            'buffers' => 0,
            'swap_total' => 0,
            'swap_used' => 0,
            'swap_free' => 0
        );
        
        if (file_exists('/proc/meminfo')) {
            $meminfo = file_get_contents('/proc/meminfo');
            preg_match_all('/(\w+):\s*(\d+)\s*kB/i', $meminfo, $matches, PREG_SET_ORDER);
            
            foreach ($matches as $match) {
                $key = strtolower($match[1]);
                $value = intval($match[2]) * 1024;
                
                switch ($key) {
                    case 'memtotal': $memory['total'] = $value; break;
                    case 'memfree': $memory['free'] = $value; break;
                    case 'cached': $memory['cached'] = $value; break;
                    case 'buffers': $memory['buffers'] = $value; break;
                    case 'swaptotal': $memory['swap_total'] = $value; break;
                    case 'swapfree': $memory['swap_free'] = $value; break;
                }
            }
            $memory['used'] = $memory['total'] - $memory['free'] - $memory['cached'] - $memory['buffers'];
            $memory['swap_used'] = $memory['swap_total'] - $memory['swap_free'];
        }
        
        return $memory;
    }
    
    private function getNetworkStats() {
        $interfaces = array();
        
        if (file_exists('/proc/net/dev')) {
            $content = file_get_contents('/proc/net/dev');
            $lines = explode("\n", $content);
            $current_time = microtime(true); // 使用更精确的时间戳
            
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    $parts = preg_split('/[\s:]+/', trim($line));
                    $interface = $parts[0];
                    
                    if (!preg_match('/^(lo|docker|veth|br-)/i', $interface) && isset($parts[1]) && isset($parts[9])) {
                        $interfaces[$interface] = array(
                            'rx_bytes' => intval($parts[1]),
                            'tx_bytes' => intval($parts[9]),
                            'time' => $current_time // 统一使用相同的时间戳
                        );
                    }
                }
            }
        }
        
        return $interfaces;
    }
    
    public function calculateNetworkSpeed() {
        $speeds = array();
        
        // 如果没有当前网络统计数据，返回空数组
        if (empty($this->network_stats)) {
            return $speeds;
        }
        
        foreach ($this->network_stats as $interface => $current) {
            if (isset($this->prev_stats[$interface])) {
                $prev = $this->prev_stats[$interface];
                $time_diff = $current['time'] - $prev['time'];
                
                // 确保时间差大于0且有意义（避免过小的时间差导致不准确的速率）
                if ($time_diff >= 0.5) { // 至少0.5秒的时间差
                    $rx_bytes_diff = $current['rx_bytes'] - $prev['rx_bytes'];
                    $tx_bytes_diff = $current['tx_bytes'] - $prev['tx_bytes'];
                    
                    $rx_speed = $rx_bytes_diff / $time_diff;
                    $tx_speed = $tx_bytes_diff / $time_diff;
                    
                    $speeds[$interface] = array(
                        'rx_speed' => max(0, $rx_speed),
                        'tx_speed' => max(0, $tx_speed),
                        'rx_total' => $current['rx_bytes'],
                        'tx_total' => $current['tx_bytes'],
                        'time_diff' => $time_diff, // 添加调试信息
                        'rx_diff' => $rx_bytes_diff,
                        'tx_diff' => $tx_bytes_diff
                    );
                } else {
                    // 时间差太小时，保留之前的速率（如果存在）或设为0
                    $prev_speed_data = isset($_SESSION['prev_speed'][$interface]) ? $_SESSION['prev_speed'][$interface] : null;
                    
                    $speeds[$interface] = array(
                        'rx_speed' => $prev_speed_data ? $prev_speed_data['rx_speed'] : 0,
                        'tx_speed' => $prev_speed_data ? $prev_speed_data['tx_speed'] : 0,
                        'rx_total' => $current['rx_bytes'],
                        'tx_total' => $current['tx_bytes'],
                        'time_diff' => $time_diff,
                        'rx_diff' => 0,
                        'tx_diff' => 0
                    );
                }
            } else {
                // 首次获取数据时，速率为0
                $speeds[$interface] = array(
                    'rx_speed' => 0,
                    'tx_speed' => 0,
                    'rx_total' => $current['rx_bytes'],
                    'tx_total' => $current['tx_bytes'],
                    'time_diff' => 0,
                    'rx_diff' => 0,
                    'tx_diff' => 0
                );
            }
        }
        
        // 保存当前速率数据供下次使用
        if (!empty($speeds)) {
            $_SESSION['prev_speed'] = $speeds;
        }
        
        return $speeds;
    }
    
    public function formatBytes($bytes) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
    
    private function getDiskSpace() {
        $total = disk_total_space('.');
        $free = disk_free_space('.');
        return array(
            'total' => $total,
            'free' => $free,
            'used' => $total - $free
        );
    }
    
    private function getServerInfo() {
        // 获取域名和IP地址
        $domain = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown';
        $ip = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : (isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : 'Unknown');
        
        // 合并域名和IP显示
        if ($domain !== 'Unknown' && $ip !== 'Unknown') {
            $domain_ip = $domain . '(' . $ip . ')';
        } elseif ($domain !== 'Unknown') {
            $domain_ip = $domain;
        } elseif ($ip !== 'Unknown') {
            $domain_ip = $ip;
        } else {
            $domain_ip = 'Unknown';
        }
        
        // 获取主机名
        $hostname = 'Unknown';
        if (function_exists('gethostname')) {
            $hostname = gethostname();
        } elseif (function_exists('php_uname')) {
            $hostname = php_uname('n');
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            $hostname = $_SERVER['SERVER_NAME'];
        }
        
        // 获取管理员邮箱（只有Apache才有，Nginx没有）
        $admin_email = '';
        if (isset($_SERVER['SERVER_ADMIN']) && !empty($_SERVER['SERVER_ADMIN'])) {
            $admin_email = $_SERVER['SERVER_ADMIN'];
        }
        
        return array(
            'server_time' => date('Y-m-d H:i:s'),
            'server_domain_ip' => $domain_ip,
            'server_hostname' => $hostname,
            'os' => php_uname(),
            'uptime' => $this->getUptime(),
            'encoding' => mb_internal_encoding(),
            'web_server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'Unknown',
            'server_port' => isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 'Unknown',
            'admin_email' => $admin_email,
            'document_root' => isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : 'Unknown',
            'script_filename' => isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : __FILE__,
            'current_user' => function_exists('get_current_user') ? get_current_user() : 'Unknown'
        );
    }
    
    private function getUptime() {
        global $lang;
        
        if (file_exists('/proc/uptime')) {
            $uptime = floatval(file_get_contents('/proc/uptime'));
            $days = floor($uptime / 86400);
            $hours = floor(($uptime % 86400) / 3600);
            $minutes = floor(($uptime % 3600) / 60);
            
            // 使用语言包中的时间单位
            $day_unit = isset($lang['days']) ? $lang['days'] : 'days';
            $hour_unit = isset($lang['hours']) ? $lang['hours'] : 'hours';
            $minute_unit = isset($lang['minutes']) ? $lang['minutes'] : 'minutes';
            
            return sprintf('%d%s %d%s %d%s', $days, $day_unit, $hours, $hour_unit, $minutes, $minute_unit);
        }
        return 'Unknown';
    }
    
    private function getPHPFeatures() {
        global $lang;
        $features = array();
        
        $features[$lang['php_version']] = PHP_VERSION;
        $features[$lang['run_mode']] = php_sapi_name();
        $features[$lang['zend_engine']] = zend_version();
        $features[$lang['safe_mode']] = (version_compare(PHP_VERSION, '5.4.0', '<') && ini_get('safe_mode')) ? true : false;
        $features[$lang['register_globals']] = (function_exists('ini_get') && ini_get('register_globals')) ? true : false;
        $features[$lang['allow_url_fopen']] = ini_get('allow_url_fopen') ? true : false;
        $features[$lang['enable_dl']] = (function_exists('dl') && ini_get('enable_dl')) ? true : false;
        $features[$lang['display_errors']] = ini_get('display_errors') ? true : false;
        $features[$lang['short_open_tag']] = ini_get('short_open_tag') ? true : false;
        $features[$lang['asp_tags']] = (version_compare(PHP_VERSION, '7.0.0', '<') && ini_get('asp_tags')) ? true : false;
        $features[$lang['ignore_repeated_errors']] = ini_get('ignore_repeated_errors') ? true : false;
        $features[$lang['magic_quotes_gpc']] = (version_compare(PHP_VERSION, '5.4.0', '<') && get_magic_quotes_gpc()) ? true : false;
        $features[$lang['magic_quotes_runtime']] = (version_compare(PHP_VERSION, '5.4.0', '<') && get_magic_quotes_runtime()) ? true : false;
        $features[$lang['cookie_support']] = isset($_COOKIE) ? true : false;
        $features[$lang['session_support']] = function_exists('session_start') ? true : false;
        $features[$lang['float_precision']] = ini_get('precision');
        $features[$lang['max_execution_time']] = ini_get('max_execution_time') . ' ' . $lang['seconds'];
        $features[$lang['socket_timeout']] = ini_get('default_socket_timeout') . ' ' . $lang['seconds'];
        $features[$lang['memory_limit']] = ini_get('memory_limit');
        $features[$lang['post_max_size']] = ini_get('post_max_size');
        $features[$lang['upload_max_filesize']] = ini_get('upload_max_filesize');
        $features[$lang['smtp_support']] = ini_get('SMTP') ? true : false;
        
        return $features;
    }
    
    private function getDisabledFunctions() {
        $disabled = ini_get('disable_functions');
        return $disabled ? explode(',', str_replace(' ', '', $disabled)) : array();
    }
    
    private function getPHPModules() {
        $modules = array(
            'cURL' => extension_loaded('curl'),
            'Exif' => extension_loaded('exif'),
            'Fileinfo' => extension_loaded('fileinfo'),
            'FTP' => extension_loaded('ftp'),
            'XML' => extension_loaded('xml'),
            'Graphics Magick' => extension_loaded('gmagick'),
            'Image Magick' => extension_loaded('imagick'),
            'ionCube' => extension_loaded('ionCube Loader'),
            'LDAP' => extension_loaded('ldap'),
            'Memcache' => extension_loaded('memcache'),
            'Memcached' => extension_loaded('memcached'),
            'Multibyte String' => extension_loaded('mbstring'),
            'MySQLi' => extension_loaded('mysqli'),
            'Opcache' => extension_loaded('opcache'),
            'Opcache enabled' => (extension_loaded('opcache') && ini_get('opcache.enable')),
            'Opcache JIT enabled' => (extension_loaded('opcache') && version_compare(PHP_VERSION, '8.0.0', '>=') && ini_get('opcache.jit')),
            'Phalcon' => extension_loaded('phalcon'),
            'Redis' => extension_loaded('redis'),
            'SimpleXML' => extension_loaded('simplexml'),
            'Sockets' => extension_loaded('sockets'),
            'Source Guardian' => extension_loaded('sourceguardian'),
            'SQLite3' => extension_loaded('sqlite3'),
            'SQLite' => extension_loaded('sqlite'),
            'Swoole' => extension_loaded('swoole'),
            'Xdebug' => extension_loaded('xdebug'),
            'Zend Optimizer' => (extension_loaded('Zend Optimizer') || extension_loaded('Zend OPcache')),
            'Zip' => extension_loaded('zip'),
            'MongoDB' => extension_loaded('mongodb'),
            'PostgreSQL' => extension_loaded('pgsql'),
            'MSSQL' => (extension_loaded('mssql') || extension_loaded('sqlsrv')),
            'PDO' => extension_loaded('pdo')
        );
        
        return $modules;
    }
    
    public function handleMySQLTest() {
        global $lang;
        header('Content-Type: application/json');
        
        $host = isset($_POST['mysql_host']) ? trim($_POST['mysql_host']) : 'localhost';
        $port = isset($_POST['mysql_port']) ? intval($_POST['mysql_port']) : 3306;
        $username = isset($_POST['mysql_user']) ? trim($_POST['mysql_user']) : '';
        $password = isset($_POST['mysql_pass']) ? $_POST['mysql_pass'] : '';
        
        $result = array('success' => false, 'message' => '');
        
        if (empty($username)) {
            $result['message'] = $lang['mysql_username_required'];
            echo json_encode($result);
            return;
        }
        
        try {
            if (extension_loaded('mysqli')) {
                $connection = new mysqli($host, $username, $password, '', $port);
                if ($connection->connect_error) {
                    $result['message'] = 'MySQL connection failed: ' . $connection->connect_error;
                } else {
                    $result['success'] = true;
                    $result['message'] = 'MySQL connection successful! Server version: ' . $connection->server_info;
                    $connection->close();
                }
            } elseif (extension_loaded('mysql')) {
                $connection = mysql_connect($host . ':' . $port, $username, $password);
                if (!$connection) {
                    $result['message'] = 'MySQL connection failed: ' . mysql_error();
                } else {
                    $result['success'] = true;
                    $result['message'] = 'MySQL connection successful! Server version: ' . mysql_get_server_info();
                    mysql_close($connection);
                }
            } elseif (extension_loaded('pdo_mysql')) {
                $dsn = "mysql:host=$host;port=$port";
                $pdo = new PDO($dsn, $username, $password);
                $result['success'] = true;
                $result['message'] = 'MySQL connection successful! (via PDO)';
            } else {
                $result['message'] = 'MySQL extensions not available (mysqli, mysql, pdo_mysql)';
            }
        } catch (Exception $e) {
            $result['message'] = 'MySQL connection failed: ' . $e->getMessage();
        }
        
        echo json_encode($result);
    }
    
    public function handleFunctionTest() {
        global $lang;
        header('Content-Type: application/json');
        
        $function_name = isset($_POST['function_name']) ? trim($_POST['function_name']) : '';
        $result = array('success' => false, 'message' => '');
        
        if (empty($function_name)) {
            $result['message'] = $lang['function_name_required'];
            echo json_encode($result);
            return;
        }
        
        if (function_exists($function_name)) {
            $result['success'] = true;
            $result['message'] = "Function '$function_name' exists and is available";
            
            // Get function information
            if (function_exists('ReflectionFunction')) {
                try {
                    $reflection = new ReflectionFunction($function_name);
                    $result['message'] .= "\nDefined in: " . ($reflection->getFileName() ?: 'Built-in function');
                    if ($reflection->isInternal()) {
                        $result['message'] .= "\nType: PHP built-in function";
                    }
                } catch (Exception $e) {
                    // Ignore reflection errors
                }
            }
        } else {
            $result['message'] = "Function '$function_name' does not exist or is not available";
        }
        
        echo json_encode($result);
    }
    
    public function handleEmailTest() {
        global $lang;
        header('Content-Type: application/json');
        
        $email = isset($_POST['test_email']) ? trim($_POST['test_email']) : '';
        $result = array('success' => false, 'message' => '');
        
        if (empty($email)) {
            $result['message'] = $lang['email_required'];
            echo json_encode($result);
            return;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result['message'] = $lang['invalid_email'];
            echo json_encode($result);
            return;
        }
        
        $subject = 'PHP Server Probe Email Test';
        $message = "This is a test email from PHP Server Probe.\n\n";
        $message .= "Send time: " . date('Y-m-d H:i:s') . "\n";
        $message .= "Server: " . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown') . "\n";
        $message .= "IP Address: " . (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'Unknown') . "\n\n";
        $message .= "If you receive this email, it means PHP's mail() function is working properly.";
        
        $headers = "From: noreply@" . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost') . "\r\n";
        $headers .= "Reply-To: noreply@" . (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost') . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        if (function_exists('mail')) {
            if (mail($email, $subject, $message, $headers)) {
                $result['success'] = true;
                $result['message'] = "Test email sent to $email, please check your mailbox";
            } else {
                $result['message'] = "Email sending failed. Possible reasons:\n1. Server SMTP not configured\n2. mail() function disabled\n3. Mail server configuration issues";
            }
        } else {
            $result['message'] = 'mail() function not available or disabled';
        }
        
        echo json_encode($result);
    }
    
    public function renderHTML() {
        global $lang, $current_lang;  // 确保语言变量可访问
        
        $cpu_info = $this->getCPUInfo();
        $load = $this->getSystemLoad();
        $memory = $this->getMemoryInfo();
        $server_info = $this->getServerInfo();
        $disk = $this->getDiskSpace();
        $network_speeds = $this->calculateNetworkSpeed();
        $php_features = $this->getPHPFeatures();
        $disabled_functions = $this->getDisabledFunctions();
        $php_modules = $this->getPHPModules();
        
        if (isset($_GET['action']) && $_GET['action'] == 'phpinfo') {
            phpinfo();
            exit;
        }
        
        if (isset($_GET['action']) && $_GET['action'] == 'functions') {
            $functions = get_defined_functions();
            echo '<h2>' . $lang['builtin_functions'] . '</h2>';
            echo '<div style="columns: 4; column-gap: 20px;">';
            foreach ($functions['internal'] as $func) {
                echo '<div>' . $func . '</div>';
            }
            echo '</div>';
            exit;
        }
        
        // 处理MySQL连接测试
        if (isset($_POST['mysql_test'])) {
            $this->handleMySQLTest();
            exit;
        }
        
        // 处理函数检测
        if (isset($_POST['function_test'])) {
            $this->handleFunctionTest();
            exit;
        }
        
        // 处理邮件发送测试
        if (isset($_POST['email_test'])) {
            $this->handleEmailTest();
            exit;
        }
        ?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang === 'zh' ? 'zh-CN' : 'en'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang['title']; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 15px;
            font-size: 14px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2em;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        
        .header p {
            margin-bottom: 10px;
            opacity: 0.9;
        }
        
        .section {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .section:last-child {
            border-bottom: none;
        }
        
        .section-title {
            font-size: 1.4em;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
            display: inline-block;
        }
        
        .grid {
            display: grid;
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .grid-2 { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
        .grid-3 { grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); }
        .grid-4 { grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); }
        
        .card {
            background: white;
            border-radius: 6px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e9ecef;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .card h3 {
            font-size: 1.1em;
            margin-bottom: 12px;
            color: #495057;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #f8f9fa;
            font-size: 0.9em;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            flex: 1;
        }
        
        .info-value {
            color: #6c757d;
            text-align: right;
            flex: 1;
        }
        
        .status-icon {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
            color: white;
            font-weight: bold;
            margin-left: 8px;
            font-size: 12px;
        }
        
        .status-enabled {
            background-color: #28a745;
        }
        
        .status-disabled {
            background-color: #6c757d;
        }
        
        .status-enabled:before {
            content: "✓";
        }
        
        .status-disabled:before {
            content: "✗";
        }
        
        .progress-bar {
            width: 100%;
            height: 16px;
            background-color: #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            margin: 4px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #28a745 0%, #20c997 50%, #ffc107 80%, #dc3545 100%);
            border-radius: 8px;
            transition: width 0.3s ease;
        }
        
        .network-interface {
            margin-bottom: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }
        
        .network-interface h4 {
            font-size: 1em;
            margin-bottom: 8px;
            color: #495057;
        }
        
        .network-speeds {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 8px;
        }
        
        .speed-item {
            text-align: center;
            padding: 6px;
            background: white;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        
        .speed-label {
            font-size: 0.75em;
            color: #6c757d;
            margin-bottom: 4px;
        }
        
        .speed-value {
            font-weight: bold;
            color: #495057;
            font-size: 0.85em;
        }
        
        .btn {
            display: inline-block;
            padding: 6px 12px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.85em;
            transition: background 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #5a6fd8;
            text-decoration: none;
        }
        
        .function-list {
            max-height: 160px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.8em;
            line-height: 1.3;
        }
        
        .refresh-info {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 15px;
            text-align: center;
            color: #1565c0;
            font-size: 0.85em;
        }
        
        .header-links a:hover {
            background: rgba(255,255,255,0.3) !important;
            text-decoration: none;
        }
        
        .language-switcher {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            font-size: 0.9em;
        }
        
        .lang-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .lang-link:hover {
            color: #764ba2;
            text-decoration: none;
        }
        
        .lang-link.active {
            color: #764ba2;
            font-weight: 600;
        }
        
        .lang-separator {
            margin: 0 8px;
            color: #ccc;
        }
        
        .footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .footer-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-bottom: 12px;
        }
        
        .footer-item {
            background: rgba(255,255,255,0.1);
            padding: 8px;
            border-radius: 4px;
        }
        
        .footer-label {
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 0.85em;
        }
        
        .footer-item > div:last-child {
            font-size: 0.9em;
        }
        
        @media (max-width: 768px) {
            body { padding: 10px; font-size: 13px; }
            .header { padding: 15px; }
            .header h1 { font-size: 1.6em; }
            .section { padding: 15px; }
            .section-title { font-size: 1.2em; margin-bottom: 12px; }
            .grid-2, .grid-3, .grid-4 { 
                grid-template-columns: 1fr; 
                gap: 12px;
            }
            .network-speeds {
                grid-template-columns: 1fr;
            }
            .header-links a {
                display: block;
                margin: 5px 0;
                padding: 6px 12px;
                font-size: 0.85em;
            }
            .footer-info {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
            .card {
                padding: 12px;
            }
            .language-switcher {
                top: 10px;
                right: 10px;
                padding: 6px 12px;
                font-size: 0.8em;
            }
            .lang-separator {
                margin: 0 5px;
            }
        }
    </style>
</head>
<body>
    <!-- 右上角语言切换器 -->
    <div class="language-switcher">
        <a href="?lang=zh" class="lang-link <?php echo $current_lang === 'zh' ? 'active' : ''; ?>">中文</a>
        <span class="lang-separator">|</span>
        <a href="?lang=en" class="lang-link <?php echo $current_lang === 'en' ? 'active' : ''; ?>">English</a>
    </div>
    
    <div class="container">
        <div class="header">
            <h1><?php echo $lang['title']; ?></h1>
            <p><?php echo $lang['subtitle']; ?></p>
            <div class="header-links" style="margin-top: 15px;">
                <a href="https://openlxmp.com" target="_blank" style="color: white; text-decoration: none; margin-right: 20px; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 5px; transition: background 0.3s;"><?php echo $lang['website']; ?></a>
                <a href="https://github.com/OpenLXMP/OpenLXMP" target="_blank" style="color: white; text-decoration: none; padding: 8px 16px; background: rgba(255,255,255,0.2); border-radius: 5px; transition: background 0.3s;"><?php echo $lang['github']; ?></a>
            </div>
        </div>
        
        <!-- 第一块：服务器信息 -->
        <div class="section">
            <h2 class="section-title"><?php echo $lang['server_info']; ?></h2>
            <div class="grid grid-2">
                <div class="card">
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['cpu_model']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($cpu_info['model']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['cpu_cores']; ?></span>
                        <span class="info-value"><?php echo $cpu_info['cores']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['system_load']; ?></span>
                        <span class="info-value" id="system-load"><?php echo implode(', ', array_map(function($l) { return number_format($l, 2); }, $load)); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['server_time']; ?></span>
                        <span class="info-value" id="server-time"><?php echo $server_info['server_time']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['uptime']; ?></span>
                        <span class="info-value"><?php echo $server_info['uptime']; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['current_user']; ?></span>
                        <span class="info-value"><?php echo $server_info['current_user']; ?></span>
                    </div>
                </div>
                
                <div class="card">
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['server_domain']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['server_domain_ip']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['server_hostname']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['server_hostname']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['operating_system']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['os']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['web_server']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['web_server']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['server_port']; ?></span>
                        <span class="info-value"><?php echo $server_info['server_port']; ?></span>
                    </div>
                    <?php if (!empty($server_info['admin_email'])): ?>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['admin']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['admin_email']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="grid grid-2">
                <div class="card">
                    <h3><?php echo $lang['memory_usage']; ?></h3>
                    <div id="memory-info">
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['total_memory']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['total']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['used_memory']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['used']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['cached_memory']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['cached']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['buffer_memory']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['buffers']); ?></span>
                        </div>
                        <?php if ($memory['swap_total'] > 0): ?>
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['swap_total']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['swap_total']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><?php echo $lang['swap_used']; ?></span>
                            <span class="info-value"><?php echo $this->formatBytes($memory['swap_used']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo ($memory['total'] > 0) ? round(($memory['used'] / $memory['total']) * 100, 1) : 0; ?>%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <h3><?php echo $lang['disk_space']; ?></h3>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['total_space']; ?></span>
                        <span class="info-value"><?php echo $this->formatBytes($disk['total']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['used_space']; ?></span>
                        <span class="info-value"><?php echo $this->formatBytes($disk['used']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['free_space']; ?></span>
                        <span class="info-value"><?php echo $this->formatBytes($disk['free']); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['script_path']; ?></span>
                        <span class="info-value"><?php echo htmlspecialchars($server_info['script_filename']); ?></span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: <?php echo ($disk['total'] > 0) ? round(($disk['used'] / $disk['total']) * 100, 1) : 0; ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 第二块：网络流量 -->
        <div class="section">
            <h2 class="section-title"><?php echo $lang['network_monitor']; ?></h2>
            <div id="network-info">
                <?php foreach ($network_speeds as $interface => $data): ?>
                <div class="network-interface">
                    <h4><?php echo htmlspecialchars($interface); ?></h4>
                    <div class="network-speeds">
                        <div class="speed-item">
                            <div class="speed-label"><?php echo $lang['download_traffic']; ?></div>
                            <div class="speed-value"><?php echo $this->formatBytes($data['rx_total']); ?></div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label"><?php echo $lang['upload_traffic']; ?></div>
                            <div class="speed-value"><?php echo $this->formatBytes($data['tx_total']); ?></div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label"><?php echo $lang['download_speed']; ?></div>
                            <div class="speed-value"><?php echo $this->formatBytes($data['rx_speed']); ?>/s</div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label"><?php echo $lang['upload_speed']; ?></div>
                            <div class="speed-value"><?php echo $this->formatBytes($data['tx_speed']); ?>/s</div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- 第三块：PHP信息 -->
        <div class="section">
            <h2 class="section-title"><?php echo $lang['php_config']; ?></h2>
            <div class="grid grid-3">
                <?php foreach ($php_features as $feature => $value): ?>
                <div class="card">
                    <div class="info-row">
                        <span class="info-label"><?php echo htmlspecialchars($feature); ?></span>
                        <?php if (is_bool($value)): ?>
                            <span class="status-icon <?php echo $value ? 'status-enabled' : 'status-disabled'; ?>"></span>
                        <?php else: ?>
                            <span class="info-value"><?php echo htmlspecialchars($value); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="grid grid-2" style="margin-top: 20px;">
                <div class="card">
                    <h3><?php echo $lang['disabled_functions']; ?></h3>
                    <?php if (empty($disabled_functions)): ?>
                        <p style="color: #28a745; text-align: center;"><?php echo $lang['no_disabled_functions']; ?></p>
                    <?php else: ?>
                        <div style="background: #f8f9fa; padding: 10px; border-radius: 4px; font-size: 0.9em; line-height: 1.4; word-wrap: break-word;">
                            <?php echo htmlspecialchars(implode(' ', array_map('trim', $disabled_functions))); ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="card">
                    <h3><?php echo $lang['php_features']; ?></h3>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['builtin_functions']; ?></span>
                        <a href="?action=functions" target="_blank" class="btn"><?php echo $lang['view_details']; ?></a>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><?php echo $lang['php_config_info']; ?></span>
                        <a href="?action=phpinfo" target="_blank" class="btn"><?php echo $lang['view_phpinfo']; ?></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 第四块：PHP模块 -->
        <div class="section">
            <h2 class="section-title"><?php echo $lang['php_modules']; ?></h2>
            <div class="grid grid-4">
                <?php foreach ($php_modules as $module => $enabled): ?>
                <div class="card">
                    <div class="info-row">
                        <span class="info-label"><?php echo htmlspecialchars($module); ?></span>
                        <span class="status-icon <?php echo $enabled ? 'status-enabled' : 'status-disabled'; ?>"></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- 第五块：功能测试 -->
        <div class="section">
            <h2 class="section-title"><?php echo $lang['function_tests']; ?></h2>
            <div class="grid grid-3">
                <!-- MySQL连接测试 -->
                <div class="card">
                    <h3><?php echo $lang['mysql_connection']; ?></h3>
                    <form id="mysql-form">
                        <div style="margin-bottom: 8px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['server_address']; ?>:</label>
                            <input type="text" name="mysql_host" value="localhost" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <div style="margin-bottom: 8px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['port']; ?>:</label>
                            <input type="number" name="mysql_port" value="3306" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <div style="margin-bottom: 8px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['username']; ?>:</label>
                            <input type="text" name="mysql_user" placeholder="<?php echo $lang['username']; ?>" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['password']; ?>:</label>
                            <input type="password" name="mysql_pass" placeholder="<?php echo $lang['password']; ?>" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <button type="submit" class="btn" style="width: 100%;"><?php echo $lang['connection_test']; ?></button>
                    </form>
                    <div id="mysql-result" style="margin-top: 12px; padding: 8px; border-radius: 4px; display: none; font-size: 0.85em;"></div>
                </div>
                
                <!-- 函数检测 -->
                <div class="card">
                    <h3><?php echo $lang['function_detection']; ?></h3>
                    <form id="function-form">
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['function_name']; ?>:</label>
                            <input type="text" name="function_name" placeholder="<?php echo $lang['function_name']; ?>" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <button type="submit" class="btn" style="width: 100%;"><?php echo $lang['function_test']; ?></button>
                    </form>
                    <div id="function-result" style="margin-top: 12px; padding: 8px; border-radius: 4px; display: none; font-size: 0.85em;"></div>
                    <div style="margin-top: 8px; font-size: 0.75em; color: #666;">
                        <?php echo $lang['function_examples']; ?>
                    </div>
                </div>
                
                <!-- 邮件发送测试 -->
                <div class="card">
                    <h3><?php echo $lang['email_test']; ?></h3>
                    <form id="email-form">
                        <div style="margin-bottom: 12px;">
                            <label style="display: block; margin-bottom: 4px; font-size: 0.85em; font-weight: 600;"><?php echo $lang['email_address']; ?>:</label>
                            <input type="email" name="test_email" placeholder="<?php echo $lang['email_address']; ?>" style="width: 100%; padding: 4px; border: 1px solid #ddd; border-radius: 3px; font-size: 0.85em;">
                        </div>
                        <button type="submit" class="btn" style="width: 100%;"><?php echo $lang['email_test_btn']; ?></button>
                    </form>
                    <div id="email-result" style="margin-top: 12px; padding: 8px; border-radius: 4px; display: none; font-size: 0.85em;"></div>
                    <div style="margin-top: 8px; font-size: 0.75em; color: #666;">
                        <?php echo $lang['email_note']; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 页面底部信息 -->
        <div class="footer">
            <div class="footer-info">
                <div class="footer-item">
                    <div class="footer-label"><?php echo $lang['execution_time']; ?></div>
                    <div id="execution-time"><?php $run_time = sprintf('%0.4f', microtime_float() - $time_start); echo $run_time . ' ' . $lang['seconds']; ?></div>
                </div>
                <div class="footer-item">
                    <div class="footer-label"><?php echo $lang['memory_usage_footer']; ?></div>
                    <div><?php echo number_format(memory_get_usage() / 1024, 2); ?> KB</div>
                </div>
                <div class="footer-item">
                    <div class="footer-label"><?php echo $lang['memory_peak']; ?></div>
                    <div><?php echo number_format(memory_get_peak_usage() / 1024, 2); ?> KB</div>
                </div>
                <div class="footer-item">
                    <div class="footer-label"><?php echo $lang['php_version_footer']; ?></div>
                    <div><?php echo PHP_VERSION; ?></div>
                </div>
            </div>
            <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 12px; margin-top: 12px;">
                <p style="margin: 0; font-size: 0.85em;">&copy; <?php echo date('Y'); ?> <?php echo $lang['copyright']; ?> | 
                <a href="https://openlxmp.com" target="_blank" style="color: rgba(255,255,255,0.8); text-decoration: none;"><?php echo $lang['official_website']; ?></a> | 
                <a href="https://github.com/OpenLXMP/OpenLXMP" target="_blank" style="color: rgba(255,255,255,0.8); text-decoration: none;"><?php echo $lang['github_project']; ?></a>
                </p>
                <p style="margin: 4px 0 0 0; font-size: 0.75em; color: rgba(255,255,255,0.7);"><?php echo $lang['footer_desc']; ?></p>
            </div>
        </div>
    </div>
    
    <?php
    // 使用全局开始时间
    global $time_start;
    
    // 计算脚本执行时间
    $end_time = microtime_float();
    
    // 使用全局变量，如果不存在则使用类的静态变量
    $script_start = $time_start ? $time_start : PHPProbe::$start_time;
    $run_time = sprintf('%0.4f', $end_time - $script_start);
    
    // 调试信息
    echo "<!-- Debug: global_start=$time_start, class_start=" . PHPProbe::$start_time . ", end=$end_time, using=$script_start, diff=$run_time -->";
    ?>
    
    <script>
        // 更新执行时间显示
        document.getElementById('execution-time').textContent = '<?php echo $run_time . ' ' . $lang['seconds']; ?>';
        
        function updateDynamicInfo() {
            console.log('Updating dynamic data...', new Date().toLocaleTimeString());
            
            // 构建AJAX请求URL，保持当前语言参数
            const urlParams = new URLSearchParams(window.location.search);
            let ajaxUrl = window.location.pathname + '?ajax=1';
            if (urlParams.get('lang')) {
                ajaxUrl += '&lang=' + urlParams.get('lang');
            }
            
            fetch(ajaxUrl)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response error: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    if (data.debug) {
                        console.log('Network interface debug info:', data.debug);
                    }
                    
                    // 更新系统负载
                    if (data.load) {
                        const loadElement = document.getElementById('system-load');
                        if (loadElement) {
                            loadElement.textContent = data.load.join(', ');
                        }
                    }
                    
                    // 更新服务器时间
                    if (data.time) {
                        const timeElement = document.getElementById('server-time');
                        if (timeElement) {
                            timeElement.textContent = data.time;
                        }
                    }
                    
                    // 更新内存信息
                    if (data.memory) {
                        updateMemoryInfo(data.memory);
                    }
                    
                    // 更新网络信息
                    if (data.network) {
                        console.log('Network data:', data.network);
                        // 显示网络调试信息
                        for (const [interface, netData] of Object.entries(data.network)) {
                            if (netData.debug) {
                                console.log(`${interface} debug:`, {
                                    time_diff: netData.debug.time_diff + 's',
                                    traffic_diff: `RX:${netData.debug.rx_diff}B TX:${netData.debug.tx_diff}B`,
                                    raw_speed: `RX:${netData.debug.raw_rx_speed}B/s TX:${netData.debug.raw_tx_speed}B/s`,
                                    formatted_speed: `RX:${netData.rx_speed} TX:${netData.tx_speed}`
                                });
                            }
                        }
                        updateNetworkInfo(data.network);
                    } else {
                        console.warn('No network data received');
                    }
                })
                .catch(error => {
                    console.error('Update failed:', error);
                    console.error('Error details:', error.message);
                });
        }
        
        function updateMemoryInfo(memory) {
            const memoryDiv = document.getElementById('memory-info');
            if (!memoryDiv) return;
            
            // 获取当前语言
            const currentLang = document.documentElement.lang;
            
            // 定义标签映射（中英文对照）
            const labelMap = {
                // 中文标签映射到英文标签
                '总内存': 'Total Memory',
                '已使用': 'Used',
                '缓存': 'Cached', 
                '缓冲区': 'Buffers',
                'Swap总量': 'Swap Total',
                'Swap已使用': 'Swap Used',
                // 英文标签映射到中文标签
                'Total Memory': '总内存',
                'Used': '已使用',
                'Cached': '缓存',
                'Buffers': '缓冲区',
                'Swap Total': 'Swap总量',
                'Swap Used': 'Swap已使用'
            };
            
            // 更新内存信息
            const infoRows = memoryDiv.querySelectorAll('.info-row');
            infoRows.forEach(row => {
                const labelElement = row.querySelector('.info-label');
                const valueSpan = row.querySelector('.info-value');
                const label = labelElement.textContent.trim();
                
                // 根据标签内容更新对应的值（支持中英文）
                if (label === '总内存' || label === 'Total Memory') {
                    valueSpan.textContent = formatBytes(memory.total);
                } else if (label === '已使用' || label === 'Used') {
                    valueSpan.textContent = formatBytes(memory.used);
                } else if (label === '缓存' || label === 'Cached') {
                    valueSpan.textContent = formatBytes(memory.cached);
                } else if (label === '缓冲区' || label === 'Buffers') {
                    valueSpan.textContent = formatBytes(memory.buffers);
                } else if (label === 'Swap总量' || label === 'Swap Total') {
                    if (memory.swap_total > 0) {
                        valueSpan.textContent = formatBytes(memory.swap_total);
                    }
                } else if (label === 'Swap已使用' || label === 'Swap Used') {
                    if (memory.swap_total > 0) {
                        valueSpan.textContent = formatBytes(memory.swap_used);
                    }
                }
            });
            
            // 更新进度条
            const progressBar = memoryDiv.querySelector('.progress-fill');
            if (progressBar && memory.total > 0) {
                const percentage = Math.round((memory.used / memory.total) * 100);
                progressBar.style.width = percentage + '%';
            }
        }
        
        function formatBytes(bytes) {
            const units = ['B', 'KB', 'MB', 'GB', 'TB'];
            bytes = Math.max(bytes, 0);
            const pow = Math.floor((bytes ? Math.log(bytes) : 0) / Math.log(1024));
            const powAdjusted = Math.min(pow, units.length - 1);
            bytes /= Math.pow(1024, powAdjusted);
            return Math.round(bytes * 100) / 100 + ' ' + units[powAdjusted];
        }
        
        function updateNetworkInfo(networkData) {
            const networkDiv = document.getElementById('network-info');
            if (!networkDiv) return;
            
            // 获取当前语言的标签文本（从现有DOM中读取）
            const currentLang = document.documentElement.lang;
            const labels = {
                download_traffic: currentLang === 'zh-CN' ? '下载流量' : 'Download Traffic',
                upload_traffic: currentLang === 'zh-CN' ? '上传流量' : 'Upload Traffic', 
                download_speed: currentLang === 'zh-CN' ? '下载速率' : 'Download Speed',
                upload_speed: currentLang === 'zh-CN' ? '上传速率' : 'Upload Speed',
                no_data: currentLang === 'zh-CN' ? '暂无网络接口数据' : 'No network interface data'
            };
            
            let html = '';
            
            // 检查是否有网络数据
            if (!networkData || Object.keys(networkData).length === 0) {
                html = `<div style="text-align: center; color: #666; padding: 20px;">${labels.no_data}</div>`;
                networkDiv.innerHTML = html;
                return;
            }
            
            for (const [interface, data] of Object.entries(networkData)) {
                html += `
                <div class="network-interface">
                    <h4>${interface}</h4>
                    <div class="network-speeds">
                        <div class="speed-item">
                            <div class="speed-label">${labels.download_traffic}</div>
                            <div class="speed-value">${data.rx_total || '0 B'}</div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label">${labels.upload_traffic}</div>
                            <div class="speed-value">${data.tx_total || '0 B'}</div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label">${labels.download_speed}</div>
                            <div class="speed-value">${data.rx_speed || '0 B'}/s</div>
                        </div>
                        <div class="speed-item">
                            <div class="speed-label">${labels.upload_speed}</div>
                            <div class="speed-value">${data.tx_speed || '0 B'}/s</div>
                        </div>
                    </div>
                </div>`;
            }
            networkDiv.innerHTML = html;
        }
        
        // 页面加载完成后立即执行一次更新，然后每秒执行一次
        document.addEventListener('DOMContentLoaded', function() {
            console.log('页面加载完成，开始定时更新, 当前语言:', document.documentElement.lang);
            
            // 确保页面完全加载后再开始更新
            setTimeout(function() {
                console.log('开始首次更新...');
                updateDynamicInfo(); // 立即执行一次
                
                // 设置定时器
                const intervalId = setInterval(function() {
                    console.log('定时更新执行中...', new Date().toLocaleTimeString());
                    updateDynamicInfo();
                }, 1000);
                
                console.log('定时器已设置，ID:', intervalId);
            }, 100); // 延迟100ms确保DOM完全就绪
            
            // MySQL连接测试
            document.getElementById('mysql-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('mysql_test', '1');
                
                const resultDiv = document.getElementById('mysql-result');
                resultDiv.style.display = 'block';
                resultDiv.innerHTML = '<div style="color: #666;"><?php echo $lang['testing_connection']; ?></div>';
                
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resultDiv.style.backgroundColor = data.success ? '#d4edda' : '#f8d7da';
                    resultDiv.style.color = data.success ? '#155724' : '#721c24';
                    resultDiv.style.border = data.success ? '1px solid #c3e6cb' : '1px solid #f5c6cb';
                    resultDiv.innerHTML = data.message.replace(/\n/g, '<br>');
                })
                .catch(error => {
                    resultDiv.style.backgroundColor = '#f8d7da';
                    resultDiv.style.color = '#721c24';
                    resultDiv.style.border = '1px solid #f5c6cb';
                    resultDiv.innerHTML = '<?php echo $lang['test_failed']; ?>: ' + error.message;
                });
            });
            
            // 函数检测
            document.getElementById('function-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('function_test', '1');
                
                const resultDiv = document.getElementById('function-result');
                resultDiv.style.display = 'block';
                resultDiv.innerHTML = '<div style="color: #666;"><?php echo $lang['testing_function']; ?></div>';
                
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resultDiv.style.backgroundColor = data.success ? '#d4edda' : '#f8d7da';
                    resultDiv.style.color = data.success ? '#155724' : '#721c24';
                    resultDiv.style.border = data.success ? '1px solid #c3e6cb' : '1px solid #f5c6cb';
                    resultDiv.innerHTML = data.message.replace(/\n/g, '<br>');
                })
                .catch(error => {
                    resultDiv.style.backgroundColor = '#f8d7da';
                    resultDiv.style.color = '#721c24';
                    resultDiv.style.border = '1px solid #f5c6cb';
                    resultDiv.innerHTML = '<?php echo $lang['test_failed']; ?>: ' + error.message;
                });
            });
            
            // 邮件发送测试
            document.getElementById('email-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                formData.append('email_test', '1');
                
                const resultDiv = document.getElementById('email-result');
                resultDiv.style.display = 'block';
                resultDiv.innerHTML = '<div style="color: #666;"><?php echo $lang['sending_email']; ?></div>';
                
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    resultDiv.style.backgroundColor = data.success ? '#d4edda' : '#f8d7da';
                    resultDiv.style.color = data.success ? '#155724' : '#721c24';
                    resultDiv.style.border = data.success ? '1px solid #c3e6cb' : '1px solid #f5c6cb';
                    resultDiv.innerHTML = data.message.replace(/\n/g, '<br>');
                })
                .catch(error => {
                    resultDiv.style.backgroundColor = '#f8d7da';
                    resultDiv.style.color = '#721c24';
                    resultDiv.style.border = '1px solid #f5c6cb';
                    resultDiv.innerHTML = '<?php echo $lang['test_failed']; ?>: ' + error.message;
                });
            });
        });
    </script>
</body>
</html>
        <?php
    }
}

if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    
    try {
        $probe = new PHPProbe();
        
        $load = $probe->getSystemLoad();
        $memory = $probe->getMemoryInfo();
        $network_speeds = $probe->calculateNetworkSpeed();
        
        $data = array(
            'load' => array_map(function($l) { return number_format($l, 2); }, $load),
            'time' => date('Y-m-d H:i:s'),
            'memory' => $memory,
            'network' => array(),
            'status' => 'success',
            'debug' => array(
                'network_interfaces_found' => count($network_speeds),
                'interfaces' => array_keys($network_speeds)
            )
        );
        
        foreach ($network_speeds as $interface => $speed_data) {
            $data['network'][$interface] = array(
                'rx_total' => $probe->formatBytes($speed_data['rx_total']),
                'tx_total' => $probe->formatBytes($speed_data['tx_total']),
                'rx_speed' => $probe->formatBytes($speed_data['rx_speed']),
                'tx_speed' => $probe->formatBytes($speed_data['tx_speed']),
                'debug' => array(
                    'time_diff' => $speed_data['time_diff'],
                    'rx_diff' => $speed_data['rx_diff'],
                    'tx_diff' => $speed_data['tx_diff'],
                    'raw_rx_speed' => $speed_data['rx_speed'],
                    'raw_tx_speed' => $speed_data['tx_speed']
                )
            );
        }
        
        echo json_encode($data);
    } catch (Exception $e) {
        echo json_encode(array(
            'status' => 'error',
            'message' => $e->getMessage()
        ));
    }
    exit;
}

$probe = new PHPProbe();
$probe->renderHTML();
?>