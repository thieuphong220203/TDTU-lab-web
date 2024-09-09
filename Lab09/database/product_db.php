<?php
require_once('db.php');

function add_product($name, $price, $desc)
{
    $sql = "insert into product(name, price, description) values(?,?,?)";
    $conn = get_connection();
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sis', $name, $price, $desc);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $product_id = $stmt->insert_id;
            $stmt->close();
            $conn->close();
            return $product_id;
        } else {
            $stmt->close();
            $conn->close();
            return null;
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
    // TODO: thực hiện prepare statement
    // TODO: sau đó gọi bind_param() và execute()

}

function get_products()
{
    // TODO: viết chức năng đọc tất cả sản phẩm ở đây
    $sql = "SELECT * FROM product";
    $conn = get_connection();

    if ($result = $conn->query($sql)) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        $result->free();
        $conn->close();
        return $products;
    } else {
        die("Query failed: " . $conn->error);
    }
}

function get_product($id)
{
    // TODO: viết chức năng đọc sản phẩm theo $id
    $sql = "SELECT * FROM product WHERE id = ?";
    $conn = get_connection();

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $stmt->close();
            $conn->close();
            return $product;
        } else {
            $stmt->close();
            $conn->close();
            return null;
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
}

function update_product($id, $name, $price, $desc)
{
    // TODO: viết chức năng cập nhật sản phẩm theo id
    $sql = "UPDATE product SET name = ?, price = ?, description = ? WHERE id = ?";
    $conn = get_connection();

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sisi', $name, $price, $desc, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
}

function delete_product($id)
{
    // TODO: viết chức xóa nhật sản phẩm theo id
    $sql = "DELETE FROM product WHERE id = ?";
    $conn = get_connection();

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $stmt->close();
            $conn->close();
            return true;
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    } else {
        die("Prepare failed: " . $conn->error);
    }
}
