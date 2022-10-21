<?php

namespace App\Packages\Exam\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Exam\Facade\QuestionFacade;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionFacade $questionFacade
    )
    {
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $questionDescription = $request->get('description');
            $subjectId = $request->get('subject_id');

            $questionCreated = $this->questionFacade->enrollQuestion($questionDescription, $subjectId);

            $response = [
                'id' => $questionCreated->getId(),
                'description' => $questionCreated->getDescription(),
                'subject_id' => $questionCreated->getSubject()->getId()
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

            $questions = $this->questionFacade->listQuestions();

            $questionsCollection = collect();


            foreach($questions as $question) {
                $questionsCollection->add([
                    'id' => $question->getId(),
                    'description' => $question->getDescription(),
                    'subject_id' => $question->getSubject()->getId()
                ]);
            }

            return response()->json($questionsCollection->toArray());
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

            $question = $this->questionFacade->questionById($id);

            $response = [
                'id' => $question->getId(),
                'description' => $question->getDescription(),
                'subject_id' => $question->getSubject()->getId()
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {

            $description = $request->get('description');
            $subject = $request->get('subject_id');

            $question = $this->questionFacade->updateQuestion($description, $id, $subject);

            $response = [
                'id' => $question->getId(),
                'description' => $question->getDescription(),
                'subject_id' => $question->getSubject()->getId()
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
            $this->questionFacade->removeQuestion($id);

            return response()->json([],204 );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}

