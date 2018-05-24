<?php

function buildCategoryList() {
    $categories = getCategories();
    $catList = '<select name="categoryId" id="categoryId">';
    foreach ($categories as $category) {
        $catList .= '<option value="'.urlencode($category['categoryId']).'">'.urlencode($category['categoryName']).'</option>';
    }
    $catList .= '</select>';
    return $catList;
}

function newCategory($categoryName){
    $db = acmeConnect();
    $sql = 'INSERT INTO categories (categoryName)
        VALUES ( :categoryName )';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

function newProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle){
    $db = acmeConnect();
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail, invPrice, invStock, invSize, invWeight, invLocation, categoryId, invVendor, invStyle)
        VALUES (:invName, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryId, :invVendor, :invStyle)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
   $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
   $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
   $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
   $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
   $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
   $stmt->bindValue(':invSize', $invSize, PDO::PARAM_STR);
   $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_STR);
   $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
   $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_STR);
   $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
   $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
   $stmt->execute();
   $rowsChanged = $stmt->rowCount();
   $stmt->closeCursor();
   return $rowsChanged;
}