<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Department;

class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

   
     public function index()
    {
        $departments = Department::latest()->paginate(5);

        return view('departments.index',compact('departments'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        return view('departments.create');
    }


     public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',

        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')
                        ->with('success','Department created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show(Department $department)
    {
        return view('departments.show',compact('department'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
         return view('departments.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentD $department)
    {
         request()->validate([
            'name' => 'required',
           
        ]);

        $department->update($request->all());


        return redirect()->route('departments.index')
                        ->with('success','DepartmentD updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy(Department $department)
    {
        $department->delete();


        return redirect()->route('departments.index')
                        ->with('success','Department deleted successfully');
    }

    /**
     * Search department from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    // public function search(Request $request) {
    //     $constraints = [
    //         'name' => $request['name']
    //         ];

    //    $departments = $this->doSearchingQuery($constraints);
    //    return view('department/index', ['departments' => $departments, 'searchingVals' => $constraints]);
    // }

    // private function doSearchingQuery($constraints) {
    //     $query = department::query();
    //     $fields = array_keys($constraints);
    //     $index = 0;
    //     foreach ($constraints as $constraint) {
    //         if ($constraint != null) {
    //             $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
    //         }

    //         $index++;
    //     }
    //     return $query->paginate(5);
    // }
    // private function validateInput($request) {
    //     $this->validate($request, [
    //     'name' => 'required|max:60|unique:department'
    // ]);
    // }
}
