<?php

namespace App\Http\Controllers;

use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @var \App\Services\StudentService $service
     */
    public $service;

    public function __construct(StudentService $service) {
        $this->service = $service;
    }

    public function answerDetail(Request $request, $group_id, $assignment_id) {
        $results = $this->service->answerDetail($group_id, $assignment_id, $request->user()->id);
        return response()->json([
            'data' => $results
        ], 200);
    }

    public function listGroupOfStudent(Request $request)
    {
        $results = $this->service->listGroupOfStudent($request->user()->id);
        return response()->json([
            'data' => $results
        ], 200);
    }
}
