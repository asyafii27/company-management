<?php

namespace App\Http\Controllers\Compane;

use Illuminate\Http\Request;
use App\Models\Company\Worker;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WorkerController extends Controller
{
    protected $permission = "Worker.DataWorker.";

    protected $paginate = 10;
    protected $model = Worker::class;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $request->user()->hasPermission($this->permission . 'View');
        
        $input = $request->all();

        $query = $this->model::query();

        if (!empty($input['page'])) {
            $lists = $query->paginate($this->paginate);
        } else {

            $lists = $query->get();
        }

        return $lists;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:15',
            'role_id' => 'required|numeric',
            'address' => 'required'
        ]);
        
        if ($input->fails()) {
            return response()->json(['errors' => $input->errors()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
