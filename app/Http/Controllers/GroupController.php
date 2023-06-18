<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @var \App\Services\GroupService $service
     */
    public $service;
 
    public function __construct(GroupService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $user_id = $request->user()->id;
        $classes = $this->service->getGroupList($params, $user_id);
        return response()->json(['data' => $classes]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = $this->service->getGroupDetailById($id);
        return response()->json(['data' => $info]) ;
    }

    public function getAssignments($id)
    {
        $assignments['not_start'] = $this->service->getAssignmentsNotStart($id);
        $assignments['started'] = $this->service->getAssignmentsStarted($id);
        $assignments['ended'] = $this->service->getAssignmentsEnded($id);
        return response()->json(['data' => $assignments]);
    }

    public function storeAssignmentGroupId(Request $request, $id)
    {
        $data = $request->all();
        $results = $this->service->storeAssignmentGroupId($data, $id);
        if (!$results) {
            return response()->json([
                'message' => 'something went wrong'
            ], 500);
        }
        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }

    public function updateAssignmentGroupId(Request $request, $id, $assignment_id)
    {
        $data = $request->all();
        $results = $this->service->updateAssignmentGroupId($data, $id, $assignment_id);
        if (!$results) {
            return response()->json([
                'message' => 'something went wrong'
            ], 500);
        }
        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }

    public function deleteAssignmentGroupId($id, $assignment_id)
    {
       $results = $this->service->deleteAssignmentGroupId($assignment_id);
       if (!$results) {
            return response()->json([
                'message' => 'something went wrong'
            ], 500);
        }
        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }
}
