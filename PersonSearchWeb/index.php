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

    // Use cURL for better debugging
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output
    curl_setopt($ch, CURLOPT_HEADER, true);  // Include headers in response
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    echo "<h2>Debug Information:</h2>";
    echo "<p><strong>URL:</strong> " . htmlspecialchars($url) . "</p>";
    echo "<p><strong>HTTP Status Code:</strong> " . $httpCode . "</p>";
    
    if ($error) {
        echo "<p style='color:red;'><strong>cURL Error:</strong> " . htmlspecialchars($error) . "</p>";
    } else {
        echo "<p style='color:green;'><strong>Connection:</strong> Success</p>";
    }
    
    echo "<p><strong>Full Response:</strong></p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>
</body>
</html>
