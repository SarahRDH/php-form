<?php
$servername = "localhost";
$username = "sarah";
$password = "Thisisan3xampl3";
$dbname = "seimens_form";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create table if it does not exist
$sql = "CREATE TABLE IF NOT EXISTS form_data (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table form_data created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

// SQL query to insert test data
$insert_sql = "INSERT INTO form_data (name, email) VALUES ('John Doe', 'john@example.com'), ('Jane Smith', 'jane@example.com')";
if ($conn->query($insert_sql) === TRUE) {
    echo "Test data inserted successfully.";
} else {
    echo "Error inserting test data: " . $conn->error;
}

// SQL query to fetch data from a table
$fetch_sql = "SELECT * FROM form_data";
$result = $conn->query($fetch_sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>