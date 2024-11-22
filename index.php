<?php

require 'db.php';
require 'groupModel.php';
require 'productModel.php';

$group_id = 1;
$groupProductsCount = getGroupProductsCount($pdo, $group_id);

$selectedGroup = isset($_GET['group']) ? intval($_GET['group']) : null;

$allGroups = getSubgroupsRecursive($pdo, 0);

$products = $selectedGroup ? getProductList($pdo, $selectedGroup) : getProductList($pdo);

function renderGroups($groups) {
    global $pdo; 
    echo '<ul>';
    foreach ($groups as $group) {
        $productCountData = getGroupProductsCount($pdo, $group['id']);
        $productCount = $productCountData ? $productCountData[0]['product_count'] : 0;
        echo "<li>
                <a href='?group={$group['id']}'>{$group['name']} ({$productCount})</a>";
        if (!empty($group['subgroups'])) {
            echo '<ul>'; 
            renderGroups($group['subgroups']);
            echo '</ul>';
        }
        echo '</li>';
    }
    echo '</ul>';
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Группы товаров</title>
    <link rel="stylesheet" href="css/index.min.css">
</head>
<body>
    <div class="group__container">
        <h1>Группы товаров</h1>
        <?php renderGroups($allGroups); ?>

        <h2>Товары</h2>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <a href=""><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="js/index.js"></script>
</body>
</html>