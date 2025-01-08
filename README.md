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

Insert test data into the db:
```php
if ($conn->query("SELECT * FROM form_data")->num_rows == 0) {
    $insert_sql = "INSERT INTO form_data (name, email) VALUES ('John Doe', 'john@example.com'), ('Jane Smith', 'jane@example.com')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "Test data inserted successfully.";
    } else {
        echo "Error inserting test data: " . $conn->error;
    }
} else {
    echo "Table form_data is not empty, skipping test data insertion.";
}
```

Add additional columns if needed:
```php
function add_preference_column($conn) {
    $result = $conn->query("SHOW COLUMNS FROM form_data LIKE 'preference'");
    if ($result->num_rows == 0) {
        $sql = "ALTER TABLE form_data ADD preference VARCHAR(10) NOT NULL";
        if ($conn->query($sql) !== TRUE) {
            echo "Error adding preference column: " . $conn->error;
        }
    }
}

add_preference_column($conn);
```

Create a table in PHP:
```php

function make_table($conn){
    // SQL query to create table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS form_data (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        preference VARCHAR(10) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    // Report error
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }
}

make_table($conn);

```

*TODO*
Troubleshoot HTTPS
Fix page reload issue