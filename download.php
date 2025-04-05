<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Validate and sanitize the file parameter
if (!isset($_GET['file'])) {
    header('HTTP/1.0 400 Bad Request');
    exit('File parameter is missing');
}

$file = urldecode($_GET['file']);

// Security check: Ensure the file is within the resources directory
$resources_dir = __DIR__ . '/resources/';
$real_path = realpath($file);
$resources_real_path = realpath($resources_dir);

if ($real_path === false || strpos($real_path, $resources_real_path) !== 0) {
    header('HTTP/1.0 403 Forbidden');
    exit('Access denied');
}

// Check if file exists
if (!file_exists($file)) {
    header('HTTP/1.0 404 Not Found');
    exit('File not found');
}

// Get file extension and set appropriate Content-Type
$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

$mime_types = [
    'pdf' => 'application/pdf',
    'mp4' => 'video/mp4',
    'webm' => 'video/webm',
];

if (!isset($mime_types[$extension])) {
    header('HTTP/1.0 415 Unsupported Media Type');
    exit('Unsupported file type');
}

// Set headers for file download
header('Content-Type: ' . $mime_types[$extension]);
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Content-Length: ' . filesize($file));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Output file content
readfile($file);
exit();