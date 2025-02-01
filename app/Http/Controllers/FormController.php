<?php

namespace App\Http\Controllers;

use App\Enums\FormStatus;
use App\Http\Requests\StorePosRequest;
use App\Models\Fields;
use App\Models\FieldType;
use App\Models\FieldTypes;
use App\Models\Form;
use App\Models\SubmissionsWithApprovals;
use App\Models\SubmitedForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $fieldTypes = FieldType::all();
        return view('form.create', compact('fieldTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePosRequest $request)
    {

        $form = Form::create(['name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->fields) {
            $fields = $request->input('fields');
            DB::beginTransaction();


            $keys = [];
            $labels = [];
            $error = [];

            foreach ($fields as $field) {
                if (in_array($field['key'], $keys) or in_array($field['label'], $labels)) {
                    $error = $this->set_alert('messages_error_field_already_exists', 'error');

                }
                if (!$field['key'] or !$field['label']) {
                    $error = $this->set_alert('messages_error_field_is_required', 'error');

                }
                $keys[] = $field['key'];
                $labels[] = $field['label'];
            }


            if (count($error) > 0) {
                return back()->with($error);
            }


            if (!$form->final) {

                Fields::where('form_id', $form->id)->delete();
                $data = [];
                foreach ($fields as $field) {
                    $required = false;
                    if (isset($field['required'])) {
                        $required = true;
                    }
                    $data[] = [
                        'form_id' => $form->id,
                        'label' => $field['label'],
                        'key' => $field['key'],
                        'options' => isset($field['options']) ? json_encode($field['options']) : null,
                        'field_type_id' => FieldType::where('name', $field['type'])->first()->id,
                        'placeholder' => $field['placeholder'] ?? null,
                        'required' => $required,
                        'sequence' => $field['sequence'] ?? null,
                        'tooltip' => $field['tooltip'] ?? null,
                    ];
                }

                Fields::insert($data);
            }
            DB::commit();
        }

        return $this->set_alert_with_redirect('form.index', 'messages.form_create_success', 'success');
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
        if ($form->archive) {
            return redirect()->back()->with([
                'message' => __('messages.can_not_edit_archived_form '),
                'icon' => 'error',
                'title' => ''
            ]);
        }

        $form_fields = Fields::where('form_id', $form->id)->orderBy('sequence')->orderBy('created_at')->get();
        $fieldTypes = FieldType::all();
        $forms = Form::where('archive', false)->get();
        return view('form.edit', compact('form', 'form_fields', 'fieldTypes', 'forms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $form_id)
    {
        $form = Form::find($form_id);

        if ($form->archive) {
            return redirect()->back()->with([
                'message' => 'امکان ویرایش نسخه های قبلی وجود ندارد',
                'icon' => 'error',
                'title' => ''
            ]);
        }


        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'file' => 'mimes:csv,xlsx,xls,'
        ]);

        $file = $request->file;

        if (!empty($file)) {
            $storagePath = public_path('uploads/sampleForms/');

            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true);
            }
            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move($storagePath, $fileName);
            $relativePath = 'uploads/sampleForms/' . $fileName;


        }

        $form->update(['name' => $request->name,
            'description' => $request->description,
            'file' => $relativePath ?? $form->file,

        ]);


        return redirect()->back()->with([
            'message' => 'عملیات با موفقیت انجام شد',
            'icon' => 'success',
            'title' => ''
        ]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        //
    }


    private function set_alert($messages = '', $type = '', $title = '')
    {
        return [
            'message' => __("$messages"),
            'icon' => "$type",
            'title' => "$title",
        ];
    }

    private function set_alert_with_redirect($route, $messages, $type = '', $title = '')
    {
        return redirect()->route("$route")->with([
            'message' => __($messages),
            'icon' => $type,
            'title' => $title,
        ]);

    }
}
