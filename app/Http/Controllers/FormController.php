<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePosRequest;
use App\Models\Form;
use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $q = Form::query();

        // Search functionality
        $search_value = $request->input('search');

        // Apply search filter if it exists
        if ($search_value) {
            $q->where(function ($query) use ($search_value) {
                $query->where('name', 'like', '%' . $search_value . '%')
                    ->orWhere('description', 'like', '%' . $search_value . '%');
            });
        }

        // Apply filters for 'final' and 'archive'
        $q->when($request->has('final') && $request->input('final') !== null, function ($query) use ($request) {
            return $query->where('final', $request->input('final'));
        });

        $q->when($request->has('archive') && $request->input('archive') !== null, function ($query) use ($request) {
            return $query->where('archive', $request->input('archive'));
        });

        // Order and paginate the results
        $forms = $q->orderBy('archive')->orderBy('id', 'desc')->paginate(20)->withQueryString();

        return view('form.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePosRequest  $request)
    {
        Form::create(['name' => $request->name,
            'description' => $request->description]);


        return redirect()->route('form.index')->with([
            'message' => __('messages.form_created'), // Use translation here
            'icon' => 'success',
            'title' => ''
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        //
    }
}
