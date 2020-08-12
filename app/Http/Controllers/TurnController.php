<?php

namespace App\Http\Controllers;

use App\Cinema\Models\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TurnController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turns = Turn::all();

        $response = [];
        foreach ($turns as $turn) {
            $response[] = [
                'id' => $turn->id,
                'turn' => $turn->turn,
                'active' => $turn->status
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'turn' => ['required', 'date_format:H:i', 'unique:turns'],
            'status' => ['required', 'boolean']
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $turn = Turn::create([
            'turn' => $request->get('turn'),
            'status' => $request->get('status')
        ]);

        return response()->json([
            'message' => 'Successfully turn saved',
            'turn' => $turn
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $turn = Turn::find($id);

        $response = [
            'id' => $turn->id,
            'turn' => $turn->turn,
            'active' => $turn->status
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $turn = Turn::find($id);

        $validator = Validator::make($request->all(), [
            'turn' => ['date_format:H:i', 'unique:turns'],
            'status' => ['boolean']
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $turn->update($request->all());

        return response()->json([
            'message' => 'Successfully turn updated',
            'turn' => $turn
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turn =Turn::find($id);

        $turn->delete();

        return response()->json([
            'message' => 'Successfully turn deleted',
            'turn' => $turn
        ], 202);
    }
}
