<?php
//include 'db.inc.php';
define('ORDER_LOG', 'admin/orders.log');

function addItemToCatalog($title, $author, $pubyear, $price)
{
    global $link;
    $sql = "INSERT INTO catalog
                         (title,
                          author,
                          pubyear,
                          price )
                   VALUES (?, ?, ?, ?)";
    mysqli_set_charset($link, "utf8");
    if (!$stmt = mysqli_prepare($link, $sql))
        return false;
    mysqli_stmt_bind_param($stmt, "ssii", $title, $author, $pubyear, $price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

/**
 * @param $id
 * @param $title
 * @param $author
 * @param $price
 * @return bool
 */
function selectAllItems()
{
    global $link;

    $sql = "SELECT id, title, author, pubyear, price
              FROM catalog";
    mysqli_set_charset($link, "utf8");
    if (!$result = mysqli_query($link, $sql)) {
//        print_r($result);
        return false;
    }

    $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
//      print_r($items);
    mysqli_free_result($result);
    return $items;

}

function saveBasket()
{
    global $basket, $count;
//        $basket = base64_encode(serialize($_COOKIE['basket']));
    $basket = serialize($basket);
    setcookie('basket', $basket, 0x7FFFFFFF);
//    print_r(unserialize($_COOKIE['basket']));
}

function basketInit()
{
    global $basket, $count;
    if (!isset($_COOKIE['basket'])) {
//         $rndid = uniqid();
        $basket = array('orderid' => uniqid());
        print_r($_COOKIE['basket']);
//        print_r($basket);
        saveBasket();
    } else {
//        $basket = unserialize(base64_decode($_COOKIE['basket']));
        $basket = unserialize($_COOKIE['basket']);
        print_r($basket);
//        print_r($_COOKIE);
        //exit;
//   $count = count($basket) - 1;
        $count = count($basket) - 1;
    }
}

function add2Basket($id, $q)
{
    global $basket;
    $q = 1;
    if ($basket[$id] != 0) {
        $basket[$id] += $q;
    } else {
        $basket[$id] = 1;
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    saveBasket();
}

function myBasket()
{
    global $link, $basket;
    $goods = array_keys($basket);
    array_shift($goods);
    $ids = implode(",", $goods);
    $sql = "SELECT id, author, title, pubyear, price
                FROM catalog WHERE id IN ($ids)";
    mysqli_set_charset($link, "utf8");
    if (!$result = mysqli_query($link, $sql))
        return false;
    $items = result2Array($result);
    mysqli_free_result($result);
    return $items;

}

function deleteItemFromBasket($id)
{
    global $basket;
    unset($basket[$id]);

    saveBasket();
}

function saveOrder($dt)
{
    global $link, $basket;
    $goods = myBasket();
    $stmt = mysqli_stmt_init($link);
    $sql = 'INSERT INTO orders (title, author, pubyear, price, quantity, orderid, datetime)
            VALUES (?, ?, ?, ?, ?, ?, ?)';
    if (!mysqli_stmt_prepare($stmt, $sql)){

    echo "все говно";
        return false;
    }
    foreach ($goods as $item) {
        mysqli_stmt_bind_param($stmt, "ssiiisi", $item['title'], $item['author'], $item['pubyear'],
                               $item['price'], $item['q'], $basket['orderid'], $dt);
mysqli_stmt_execute($stmt);
        print_r($item);
        echo $dt;
    }
    mysqli_stmt_close($stmt);
    setcookie('basket', '', time()-3600);
    return true;
}

function getOrders(){
    global $link;
    if(!is_file(ORDERS_LOG))
        return false;
    /* Получаем в виде массива персональные данные пользователей из файла */
    $orders = file(ORDERS_LOG);
    /* Массив, который будет возвращен функцией */
    $allorders = array();
    foreach ($orders as $order) {
        list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order); /* Промежуточный массив для хранения информации о конкретном заказе */
        $orderinfo = array();
        /* Сохранение информацию о конкретном пользователе */
        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;  //order id
     echo   $orderinfo["orderid"] = $orderid; //datatime
        $orderinfo["date"] = $date;

//        print_r($orderinfo);
        /* SQL-запрос на выборку из таблицы orders всех товаров для конкретного покупателя */
        $sql = "SELECT title, author, pubyear, price, quantity
                  FROM orders
                  WHERE orderid = '$orderid'"; //AND datetime = $date";
        /* Получение результата выборки */
        mysqli_set_charset($link, "utf8");
        if(!$result = mysqli_query($link, $sql))
            return false;
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_free_result($result);
        /* Сохранение результата в промежуточном массиве */
       $orderinfo["goods"] = $items;
//        print_r($items);
//        print_r($orderinfo['goods']);
        /* Добавление промежуточного массива в возвращаемый массив */
        $allorders[] = $orderinfo;
    }
    return $allorders;
}

function result2Array($data)
{
    global $basket;
    $arr = array();
    while ($row = mysqli_fetch_assoc($data)) {
        $row['q'] = $basket[$row['id']];
        $arr[] = $row;

    }
    return $arr;
}

function clearInt($data)
{
    return abs((int)$data);
}

function clearStr($data)
{
    global $link;
    return mysqli_real_escape_string($link, trim(strip_tags($data)));
}