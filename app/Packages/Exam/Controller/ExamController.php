<?php

namespace App\Packages\Exam\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Exam\Facade\ExamFacade;
use App\Packages\Exam\Model\Question;
use App\Packages\Exam\Model\QuestionExam;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Object_;

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
            $numberOfQuestions = $request->get('number_of_questions');


            $examCreated = $this->examFacade->enrollExam($subjectId, $studentId, $numberOfQuestions);

            $response = [
                'id' => $examCreated->getId(),
                'status' => $examCreated->getStatus(),
                'number_of_questions' => $examCreated->getNumberOfQuestions(),
                'subject_id' => $examCreated->getSubject()->getId(),
                'student_id' => $examCreated->getStudent()->getId(),
                'created_at' => $examCreated->getCreatedAt()->format('Y-m-d H:i:s'),
//                'questions' => $questionsList
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
                    'number_of_questions' => $exam->getNumberOfQuestions(),
                    'subject_id' => $exam->getSubject()->getId(),
                    'student_id' => $exam->getStudent()->getId(),
                    'created_at' => $exam->getCreatedAt()->format('Y-m-d H:i:s')
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
                'number_of_questions' => $exam->getNumberOfQuestions(),
                'subject_id' => $exam->getSubject()->getId(),
                'student_id' => $exam->getStudent()->getId(),
                'created_at' => $exam->getCreatedAt()->format('Y-m-d H:i:s')
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function submit(Request $request, string $id): JsonResponse
    {
        try {

            $answers = $request->get('answers');

            $exam = $this->examFacade->examById($id);

            $submittedExam = $this->examFacade->submitExam($exam, $answers);

//            $grade = $submittedExam->getGrade();

            $response = [
                'id' => $submittedExam->getId(),
                'status' => $submittedExam->getStatus(),
                'number_of_questions' => $submittedExam->getNumberOfQuestions(),
                'subject_id' => $submittedExam->getSubject()->getId(),
                'student_id' => $submittedExam->getStudent()->getId(),
                'created_at' => $submittedExam->getCreatedAt()->format('Y-m-d H:i:s'),
                'submitted_at' => $submittedExam->getSubmittedAt()->format('Y-m-d H:i:s'),
//                'answers' => [
//                    'correct' => 'example',
//                    'chosen' => 'example'
//                ],
                'grade' => $submittedExam->getGrade()
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

