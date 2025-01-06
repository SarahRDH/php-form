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

make_table($conn);

function make_table($conn){
    // SQL query to create table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS form_data (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    // Report error
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table: " . $conn->error;
    }

    // // SQL query to insert test data
    // if ($conn->query("SELECT * FROM form_data")->num_rows == 0) {
    //     $insert_sql = "INSERT INTO form_data (name, email) VALUES ('John Doe', 'john@example.com'), ('Jane Smith', 'jane@example.com')";
    //     if ($conn->query($insert_sql) === TRUE) {
    //         echo "Test data inserted successfully.";
    //     } else {
    //         echo "Error inserting test data: " . $conn->error;
    //     }
    // } else {
    //     echo "Table form_data is not empty, skipping test data insertion.";
    // } 
}

$name = '';
$email = '';
$password = '';
$hashed_password = '';

if (isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    function clean_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        
        return $data;
    }

    echo "<h2>Your Sanitized Data (as it appears in the source code):</h2>";
    echo htmlentities(clean_input($name)) . '<br>';
    echo htmlentities(clean_input($email)) . '<br>';
    echo htmlentities($hashed_password) . '<br>';
    echo "<hr>";

    // SQL query to insert data into a table
    $insert_sql = "INSERT INTO form_data (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    // Report success or error
    if ($conn->query($insert_sql) === TRUE) {
        echo "<p style='color:green;'>New record created successfully.</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $insert_sql . "<br>" . $conn->error . "</p>";
    }

    // SQL query to fetch data from a table
    $fetch_sql = "SELECT * FROM form_data";
    $result = $conn->query($fetch_sql);

    if ($result->num_rows > 0) {
        echo "<h2>Data in MySQL:</h2>";
        // Output data of each row
        echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Registration Date</th>
            </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . $row["password"] . "</td>
                <td>" . $row["reg_date"] . "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

} else if (isset($_POST['delete'])) {
    // Delete all data from the table and reset the auto-increment value
    $delete_sql = "DELETE FROM form_data";
    if ($conn->query($delete_sql) === TRUE) {
        // Reset the auto-increment value
        $reset_auto_increment_sql = "ALTER TABLE form_data AUTO_INCREMENT = 1";
        if ($conn->query($reset_auto_increment_sql) === TRUE) {
            echo "<p style='text-align: center; color: green;'>All records deleted and auto-increment value reset successfully.</p>";
        } else {
            echo "Error resetting auto-increment value: " . $conn->error;
        }
    } else {
        echo "Error deleting records: " . $conn->error;
    }
}

$conn->close();

//reset the form
$_POST = array(); 

?>

