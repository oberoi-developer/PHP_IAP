<?php
include "db.php";
header("Content-Type: application/json");
$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action == "list") {
    $search = $_GET['search'] ?? '';
    $cat    = $_GET['cat'] ?? '';
    $where  = "WHERE 1";
    if ($search) $where .= " AND name LIKE '%$search%'";
    if ($cat)    $where .= " AND category='$cat'";
    $res  = mysqli_query($conn, "SELECT * FROM products $where ORDER BY id DESC");
    $data = [];
    while ($r = mysqli_fetch_assoc($res)) $data[] = $r;
    echo json_encode($data);
}

elseif ($action == "add") {
    $name  = htmlspecialchars(trim($_POST['name']));
    $cat   = htmlspecialchars(trim($_POST['category']));
    $qty   = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    if (!$name) { echo json_encode(["ok"=>false,"msg"=>"Name required"]); exit; }
    mysqli_query($conn, "INSERT INTO products(name,category,quantity,price) VALUES('$name','$cat','$qty','$price')");
    echo json_encode(["ok"=>true,"msg"=>"Product added"]);
}

elseif ($action == "edit") {
    $id    = intval($_POST['id']);
    $name  = htmlspecialchars(trim($_POST['name']));
    $cat   = htmlspecialchars(trim($_POST['category']));
    $qty   = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    mysqli_query($conn, "UPDATE products SET name='$name',category='$cat',quantity='$qty',price='$price' WHERE id=$id");
    echo json_encode(["ok"=>true,"msg"=>"Product updated"]);
}

elseif ($action == "delete") {
    $id = intval($_POST['id']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    echo json_encode(["ok"=>true,"msg"=>"Deleted"]);
}

elseif ($action == "get") {
    $id  = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    echo json_encode(mysqli_fetch_assoc($res));
}

elseif ($action == "stats") {
    $total = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM products"))[0];
    $low   = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM products WHERE quantity < 5"))[0];
    $value = mysqli_fetch_row(mysqli_query($conn,"SELECT COALESCE(SUM(quantity*price),0) FROM products"))[0];
    $cats  = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(DISTINCT category) FROM products"))[0];
    echo json_encode(compact("total","low","value","cats"));
}

elseif ($action == "categories") {
    $res  = mysqli_query($conn, "SELECT DISTINCT category FROM products WHERE category != '' ORDER BY category");
    $cats = [];
    while ($r = mysqli_fetch_row($res)) $cats[] = $r[0];
    echo json_encode($cats);
}
?>
