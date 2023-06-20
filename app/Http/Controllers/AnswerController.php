<?php

namespace App\Http\Controllers;

use App\Services\AnswerService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * @var \App\Services\AnswerService $service
     */
    public $service;

    public function __construct(AnswerService $service) {
        $this->service = $service;
    }

    public function answerList($group_id, $assignment_id)
    {
        $results = $this->service->answerList($group_id, $assignment_id);
        return response()->json([
            'data' => $results
        ], 200);
    }
}
