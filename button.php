<?php
class button {
private $item;
public $html;

public function __construct($itemID, $zip) {
$item = new item($itemID, $zip);
$this->html = <<<EOT
<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" >
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="A5UEAATGNFLTN">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value=$item->partName>
<input type="hidden" name="item_number" value=$item->partNumber>
<input type="hidden" name="amount" value=$item->price>
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="products">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="2">
<input type="hidden" name="tax_rate" value="12.000">
<input type="hidden" name="shipping" value="5.00">
<input type="hidden" name="add" value="1">
<input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_LG.gif:NonHosted">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
EOT;
}

}

class item {
    public $zip;

    public $partName;
    public $partNumber;
    public $suppliers;
    public $price;
    public $shippingCost;
    public function __construct ($partID, $zip) {
	$this->zip = $zip;
        $array = $this->runQuery($partID);
        $this->partName = $array['PartName'];
        $this->partNumber = $array['PartNumber'];
        $this->suppliers = $array['Suppliers'];
        $this->price = $array['Price'];
        $this->shippingCost = $array['Estimated_Shipping_Cost'];
    }

    private function runQuery($partID) {
        include 'connection.php';
        $query = "SELECT * FROM Parts WHERE PartID = '$partID'";
        $result = $conn->query($query);
        return mysqli_fetch_assoc($result);
    }

    public function printx () {
        echo $this->partName;
        echo $this->partNumber;
        echo $this->suppliers;
        echo $this->price;
        echo $this->shippingCost;
    }

    public function getZone() {
        include 'connection.php';
        global $conn;
        $q = "SELECT ZoneGround FROM ZiptoZone WHERE LEFT($this->zip, 3) BETWEEN LowZip and HighZip";
	    $result2 = $conn->query($q);
	    $rArray = mysqli_fetch_assoc($result2);
        $zone = $rArray['ZoneGround'];
	return $zone;
    }
}
?>