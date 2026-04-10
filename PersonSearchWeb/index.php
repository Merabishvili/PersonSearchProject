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
require_once __DIR__ . '/../webconfigs.php';
if(isset($_GET['personalNumber']) && isset($_GET['surname'])) {
    $personalNumber = urlencode($_GET['personalNumber']);
    $surname = urlencode($_GET['surname']);

    $url = $apiBaseUrl . "/api/person/search?personalNumber=" . $personalNumber . "&surname=" . $surname;

    // Better error handling
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    // Check HTTP response headers
    if ($http_response_header) {
        $status = $http_response_header[0];
        echo "<!-- Debug: HTTP Status: $status -->";
    }
    
    if($response === FALSE) {
        echo "<p style='color:red;'>API Connection Error:</p>";
        echo "<p>URL: " . htmlspecialchars($url) . "</p>";
        echo "<p>Make sure the API server is running at: " . htmlspecialchars($apiBaseUrl) . "</p>";
        echo "<p>Error: " . error_get_last()['message'] . "</p>";
    } else {
        $data = json_decode($response, true);
        if ($data) {
            echo "<h2>Result:</h2>";
            echo "Name: " . htmlspecialchars($data['name']) . "<br>";
            echo "Surname: " . htmlspecialchars($data['surname']) . "<br>";
            echo "Personal Number: " . htmlspecialchars($data['personalNumber']) . "<br>";
            echo "Sex: " . htmlspecialchars($data['sex']) . "<br>";
            echo "Address: " . htmlspecialchars($data['address']) . "<br>";
        } else {
            echo "<p style='color:red;'>Invalid JSON response from API</p>";
        }
    }
}
?>
</body>
</html>
