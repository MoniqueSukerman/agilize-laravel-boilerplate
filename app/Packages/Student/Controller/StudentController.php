<?php

namespace App\Packages\Student\Controller;

use App\Http\Controllers\Controller;
use App\Packages\Student\Facade\StudentFacade;
use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

class StudentController extends Controller
{
    public function __construct(
        protected StudentFacade $studentFacade
    )
    {
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $studentName = $request->get('name');

            $this->studentFacade->enrollStudent($studentName);
            
            $student = $this->studentFacade->studentByName($studentName);

            $response = [
                'id' => $student[0]->getId(),
                'name' => $student[0]->getName()
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

            $students = $this->studentFacade->listStudents();
            $studentsCollection = collect();

            foreach($students as $student) {
                $studentsCollection->add([
                    'id' => $student->getId(),
                    'name' => $student->getName()
                ]);
            }


            return response()->json($studentsCollection->toArray());
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

            $student = $this->studentFacade->studentById($id);

            $response = [
                'id' => $student->getId(),
                'name' => $student->getName()
            ];

            return response()->json($response);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function findByName(Request $request, string $name): JsonResponse
    {
        try {

            $student = $this->studentFacade->studentByName($name);

            $response = [
                'id' => $student[0]->getId(),
                'name' => $student[0]->getName()
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
            $name = $request->get('name');

            $this->studentFacade->updateStudent($name, $id);

            $response = [
                'id' => $id,
                'name' => $name
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
            $this->studentFacade->removeStudent($id);

            return response()->json([],204 );
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}

