<?php
require_once 'model.php';

class CategoriesModel extends DB
{

    function getCategories($sortField, $sortOrder)
    {

        $query = $this->connect()->prepare("SELECT * FROM categories ORDER BY $sortField $sortOrder");
        $query->execute();

        $categories = $query->fetchAll(PDO::FETCH_OBJ);

        return $categories;
    }

    function getCategoryById($category_id)
    {

        $query = $this->connect()->prepare('SELECT * FROM categories WHERE category_id = ?');
        $query->execute([$category_id]);

        $category = $query->fetch(PDO::FETCH_OBJ);

        return $category;
    }

    function createCategory($category_name)
    {
        $query = $this->connect()->prepare('INSERT INTO categories (category_name) VALUES(?)');
        $query->execute([$category_name]);

        return $this->connect()->lastInsertId();
    }

    function deleteCategory($category_id)
    {

        $queryCourse = $this->connect()->prepare('SELECT * FROM courses WHERE category = ?');
        $queryCourse->execute([$category_id]);

        $queryCourse = $queryCourse->fetchAll(PDO::FETCH_OBJ);

        if (sizeof($queryCourse) > 0) {
            return 1;
        } else {
            $query = $this->connect()->prepare('DELETE FROM categories WHERE category_id = ?');
            $query->execute([$category_id]);
        }
    }

    function updateCategory($category_name, $category_id)
    {

        $query = $this->connect()->prepare('UPDATE categories SET category_name = ? WHERE category_id = ?');
        $query->execute([$category_name, $category_id]);
    }
}