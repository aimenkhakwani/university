<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function test_getName()
        {
            // Assemble
            $name = "Hector";
            $date = "04-06-98";
            $test_student = new Student($name, $date);

            // Act
            $result = $test_student->getName();

            // Assert
            $this->assertEquals("Hector", $result);
        }

        function test_getDate()
        {
            // Assemble
            $name = "Hector";
            $date = "04-06-98";
            $test_student = new Student($name, $date);

            // Act
            $result = $test_student->getDate();

            // Assert
            $this->assertEquals($date, $result);
        }

        function test_getId()
        {
            // Assemble
            $name = "Hector";
            $date = "040618";
            $id = 1;
            $test_student = new Student($name, $date, $id);

            // Act
            $result = $test_student->getId();

            // Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            $name = "Hector";
            $date = "040618";
            $id = null;
            $test_student = new Student($name, $date, $id);

            //act
            $test_student->save();

            //assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            $name = "Hector";
            $date = "6";
            $id = null;
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Hec";
            $date2 = "4";
            $test_student2 = new Student($name2, $date2, $id);
            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function deleteAll()
        {
            $name = "Hector";
            $date = "8";
            $id = null;
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Hec";
            $date2 = "4";

            $test_student2 = new Student($name2, $date2, $id);
            $test_student2->save();

            Student::deleteAll();

            $result = Student::getAll();

            $this->assertEquals([], $result);
        }
    }
?>
