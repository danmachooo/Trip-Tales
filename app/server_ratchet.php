<?php

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/libraries/LChat.php';

// Add a starting log to confirm the script is being executed
echo "Starting WebSocket server...\n";

// Log server start to a file for debugging
file_put_contents('server_log.txt', "Server starting...\n", FILE_APPEND);

// Set up the WebSocket server
try {
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new LChat()
            )
        ),
        3000
    );

    // Log the server running status
    echo "WebSocket server is running on ws://localhost:3000\n";
    file_put_contents('server_log.txt', "WebSocket server is running on ws://localhost:3000\n", FILE_APPEND);

    // Run the server
    $server->run();

} catch (Exception $e) {
    // Catch any errors and log them
    echo "Error: " . $e->getMessage() . "\n";
    file_put_contents('server_log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
}
