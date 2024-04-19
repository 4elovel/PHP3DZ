<?php

session_start();

class Product {
    private $_name;
    private $_count;
    private $_price;

    public function __construct($name, $count, $price) {
        $this->_name = $name;
        $this->_count = $count;
        $this->_price = $price;
    }

    public function getName() {
        return $this->_name;
    }

    public function getCount() {
        return (int)$this->_count;
    }

    public function getPrice() {
        return (float)$this->_price;
    }
}

if (!isset($_SESSION['itemsKey'])) {
    $_SESSION['itemsKey'] = [];
}

$items =& $_SESSION['itemsKey'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_item'])) {
        $name = $_POST['name'];
        $count = $_POST['count'];
        $price = $_POST['price'];
        $product = new Product($name, $count, $price);
        $items[] = $product;
    } elseif (isset($_POST['buy'])) {
        $xml = new DOMDocument("1.0", "UTF-8");
        $xml->formatOutput = true;
        $ticket = $xml->createElement("ticket");
        $date = $xml->createElement("date", date('Y-m-d H:i:s'));
        $ticket->appendChild($date);
        $itemsElement = $xml->createElement("items");
        foreach ($items as $item) {
            $itemElement = $xml->createElement("item");
            $itemElement->setAttribute("name", $item->getName());
            $countElement = $xml->createElement("count", $item->getCount());
            $priceElement = $xml->createElement("price", $item->getPrice());
            $totalElement = $xml->createElement("total", $item->getCount() * $item->getPrice());
            $itemElement->appendChild($countElement);
            $itemElement->appendChild($priceElement);
            $itemElement->appendChild($totalElement);
            $itemsElement->appendChild($itemElement);
        }
        $ticket->appendChild($itemsElement);
        $xml->appendChild($ticket);
        $xml->save("tickets.xml");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping</title>
</head>
<body>
<form method="post">
    <label for="name">Name:</label>
    <input type="text" name="name"><br><br>
    <label for="count">Count:</label>
    <input type="text" name="count"><br><br>
    <label for="price">Price:</label>
    <input type="text" name="price"><br><br>
    <button type="submit" name="add_item">Add Item</button>
    <button type="submit" name="buy">Buy</button>
</form><br>
<form method="get" action="tickets.php">
    <button type="submit" name="get_tickets">Get Tickets</button>
</form>
</body>
</html>