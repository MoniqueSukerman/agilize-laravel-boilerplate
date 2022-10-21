<?php

namespace App\Packages\Exam\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Exam\Facade\ExamFacade;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(
        protected ExamFacade $examFacade,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $subjectId = $request->get('subject_id');
            $studentId = $request->get('student_id');
            $numberOfQuestions = $request->get('numberofquestions');

            $examCreated = $this->examFacade->enrollExam($subjectId, $studentId, $numberOfQuestions);

            $response = [
                'id' => $examCreated->getId(),
                'status' => $examCreated->getStatus(),
                'numberofquestions' => $examCreated->getNumberOfQuestions(),
                'subject_id' => $examCreated->getSubject()->getId(),
                'student_id' => $examCreated->getStudent()->getId()
            ];

            return response()->json($response, 201);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        try {

            $exams = $this->examFacade->listExams();

            $examsCollection = collect();


            foreach($exams as $exam) {
                $examsCollection->add([
                    'id' => $exam->getId(),
                    'status' => $exam->getStatus(),
                    'numberofquestions' => $exam->getNumberOfQuestions(),
                    'subject_id' => $exam->getSubject()->getId(),
                    'student_id' => $exam->getStudent()->getId()
                ]);
            }

            return response()->json($examsCollection->toArray());
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function findById(Request $request, string $id): JsonResponse
    {
        try {

            $exam = $this->examFacade->examById($id);

            $response = [
                'id' => $exam->getId(),
                'status' => $exam->getStatus(),
                'numberofquestions' => $exam->getNumberOfQuestions(),
                'subject_id' => $exam->getSubject()->getId(),
                'student_id' => $exam->getStudent()->getId()
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function submit(Request $request, string $id): JsonResponse
    {
        try {

            $exam = $this->examFacade->examById($id);

            $submitedExam = $this->examFacade->submitExam($exam);

            $response = [
                'id' => $submitedExam->getId(),
                'status' => $submitedExam->getStatus(),
                'numberofquestions' => $submitedExam->getNumberOfQuestions(),
                'subject_id' => $submitedExam->getSubject()->getId(),
                'student_id' => $submitedExam->getStudent()->getId()
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function remove(Request $request, string $id): JsonResponse
    {
        try {
            $this->examFacade->removeExam($id);

            return response()->json([],204 );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}

