<?php
$xmlFile = "tickets.xml";

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);

    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>Tickets</title>";
    echo "</head>";
    echo "<body>";

    echo "<h1>Tickets</h1>";
    echo "<h3>Date: " . $xml->date . "</h3>";
    echo "<ul>";
    foreach ($xml->items->item as $item) {
        echo "<li>Name: " . $item['name'] . "</li>";
        echo "<ul>";
        echo "<li>Count: " . $item->count . "</li>";
        echo "<li>Price: " . $item->price . "</li>";
        echo "<li>Total: " . $item->total . "</li>";
        echo "</ul>";
    }
    echo "</ul>";

    echo "</body>";
    echo "</html>";
} else {
    echo "No tickets available.";
}
?>