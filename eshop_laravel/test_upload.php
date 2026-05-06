<?php

// Simple test to verify image upload functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    echo 'POST data received:' . PHP_EOL;
    print_r($_POST);
    echo PHP_EOL . 'FILES data received:' . PHP_EOL;
    print_r($_FILES);
    echo '</pre>';
    
    // Test if we can move uploaded file
    if (isset($_FILES['test_image']) && $_FILES['test_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'public/images/products/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filename = 'test_' . time() . '_' . $_FILES['test_image']['name'];
        if (move_uploaded_file($_FILES['test_image']['tmp_name'], $uploadDir . $filename)) {
            echo '<p style="color: green;">SUCCESS: File uploaded to ' . $uploadDir . $filename . '</p>';
        } else {
            echo '<p style="color: red;">FAILED: Could not move file</p>';
        }
    }
} else {
    echo '<form method="POST" enctype="multipart/form-data">
        <input type="file" name="test_image" required>
        <button type="submit">Test Upload</button>
    </form>';
}
?>
