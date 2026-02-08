<?php

$url = "https://jsonplaceholder.typicode.com/posts/1";

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

// Execute request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

// Close cURL
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

?>
<!DOCTYPE html>
<html>
<head>
    <title>cURL API Demo</title>
</head>
<body>
    <h2>API Response</h2>

    <pre>
<?php print_r($data); ?>
    </pre>

    <h3>Formatted Output</h3>
    <p><strong>Title:</strong> <?= htmlspecialchars($data['title']) ?></p>
    <p><strong>Body:</strong> <?= htmlspecialchars($data['body']) ?></p>
</body>
</html>


<p>This paragraph is added to simulate git merge conflict on branch pranav-poudyal</p>

<p> This paragraph is added by Pradosh as a task of git merge conflict issue</p>
