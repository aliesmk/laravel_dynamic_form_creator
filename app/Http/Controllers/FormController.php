<?php

namespace App\Http\Controllers;


use App\Http\Requests\StorePosRequest;
use App\Models\Fields;
use App\Models\FieldType;
use App\Models\FieldTypes;
use App\Models\Form;
use App\Models\SubmissionsWithApprovals;
use App\Models\SubmitedForm;
use App\Models\SubmittedForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        $fields = Fields::where('form_id', $form->id)->orderby('sequence')->get();
        return view('form.show', compact('form', 'fields'));
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
    public function update(Request $request, $form_id): \Illuminate\Http\RedirectResponse
    {

        $form = Form::find($form_id);
        if ($request->name) {
            $form->update(['name' => $request->name,
                'description' => $request->description,
            ]);
        }elseif ($request->fields){
            $this->update_form_fields($form, $request);
        }




        return redirect()->back()->with([
            'message' => __('message.action_do_successfully'),
            'icon' => 'success',
            'title' => ''
        ]);

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return $this->set_alert_with_redirect('form.index', 'messages.form_delete_success', 'warning');
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

    private function update_form_fields($form, $request): void
    {
        DB::beginTransaction();
        $fields = new Fields();
        $form_fields = $fields->where('form_id', $form->id)->get();
        $old_field = [];
        foreach ($form_fields as $key => $form_field) {
            $old_field[$key]['key'] = $form_field->key;
            $old_field[$key]['label'] = $form_field->label;
            $old_field[$key]['type'] = $form_field->fieldTypes->name;
        }
        $keys = [];
        $labels = [];
        $error = [];

        foreach ($request->fields as $field) {
            if (in_array($field['key'], $keys) or in_array($field['label'], $labels)) {
                $error = [
                    'message' => __('messages.a_duplicate_field_already_exists'),
                    'icon' => 'error',
                    'title' => ''
                ];
            }
            if (!$field['key'] or !$field['label']) {
                $error = [
                    'message' => __('messages.empty_ky_exist'),
                    'icon' => 'error',
                    'title' => ''
                ];
            }
            $keys[] = $field['key'];
            $labels[] = $field['label'];
        }

        if ($form->final) {
            foreach ($old_field as $form_field) {
                foreach ($request->fields as $f) {

                    if (!in_array($form_field['key'], $keys)) {

                        $error = [
                            'message' => __('messages.cant _delete_old_field_when_form_is_final'),
                            'icon' => 'error',
                            'title' => ''
                        ];
                    }

                    if ($form_field['key'] == $f['key']) {
                        foreach ($f as $k => $f_value) {
                            if (in_array($k, ['key', 'label', 'type']) and $f_value != $form_field[$k]) {
                                $error = [
                                    'message' => __('messages.cant _delete_old_field_when_form_is_final'),
                                    'icon' => 'error',
                                    'title' => ''
                                ];
                            }
                        }
                    }

                }

            }
        }


        if (count($error) > 0) {
            back()->with($error);
            return;
        }


        if ($form_fields->count() >= 1 and $form->final) {


            $form->archive = true;
            $form->save();


            $count = Form::where('root', $form->root)->count() + 1;

            $newForm = Form::create([
                'name' => $form->name,
                'description' => $form->description,
                'root' => $form->root,
                'code' => $count,
                'file' => $form->file,
            ]);


            $data_label = [];
            $data_key = [];
            $data_ids = [];
            foreach ($request->fields as $field) {


                $required = false;
                if (isset($field['required'])) {
                    $required = true;
                }
                $d = [
                    'form_id' => $newForm->id,
                    'label' => $field['label'],
                    'key' => $field['key'],
                    'options' => isset($field['options']) ? json_encode($field['options']) : null,
                    'field_type_id' => FieldType::where('name', $field['type'])->first()->id,
                    'placeholder' => $field['placeholder'] ?? null,
                    'required' => $required,
                    'sequence' => $field['sequence'] ?? null,
                    'tooltip' => $field['tooltip'] ?? null,
                ];

                $n_f = Fields::create($d);

                $data_ids[] = $n_f->id;
                $data_key[] = $n_f->key;
                $data_label[] = $n_f->label;
            }


            //SubmittedForm

            $submitted_ids = SubmittedForm::where('form_id', $form->id)->get();

            foreach ($submitted_ids as $submitted_id) {
                $data_id = [];
                $data_name = [];
                $data_k = [];
                foreach (json_decode($submitted_id->data_key) as $key => $sub) {
                    $fields = Fields::where('form_id', $newForm->id)->where('key', $key)->first();
                    if ($fields) {
                        $data_id[$fields->id] = $sub;
                        $data_name[$fields->label] = $sub;
                        $data_k[$fields->key] = $sub;
                    }
                }

                foreach ($data_label as $label) {
                    if (!in_array($label, array_keys($data_name))) {
                        $data_name[$label] = '';
                    }
                }

                foreach ($data_key as $item) {
                    if (!in_array($item, array_keys($data_k))) {
                        $data_k[$item] = '';
                    }
                }

                foreach ($data_ids as $v) {
                    if (!in_array($v, array_keys($data_id))) {
                        $data_id[$v] = '';
                    }
                }


                $new = $submitted_id->replicate();
                $new->form_id = $newForm->id;
                $new->data_id = json_encode($data_id);
                $new->data = json_encode($data_name);
                $new->data_key = json_encode($data_k);
                $new->save();
            }


        } elseif (!$form->final) {

            Fields::where('form_id', $form->id)->delete();
            $data = [];
            foreach ($request->fields as $field) {
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

            $fields::insert($data);
        }
        DB::commit();


    }

}
