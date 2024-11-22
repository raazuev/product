<?php

require_once 'db.php';

function getProductList($pdo, $groupId = null) {
    if ($groupId === null) {
        $sql = "SELECT * FROM products";
        $stmt = $pdo->query($sql);
    } else {
        $sql = "SELECT * FROM products WHERE id_group = :group_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['group_id' => $groupId]);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>