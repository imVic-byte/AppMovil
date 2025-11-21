<?php
$inputJSON = file_get_contents('php://input');

$input = json_decode($inputJSON, true);

if (isset($input['uid'])) {
    $uid = $input['uid'];

    file_put_contents('uids.txt', $uid . PHP_EOL, FILE_APPEND);
    
    echo json_encode(['status' => 'ok', 'uid' => $uid]);

} else {
    echo json_encode(['status' => 'error', 'message' => 'UID no recibido']);
}
?>
