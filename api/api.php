<?php
#ini_set('display_errors', 1);
#error_reporting(E_ALL);

require_once 'app.php'

# Get request's body (JSON).
$data = array();
$input = file_get_contents('php://input');
if ($input !== false)
    $data = json_decode($input, true);

# Route.
$url = substr($_SERVER['REQUEST_URI'], 5); # Remove '/api/' from URL.'
header('Content-type: application/json');
echo(json_encode(call_user_func($url, $data)));
?>
