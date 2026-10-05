<?php
/* START: ApiFrontController — handles all incoming /api/* requests */
header('Content-Type: application/json; charset=UTF-8');

echo json_encode([
    'success' => true,
    'message' => 'Livelihood API Router ready',
    'data' => null,
    'errors' => null
]);
/* END: ApiFrontController */
