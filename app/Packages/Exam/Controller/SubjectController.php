<?php

namespace App\Packages\Exam\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Exam\Facade\SubjectFacade;
use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        protected SubjectFacade $subjectFacade
    )
    {
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $subjectDescription = $request->get('description');

            $subjectCreated = $this->subjectFacade->enrollSubject($subjectDescription);

            $response = [
                'id' => $subjectCreated->getId(),
                'description' => $subjectCreated->getDescription()
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

            $subjects = $this->subjectFacade->listSubjects();
            $subjectsCollection = collect();

            foreach($subjects as $subject) {
                $subjectsCollection->add([
                    'id' => $subject->getId(),
                    'description' => $subject->getDescription()
                ]);
            }

            return response()->json($subjectsCollection->toArray());
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

            $subject = $this->subjectFacade->subjectById($id);

            $response = [
                'id' => $subject->getId(),
                'description' => $subject->getDescription()
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

            $this->subjectFacade->updateSubject($description, $id);

            $response = [
                'id' => $id,
                'description' => $description
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
            $this->subjectFacade->removeSubject($id);

            return response()->json([],204 );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}

