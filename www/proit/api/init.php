<?php
require_once 'AddressBookApi.php';

/**
 * Инициализация АПИ
 */
try {
    $api = new AddressBookApi();
    echo $api->run();
} catch (Exception $e) {
    header("HTTP/1.0 404 Error");
    echo json_encode(Array('error' => $e->getMessage()));
}