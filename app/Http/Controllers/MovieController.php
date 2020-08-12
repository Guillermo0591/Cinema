<?php

namespace App\Http\Controllers;

use App\Cinema\Models\Movie;
use App\Cinema\Models\Turn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tymon\JWTAuth\Exceptions\JWTException;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $movies = Movie::with('turns')->get();

        $response = [];
        $status = false;
        foreach ($movies as $movie) {
            foreach ($movie->turns as $turn) {
                if ($turn->status == true) {
                    $status = true;
                }
            }
            $response[] = [
                'id' => $movie->id,
                'name' => $movie->name,
                'publication_date' => Carbon::createFromFormat('Y-m-d H:i:s', $movie->publication_date)->format('d/m/Y'),
                'status' => $status
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    public function assingMovieToTurn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'movie_id' => ['required', 'integer'],
            'turn_id' => ['required', 'integer'],
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $movie = Movie::find($request->get('movie_id'));
        $turn =  Turn::find($request->get('turn_id'));

        $movie->turns()->attach($turn);

        return response()->json([
            'message' => 'Successfully movie assinged to turn',
        ], 202);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $userLogged = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'publication_date' => ['required', 'date_format:d/m/Y'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120']
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        $filename = $userLogged->id. "-".substr(md5($userLogged->id.'-'.time()), 0, 15).'.'.$request->image->extension();
        $path = public_path('movies/'.$filename);

        $request->image->move(public_path('movies'), $filename);
        $movie = Movie::create([
            'name' => $request->get('name'),
            'publication_date' => Carbon::createFromFormat('d/m/Y', $request->get('publication_date'))->format('Y-m-d'),
            'path' => $path
        ]);

        return response()->json([
            'message' => 'Successfully movie saved',
            'turn' => $movie
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $movie = Movie::with('turns')->find($id);

        $response = [];
        $status = false;

        foreach ($movie->turns as $turn) {
            if ($turn->status == true) {
                $status = true;
            }
        }
        $response[] = [
            'id' => $movie->id,
            'name' => $movie->name,
            'publication_date' => Carbon::createFromFormat('Y-m-d H:i:s', $movie->publication_date)->format('d/m/Y'),
            'status' => $status
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);
        $userLogged = auth()->user();
        $validator = Validator::make($request->all(), [
            'publication_date' => ['date_format:d/m/Y'],
            'image' => ['image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ]);

        if($validator->fails()) {
            return response()->json($validator->messages(), 200);
        }

        if ($request->image) {
            $filename = $userLogged->id. "-".substr(md5($userLogged->id.'-'.time()), 0, 15).'.'.$request->image->extension();
            $path = public_path('movies/'.$filename);

            $request->image->move(public_path('movies'), $filename);

            $attributes = [
                'path' => $path
            ];

            if ($request->get('name')) {
                array_push($attributes, ['name' => $request->get('namefin')]);
            }
            if ($request->get('publication_date')){
                array_push($attributes, ['publication_date' => Carbon::createFromFormat('d/m/Y', $request->get('publication_date'))->format('Y-m-d'),]);
            }

            $movie->update($attributes);
        } else {
            $movie->update($request->all());
        }

        return response()->json([
            'message' => 'Successfully movie updated',
            'movie' => $movie
        ], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        $movie->delete();

        return response()->json([
            'message' => 'Successfully turn deleted',
            'turn' => $movie
        ], 202);
    }
}
