<?php

require_once 'db.php';

function getGroups($pdo, $idParent = 0) {
    $sql = "SELECT * FROM `groups` WHERE id_parent = :id_parent";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_parent' => $idParent]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getGroupProductsCount($pdo, $group_id) {
    $sql = "
        SELECT g.id, COUNT(p.id) AS product_count
        FROM `groups` g
        LEFT JOIN products p ON p.id_group = g.id
        WHERE g.id = :group_id
        GROUP BY g.id
        UNION ALL
        SELECT g.id, COUNT(p.id) AS product_count
        FROM `groups` g
        LEFT JOIN products p ON p.id_group = g.id
        WHERE g.id_parent = :group_id
        GROUP BY g.id
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['group_id' => $group_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSubgroupsRecursive($pdo, $parentId = 0) {
    $groups = getGroups($pdo, $parentId);
    foreach ($groups as &$group) {
        $group['subgroups'] = getSubgroupsRecursive($pdo, $group['id']);
    }
    return $groups;
}

?>