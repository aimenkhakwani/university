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

        function test_update()
        {
            $name = "Hector";
            $date = "8";
            $id = null;
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $new_name = "Hex";

            $test_student->update($new_name);
            $result = $test_student->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_delete()
        {
            $name = "Hector";
            $date = "8";
            $id = null;
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $result = $test_student->delete();

            $this->assertEquals([], $test_student->getAll());
        }

        function test_find()
        {
            $name = "Hector";
            $date = "8";
            $id = null;
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $name2 = "Hector";
            $date2 = "8";
            $id = null;
            $test_student2 = new Student($name2, $date2, $id);
            $test_student2->save();

            $find_id = $test_student2->getId();
            $result = Student::find($find_id);

            $this->assertEquals($test_student2, $result);
        }

        function test_add_course()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name = "Hector";
            $date = "78";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $test_student->addCourse($test_course);
            $result = $test_student->getCourses();

            $this->assertEquals([$test_course], $result);
        }

        function test_getCourses()
        {
            $name = "Beginner History";
            $course_number = "HIST100";
            $id = null;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Beginner History";
            $course_number2 = "HIST100";
            $id = null;
            $test_course2 = new Course($name2, $course_number2, $id);
            $test_course2->save();

            $name = "Hector";
            $date = "78";
            $test_student = new Student($name, $date, $id);
            $test_student->save();

            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            $result = $test_student->getCourses();

            $this->assertEquals([$test_course, $test_course2], $result);
        }
    }
?>
