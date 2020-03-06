<?php
session_start();
include 'configurations.php';
    $catalogue = new Catalogue();

if(isset($_REQUEST['clearCart'])){
    unset($_SESSION['cartData']);
}
    if(isset($_REQUEST['code'])){
        $catalogue->add($_REQUEST['code']);
    }
?>
<table align="center" border="1" width="300">
        <tr>
            <td>Name</td>
            <td>Code</td>
            <td>Price</td>
            <td>Action</td>
        </tr>
    <?php
        foreach ($catalogue->products as $key=>$product){
            ?>
                <tr>
                    <td><?php echo $product['name'];?></td>
                    <td><?php echo $key;?></td>
                    <td><?php echo $product['price'];?></td>
                    <td><a href="index.php?code=<?php echo $key;?>">Add To Cart</a> </td>
                </tr>
    <?php
            }
    ?>
</table>


<div>
    <b>Delivery Offers</b>
    <ul>
        <li>Orders above $90 = Free Delivery</li>
        <li>Orders under $90 and greater $50 > 2.95</li>
        <li>Orders under $50' => 4.95</li>
    </ul>
    <b>Special Offer</b>
    <ul><li>Buy one red widget, get the second half price </li></ul>
</div>

<?php
    if(isset($_SESSION['cartData'])) {
    $total = $catalogue->total($_SESSION['cartData']);
    $implode = implode(',',$_SESSION['cartData']);

    ?>
    <table align="center" border="1" width="300">
        <tr>
            <th>Products</th>
            <th>Total</th>
        </tr>
        <tr>
            <td><?php echo $implode;?></td>
            <td align="right"><?php echo $total['total']+$total['discount'];?></td>
        </tr>
        <tr>
            <td>Delivery Fee</td>
            <td align="right"><?php echo $total['delivery']; ?></td>
        </tr>
        <?php
        if($total['discount'] >0) {
            ?>
            <tr>
                <td>Special Offer (R01 - Buy one get another half price)</td>
                <td align="right">-<?php echo $total['discount']; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td> <b>Grand Total</b></td> <td> <b><?php echo $total['total']+$total['delivery'];?></b></td>
        </tr>
        <tr>
            <td colspan="2"><a href="index.php?clearCart=1">Clear Cart</a> </td>
        </tr>
    </table>
<?php
}
    ?>

