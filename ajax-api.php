<?php
session_start();

header('Content-Type: application/json');

require_once __DIR__ . '/classes/actions.class.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["status" => "error", "msg" => "Method not allowed"]);
    exit;
}

$action = $_POST['action'] ?? "";
$actionClass = new Actions();

$allowedActions = [
    'save_class',
    'delete_class',
    'save_student',
    'delete_student',
    'save_attendance'
];

if (!in_array($action, $allowedActions)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "msg" => "Invalid action"]);
    exit;
}

$response = $actionClass->$action();
echo json_encode($response);