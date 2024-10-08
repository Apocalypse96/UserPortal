<?php
// Example webhook that triggers an external notification system
function triggerWebhook($customer_id) {
    // Send a GET request to an external service notifying the customer addition
    $webhook_url = "https://example.com/webhook?customer_id=" . $customer_id;
    file_get_contents($webhook_url);
}
?>
