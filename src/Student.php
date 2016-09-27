<?php
    class Student
    {
        private $name;
        private $enroll_date;
        private $id;

        function __construct($name, $enroll_date, $id = null)
        {
            $this->name = $name;
            $this->enroll_date = $enroll_date;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setDate($new_date)
        {
            $this->enroll_date = (string) $new_date;
        }

        function getDate()
        {
            return $this->enroll_date;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enroll_date) VALUES ('{$this->getName()}', {$this->getDate()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $date = $student['enroll_date'];
                $id = $student['id'];
                $new_student = new student($name, $date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");
        }

    }
?>
