# PHP Server Probe

A comprehensive PHP server monitoring and diagnostic tool that provides real-time system information, resource monitoring, and PHP configuration analysis.

## Features

### 🖥️ Server Information
- **Server Domain/IP**:  (e.g., `example.com(192.168.1.100)`)
- **Server Hostname**: System hostname detection
- **Operating System**: Detailed OS information
- **Web Server**: Apache/Nginx server details
- **Server Port**: Active port information
- **Admin Email**: Apache administrator email (when available)
- **Uptime**: System uptime with localized time units
- **Current User**: Running user account

### 💾 System Monitoring
- **CPU Information**: Model, cores, and architecture
- **System Load**: Real-time load averages (1, 5, 15 minutes)
- **Memory Usage**: Total, used, cached, and buffer memory
- **Swap Information**: Swap usage statistics
- **Real-time Updates**: Automatic refresh every second

### 🌐 Network Traffic Monitoring
- **Real-time Network Stats**: Upload/download speeds and total traffic
- **Multi-interface Support**: Monitors all active network interfaces
- **Intelligent Filtering**: Excludes virtual and Docker interfaces
- **Speed Calculation**: Accurate bandwidth monitoring with enhanced algorithms

### ⚙️ PHP Configuration
- **PHP Version**: Detailed version information
- **Configuration Directives**: Key PHP settings analysis
- **Memory Limits**: PHP memory configuration
- **Execution Limits**: Time and resource limits
- **Security Settings**: Important security-related configurations

### 📦 PHP Extensions
- **Comprehensive Extension List**: All loaded PHP modules
- **Extension Categorization**: Core, bundled, and third-party extensions
- **Function Availability**: Tests for critical PHP functions
- **Database Support**: MySQL, PostgreSQL, SQLite detection
- **Cache Extensions**: Redis, Memcached, OPcache status

### 🔧 Additional Tools
- **MySQL Connection Test**: Database connectivity verification
- **Email Function Test**: SMTP and mail() function testing
- **Function Detection**: Checks for disabled or unavailable functions
- **Script Execution Time**: Page load performance metrics

## Compatibility

- **PHP Versions**: 5.2 - 8.4+
- **Web Servers**: Apache, Nginx, IIS, LiteSpeed
- **Operating Systems**: Linux, Windows, macOS, FreeBSD
- **Browsers**: Modern browsers with JavaScript support

## Installation

1. Upload `probe.php` to your web server
2. Access the file through your web browser
3. No additional configuration required

```bash
# Example installation
wget https://raw.githubusercontent.com/OpenLXMP/probe/refs/heads/main/probe.php
chmod 644 php_probe.php
```

## Usage

### Basic Access
Simply navigate to the probe file in your web browser:
```
https://yourdomain.com/probe.php
```

### Language Support
The probe supports bilingual operation:
- **Chinese**: `https://yourdomain.com/probe.php?lang=zh`
- **English**: `https://yourdomain.com/probe.php?lang=en`


## Support

For issues, suggestions, or contributions, please refer to the project documentation or contact the development team.