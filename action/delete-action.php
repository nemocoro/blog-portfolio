<?php
    include '../class/category.php';

    $category = new Category();

    $id = (isset($_GET["id"]))?$_GET["id"]:NULL;
    $category->deleteCategory($id);
?>