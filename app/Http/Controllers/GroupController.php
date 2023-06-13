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
}
