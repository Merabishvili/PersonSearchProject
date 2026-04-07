<!DOCTYPE html>
<html>
<head>
    <title>Person Search</title>
</head>
<body>
    <h1>Search Person</h1>
    <form method="GET">
        Personal Number: <input type="text" name="personalNumber" required><br><br>
        Surname: <input type="text" name="surname" required><br><br>
        <input type="submit" value="Search">
    </form>

    <hr>

    <?php
    if(isset($_GET['personalNumber']) && isset($_GET['surname'])) {
        $personalNumber = urlencode($_GET['personalNumber']);
        $surname = urlencode($_GET['surname']);

        // Change the URL if your API runs on HTTPS/HTTP
        $url = "http://localhost:5138/api/person/search?personalNumber=$personalNumber&surname=$surname";

        $response = file_get_contents($url);
        if($response === FALSE) {
            echo "<p style='color:red;'>Person not found or API error.</p>";
        } else {
            $data = json_decode($response, true);
            echo "<h2>Result:</h2>";
            echo "Name: " . htmlspecialchars($data['name']) . "<br>";
            echo "Surname: " . htmlspecialchars($data['surname']) . "<br>";
            echo "Personal Number: " . htmlspecialchars($data['personalNumber']) . "<br>";
            echo "Sex: " . htmlspecialchars($data['sex']) . "<br>";
            echo "Address: " . htmlspecialchars($data['address']) . "<br>";
        }
    }
    ?>
</body>
</html>