<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Todo;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
    public function index()
    {
        $todo = new Todo;
        if (!empty($_GET)) {
            $params = [
                'search_query' => '$todo->where("title", "like", "%" . $_GET["search_query"] . "%")->orWhere("text", "like", "%" . $_GET["search_query"] . "%");',
                'completed' => '$todo->where("completed",$_GET["completed"]);'
            ];

            foreach ($_GET as $key => $value) {
                try {
                    eval('$todo = '.$params[$key]);
                } catch (\Throwable $th) {
                }
            }
        }

        return response()->json([
            'data' => $todo->get(),
        ],Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['required','max:255','string'],
            'text' => ['required','max:255','string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $todo = Todo::create($validator->validated());
            return response()->json([
                'message' => 'success'
            ],Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'errors' => [
                    'roots' => $th->getMessage(),
                ]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request,Todo $todo)
    {
        $validator = Validator::make($request->all(),[
            'title' => ['max:255','string'],
            'text' => ['max:255','string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ],Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $todo->update($validator->validated());
            return response()->json([
                'message' => 'success',
            ],Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'errors' => [
                    'roots' => $th->getMessage()
                ]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Todo $todo)
    {
        return response()->json([
            'data' => $todo
        ],Response::HTTP_OK);
    }

    public function destroy(Todo $todo)
    {
        try {
            $todo->delete();

            return response()->json([
                'message' => 'success',
            ],Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'errros' => [
                    'roots' => $th->getMessage(),
                ]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function checkUncheck(Request $request,Todo $todo)
    {
        try {
            $todo->update([
                'completed' => $request->completed
            ]);

            return response()->json([
                'message' => 'success',
            ],Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'errors' => [
                    'roots' => $th->getMessage()
                ]
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
