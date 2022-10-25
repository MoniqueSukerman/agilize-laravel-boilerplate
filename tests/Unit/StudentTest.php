<?php

namespace Tests\Unit;

use App\Packages\Exam\Model\Alternative;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Repository\AlternativeRepository;
use App\Packages\Exam\Repository\QuestionRepository;
use App\Packages\Exam\Service\AlternativeService;
use App\Packages\Student\Model\Student;
use App\Packages\Student\Repository\StudentRepository;
use App\Packages\Student\Service\StudentService;
use Exception;
use PHPUnit\Framework\TestCase;

class StudentTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testEnrollStudentFunctionShouldReturnStudent()
    {
        // given

        $studentRepository = $this->createMock(StudentRepository::class);

        $studentService = new StudentService($studentRepository);

        // when
        $result = $studentService->enrollStudent(
            'Joana',
        );

        // then
        $this->assertInstanceOf(Student::class, $result);
    }

}
