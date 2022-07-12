<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>
<pre>
<?php
Bitrix\Main\Loader::includeModule("sale");

//Заказы
$month = time() - 3600*24*30; // 30 дней
$orderDbRes = \Bitrix\Sale\Order::getList([
    'select' => ['ID'],
    'filter' => [
        ">=DATE_INSERT" => date($DB->DateFormatToPHP(CSite::GetDateFormat("SHORT")), $month),
    ],
    'order' => ['ID' => 'DESC']
]);

foreach ($orderDbRes as $order) {
    //Свойства заказа
    $propertyDbRes = \Bitrix\Sale\PropertyValue::getList([
        'select' => ['*'],
        'filter' => [
            '=ORDER_ID' => $order['ID'],
        ]
    ]);

    while ($item = $propertyDbRes->fetch())
    {
        $orders[$order['ID']]['ORDER_PROPERTY'][] = $item;
    }

    //Корзина
    $basketDbRes = \Bitrix\Sale\Basket::getList([
        'select' => ['*'],
        'filter' => [
            '=ORDER_ID' => $order['ID'],
        ]
    ]);

    while ($item = $basketDbRes->fetch())
    {
        $orders[$order['ID']]['BASKET'][] = $item;
    }

    //Оплаты
    $paymentDbRes = \Bitrix\Sale\PaymentCollection::getList([
        'select' => ['*'],
        'filter' => [
            '=ORDER_ID' => $order['ID'],
        ]
    ]);

    while ($item = $paymentDbRes->fetch())
    {
        $orders[$order['ID']]['PAYMENT'][] = $item;

    }

    //Отгрузки
    $shipmentDbRes = \Bitrix\Sale\ShipmentCollection::getList([
        'select' => ['*'],
        'filter' => [
            '=ORDER_ID' => $order['ID'],
        ]
    ]);

    while ($item = $shipmentDbRes->fetch())
    {
        $orders[$order['ID']]['SHIPMENT'][] = $item;
    }
}

var_dump(json_encode($orders,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
?>
</pre>