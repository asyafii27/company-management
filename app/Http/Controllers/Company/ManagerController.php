<?php

namespace App\Http\Controllers\Company;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Company\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ManagerController extends Controller
{
    protected $permission = "Manager.DataManager.";

    protected $paginate = 10;
    protected $model = Manager::class;

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
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $request->user()->hasPermission($this->permission . 'Show');
        
        $query = $this->model::find($id);
        if (empty($query)) return $this->errorResponse(null. 422, 'Data tidak ditemukan');

        return $this->successResponse('OK', $query, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->user()->hasPermission($this->permission . 'Edit');
        
        $input = $request->validate([
            'name'  => 'required|max:155',
            'phone_number'  => 'required|max:15|min:9',
            'address' => 'required|max:255'
        ]);

        try {
            DB::beginTransaction();
            
            $query = $this->model::find($id);
            if (empty($query)) return $this->errorResponse(null. 422, 'Data tidak ditemukan');
            $query->update($input);

            User::where('reff_id', $id)->update(['name' => $input['name']]);
                
            DB::commit();

            return $this->successResponse('OK', $query, 200);
        } catch (Exception $e) {
            DB::rollback();
            
            Log::error('message');
            return $this->errorResponse(422, null, $e->getMessage());
        }



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        // $request->user()->hasPermission($this->permission . 'Delete');
        $query = $this->model::find($id);
        if (empty($query)) return $this->errorResponse(null. 422, 'Data tidak ditemukan');
        $query->delete();

        return $this->successResponse('OK', [], 204);
    }
}
