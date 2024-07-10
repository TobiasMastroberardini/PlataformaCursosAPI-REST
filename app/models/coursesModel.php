<?php

require_once 'app/models/model.php';
class CoursesModel extends DB
{

    public function getCourses($page = 1, $limit = 10, $sortField = null, $sortOrder = 'ASC')
    {
        $offset = ($page - 1) * $limit;
        $queryStr = 'SELECT * FROM courses';

        if ($sortField) {
            $queryStr .= " ORDER BY $sortField $sortOrder";
        }

        $queryStr .= " LIMIT $limit OFFSET $offset";

        try {
            $query = $this->connect()->prepare($queryStr);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }


    public function getCourseById($course_id)
    {
        $query = $this->connect()->prepare('SELECT * FROM courses WHERE course_id=?');
        $query->execute([$course_id]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }



    public function deleteCourse($course_id)
    {
        $query = $this->connect()->prepare('DELETE FROM courses WHERE course_id=?');
        $query->execute([$course_id]);
    }
    public function updateCourse($data, $course_id)
    {
        $query = $this->connect()->prepare('UPDATE courses SET category = ?, description = ?, link = ?, teacher_id = ?, title = ?, minutes = ? WHERE course_id = ?');
        $query->execute([
            $data['category'],
            $data['description'],
            $data['link'],
            $data['teacher_id'],
            $data['title'],
            $data['minutes'],
            $course_id
        ]);
    }

    public function getCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('SELECT course_id FROM courses WHERE title=? AND description=? AND teacher_id=? AND link=? AND category=? AND minutes=?');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
        $course = $query->fetch(PDO::FETCH_OBJ);
        return $course;
    }

    public function createCourse($title, $description, $teacher_id, $link, $category, $minutes)
    {
        $query = $this->connect()->prepare('INSERT INTO courses (title,description,teacher_id,link,category,minutes) VALUES (?,?,?,?,?,?)');
        $query->execute([$title, $description, $teacher_id, $link, $category, $minutes]);
    }

    public function getCoursesByCategory($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY category $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCoursesByMinutes($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY minutes $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCoursesByTitle($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY title $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCoursesByTeacher($order)
    {
        $query = $this->connect()->prepare("SELECT * FROM courses ORDER BY teacher_id $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

}