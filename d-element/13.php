<?php
session_start();

$products = [
    ["id" => 1, "name" => "tomato", "price" => "2.99"],
    ["id" => 2, "name" => "steak", "price" => "9.99"],
    ["id" => 3, "name" => "bread", "price" => "1.45"],
    ["id" => 4, "name" => "eggs", "price" => "3.89"],
];

foreach ($products as $product) {
    echo $product["id"]." ".$product["name"]." - ".$product["price"]."<br/>";
    echo "<button id='$product[id]' class='js-add-to-cart'>Купить</button>"."<br/>";
}

if(isset($_SESSION["cart"])) {
    echo "В корзине: "."<br/>";
    foreach ($_SESSION["cart"] as $productId => $amount) {
        echo "id товара: ".$productId." - количество: ".$amount."<br/>";
    }
}
?>

<script>
    const addToCardButtons = document.getElementsByClassName("js-add-to-cart");
    Array.from(addToCardButtons).forEach((button) => {
        button.addEventListener("click", (e) => {
            const button = e.target;
            let formData = new FormData();
            formData.append('product_id', button.id);

            fetch("13_1.php", {
                method: "POST",
                body: formData,
            })
        })
    })
</script>
