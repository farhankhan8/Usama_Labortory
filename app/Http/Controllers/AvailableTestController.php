<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\AvailableTest;
use App\Models\TestPerformed; 
use Session;
use App\Models\Category;
use Gate; 
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class AvailableTestController extends Controller
{
    public function index()
    { 
        $availableTests = AvailableTest::all();
        return view('admin.availableTests.index', compact('availableTests'));
    }
    public function create()
    {
        $categoryNames = Category::all()->pluck('Cname', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.availableTests.create',compact('categoryNames'));
    }
    public function store(Request $request)
    {
        $availableTest = AvailableTest::create($request->all());
        return redirect()->route('available-tests');
    }   
    public function edit($id)
    {
        $availableTest = AvailableTest::findOrFail($id);
        $catagorys = Category::all()->pluck('Cname', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.availableTests.edit', compact('availableTest','catagorys'));
    }
    public function update($id, Request $request)
   {
    $task = AvailableTest::findOrFail($id);
    $input = $request->all();
    $task->fill($input)->save();
    // Session::flash('flash_message', 'Task successfully added!');
    return redirect()->route('available-tests');
}
    public function show($id)
    {
        $availableTestId = AvailableTest::findOrFail($id);
        return view('admin.availableTests.show', compact('availableTestId'));
    }
    public function destroy($id)
    {
        $task = AvailableTest::findOrFail($id);
        $task->delete();
        // Session::flash('flash_message', 'Task successfully deleted!');
        return redirect()->route('available-tests');
    }
}
