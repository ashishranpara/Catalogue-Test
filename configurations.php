<?php

class Catalogue
{
    public $cart = [];

    public function __construct()
    {
        $this->products = $this->productslist();
    }

    /**
     * This function will be used to fetch the product based on product id and add it into the cart
     * @param $productCode
     */
    public function add($productCode)
    {
        if (!isset($_SESSION['cartData'])) {
            $_SESSION['cartData'] = array();
        }
        $cartArr = $_SESSION['cartData'];
        array_push($cartArr, $productCode);
        array_unique($cartArr);
        $_SESSION['cartData'] = $cartArr;
    }

    /**
     * This function will be used to calculate the total amount and apply delivery offers and any special offers if any
     * @param $products
     * @return float|int|mixed
     */
    public function total($products)
    {

        $returnTotal = [];
        $discount = 0;
        $delivery = 0;
        $total = 0;
        $i = 1;
        foreach ($products as $product) {

            //check special offer when buying R01 product and make the second one to be of half price
            if ($i % 2 == 0 && $product == 'R01') {
                $total += $this->products[$product]['price'] / 2;
                $discount += $this->products[$product]['price'] / 2;
            } else {
                $total += $this->products[$product]['price'];

            }
            if ($product == 'R01') {
                $i++;
            }
        }
        /**
         * to apply deliver offers
         */
        if ($total >= 90) {
            //$total = $total;
            $delivery = 0;
        } else if ($total >= 50) {
            //$total = $total + 2.95;
            $delivery = 2.95;
        } else {
            //$total = $total + 4.95;
            $delivery = 4.95;
        }
        return array('total'=>$total,'delivery'=>$delivery,'discount'=>$discount);
    }

    /**
     * creating list of products
     * @return array
     */
    public function productslist()
    {
        $productsData = array(
            array('name' => 'Red Widget', 'code' => 'R01', 'price' => 32.95),
            array('name' => 'Green Widget', 'code' => 'G01', 'price' => 24.95),
            array('name' => 'Blue Widget', 'code' => 'B01', 'price' => 7.95),
        );
        $products = [];
        foreach ($productsData as $product) {
            $products[$product['code']] = array('name' => $product['name'], 'price' => $product['price']);
        }
        return $products;
    }
}
