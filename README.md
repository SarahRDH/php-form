# Documentation

This is an MAMP stack set up on a Mac with an M1 running Ventura 13.3.1.

Linux could have been installed if a VM had been set up, but for the sake of time, it is using a Unix-based Darwin kernel. Commands were run in bash.

To check, run:
```bash
uname -a
```

The default Mac version of Apache was uninstalled, and the Homebrew version was installed:
```bash
brew install httpd
```

To check, run:
```bash
which httpd
httpd -v
```

The latest version of PHP was installed:
```bash
brew install php
```

To check, run:
```bash
which php
php -v
```

The latest version of MySQL was installed:
```bash
brew install mysql
```

To check, run (may need to log in as root):
```bash
which mysql
mysql -u root -p
mysql -v
```

Add lines to the config file:
```
LoadModule php_module libexec/apache2/libphp.so
AddType application/x-httpd-php .php
```

Open `php.ini`:
Find it with the terminal command:
```bash
php --ini
```

Comment out the MySQL lines:
```
extension=mysqli
extension=pdo_mysql
```

Ensure the document root and directory are pointed to the correct file path:
```
DocumentRoot "/Users/sarahjohnson/Coding/siemens-site"
<Directory "/Users/sarahjohnson/Coding/siemens-site">
```

Restart Apache:
```bash
sudo brew services restart httpd
```

Start MySQL:
```bash
sudo brew services restart mysql
```

Test by viewing `phpinfo()` on localhost:
```php
<?php
phpinfo();
?>
```

`httpd.conf` and `php.ini` files were symlinked to the repo.

Apache commands:
```bash
sudo brew services restart httpd
# Or
sudo brew services start httpd
# Or
sudo brew services stop httpd
```

Create a new database:
```bash
mysql -u root -p
```
```sql
mysql> CREATE DATABASE siemens_form;
Query OK, 1 row affected (0.00 sec)

mysql> SHOW DATABASES;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| mysql              |
| performance_schema |
| siemens_form       |
| sys                |
+--------------------+
5 rows in set (0.01 sec)
```

To create a new user instead of root for security reasons:
```bash
mysql -u root -p
```
```sql
mysql> CREATE USER 'sarah'@'localhost' IDENTIFIED BY 'Thisisan3xampl3';

mysql> GRANT ALL PRIVILEGES ON siemens_form.* TO 'sarah'@'localhost';

mysql> FLUSH PRIVILEGES;
```

Now connect to the database in a PHP file:
```php
<?php
$servername = "localhost";
$username = "sarah";
$password = "Thisisan3xampl3";
$dbname = "siemens_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
```