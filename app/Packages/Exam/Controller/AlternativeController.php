<?php

namespace App\Packages\Exam\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Exam\Facade\AlternativeFacade;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function __construct(
        protected AlternativeFacade $alternativeFacade,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $alternativeDescription = $request->get('description');
            $correct = $request->get('correct');
            $questionId = $request->get('question_id');

            $alternativeCreated = $this->alternativeFacade->enrollAlternative($alternativeDescription, $correct, $questionId);

            $response = [
                'id' => $alternativeCreated->getId(),
                'description' => $alternativeCreated->getDescription(),
                'correct' => $alternativeCreated->getCorrect(),
                'question_id' => $alternativeCreated->getQuestion()->getId()
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

            $alternatives = $this->alternativeFacade->listAlternatives();

            $alternativesCollection = collect();


            foreach($alternatives as $alternative) {
                $alternativesCollection->add([
                    'id' => $alternative->getId(),
                    'description' => $alternative->getDescription(),
                    'correct' => $alternative->getCorrect(),
                    'question_id' => $alternative->getQuestion()->getId()
                ]);
            }

            return response()->json($alternativesCollection->toArray());
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

            $alternative = $this->alternativeFacade->alternativeById($id);

            $response = [
                'id' => $alternative->getId(),
                'description' => $alternative->getDescription(),
                'correct' => $alternative->getCorrect(),
                'question_id' => $alternative->getQuestion()->getId()
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
            $correct = $request->get('correct');

            $alternative = $this->alternativeFacade->updateAlternative($description, $correct, $id);

            $response = [
                'id' => $alternative->getId(),
                'description' => $alternative->getDescription(),
                'correct' => $alternative->getCorrect(),
                'question_id' => $alternative->getQuestion()->getId()
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
            $this->alternativeFacade->removeAlternative($id);

            return response()->json([],204 );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}

