<?php

namespace App\Http\Controllers;

use App\Author;

use App\Traits\APIResponser;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{

    use APIResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * view a list of Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function index(){

        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * create a new Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:7|in:male,female',
            'country' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::create($request->all());
        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * View an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function show($author){

        $author = Author::findOrFail($author);
        return $this->successResponse($author);
    }

    /**
     * update an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){

        $rules = [
            'name' => 'max:255',
            'gender' => 'max:7|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);
        $author->fill($request->all());

        if ($author->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();
        return $this->successResponse($author);
    }

    /**
     * Remove an existing Authors.
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($author){

        $author = Author::findOrFail($author);
        $author->delete();
        return $this->successResponse($author);
    }
}
