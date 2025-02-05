@extends('layout.app')

@section('content')
    <div class="max-w-4xl mx-auto mb-8 mt-8 p-6 bg-white shadow-md rounded-lg">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold text-gray-800">{{ $form->name }}</h1>
            <a onclick="window.history.back();"
               class="btn add-option bg-gray-600  mb-4 text-white px-2 py-1 mt-4 rounded hover:bg-gray-400">بازگشت</a>
        </div>
        <p class="text-gray-600 mt-2">{{ $form->description }}</p>


        <div  class="mb-2 mt-8">

            @foreach ($fields as $field)
                <div class="mb-6">

                    <label for="{{ $field->id }}"
                           class="block text-sm font-medium text-gray-700 mb-2">
                        {{$field->label}}
                        @if($field->tooltip)

                            <div class="tooltip">
                                <img width="18" title="{{$field->tooltip}}"  height="18" src="https://img.icons8.com/plumpy/24/info.png" alt="info"/>
                            </div>
                        @endif

                    </label>
                    @php
                        $fieldType = $field->fieldTypes;
                    @endphp
                    @if ($fieldType)
                        @switch($fieldType->name)
                            @case('Text')
                                <input type="text" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Textarea')
                                <textarea name="{{ $field->id }}" id="{{ $field->id }}"
                                          placeholder="{{ $field->placeholder }}"
                                          class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                      {{ $field->required ? 'required' : '' }}>{{old($field->id)}}</textarea>
                                @break

                            @case('Number')
                                <input type="number" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Email')
                                <input type="email" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Password')
                                <input type="password" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Date')
                                <input type="date" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Datetime')
                                <input type="datetime-local" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Checkbox')
                                @php
                                    // Decode the JSON string into an array
                                    $options = json_decode($field->options, true);
                                @endphp

                                @if (is_array($options))
                                    @foreach ($options as $option)
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" name="{{ $field->id }}[]" value="{{ $option}}"
                                                   class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-600"
                                                   @if (is_array(old($field->id)) && in_array($option, old($field->id))) checked @endif
                                            >
                                            <label class="ml-2 text-gray-700 m-1">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-red-500">Invalid options data</p>
                                @endif
                                @break

                            @case('Radio')
                                @php
                                    // Decode the JSON string into an array
                                    $options = json_decode($field->options, true);
                                @endphp

                                @if (is_array($options))
                                    @foreach ($options as $option)
                                        <div class="flex items-center mb-2">
                                            <input type="radio" name="{{ $field->id }}" value="{{ $option }}"
                                                   class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                                   @if (old($field->id) == $option) checked @endif
                                            >
                                            <label class="ml-2 text-gray-700 m-1">{{ $option }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-red-500">Invalid options data</p>
                                @endif
                                @break

                            @case('Select')
                                <select name="{{ $field->id }}" id="{{ $field->id }}"

                                        data-hs-select='{
                                        "hasSearch": true,
                                         "dropdownVerticalFixedPlacement": "bottom",
                                         "searchPlaceholder": "جستجو...",
                                        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                                        "placeholder": "لطفا انتخاب کنید",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-lg p-2 max-h-80 overflow-auto",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 cursor-pointer hover:bg-gray-200 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-white bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                    }'


                                    {{ $field->required ? 'required' : '' }}>
                                    @php
                                        // Decode the JSON string into an array
                                        $options = json_decode($field->options, true);
                                    @endphp
                                    @if (is_array($options))
                                        @foreach ($options as $option)
                                            <option @if (old($field->id) == $option) selected
                                                    @endif  value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @else
                                        <p class="text-red-500">Invalid options data</p>
                                    @endif
                                </select>
                                @break

                            @case('Multi-select')
                                @php
                                    // Decode the JSON string into an array
                                    $options = json_decode($field->options, true);
                                @endphp

                                <select name="{{ $field->id }}[]" id="{{ $field->id }}" multiple
                                        data-hs-select='{
                                         "hasSearch": true,
                                           "dropdownVerticalFixedPlacement": "bottom",

                                         "searchPlaceholder": "جستجو...",
                                        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                                        "placeholder": "لطفا گزینه هارا انتخاب کنید",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-lg p-2 max-h-60 overflow-auto",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 cursor-pointer hover:bg-gray-200 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-white bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"

                                    }'
                                    {{ $field->required ? 'required' : '' }}>
                                    @if (is_array($options))
                                        @foreach ($options as $option)
                                            <option
                                                @if (is_array(old($field->id)) and in_array($option, old($field->id))) selected
                                                @endif


                                                value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @else
                                        <p class="text-red-500">Invalid options data</p>
                                    @endif
                                </select>
                                @break

                            @case('File Upload')
                                <input type="file" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Image Upload')
                                <input type="file" name="{{ $field->id }}" id="{{ $field->id }}" accept="image/*"
                                       value="{{old($field->id)}}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('URL')
                                <input type="url" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Phone')
                                <input type="tel" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Color Picker')
                                <input type="color" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       class="h-10 w-16 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @break

                            @case('Range')
                                <input type="range" name="{{ $field->id }}" id="{{ $field->id }}"
                                       value="{{old($field->id)}}"
                                       class="block w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break


                            @case('Form')
                                @php
                                    // Decode the JSON string into an array
                                   $options = json_decode($field->options, true);

                                   if ($options){
                                        if (is_array($options) and count($options)>0){
                                       $options=$options[0];
                                       }
                                        }


                                    $form_options = \App\Models\SubmitedForm::where('form_id', (int)$options)->get();



                                @endphp

                                <select
                                    data-hs-select='{
                                         "hasSearch": true,
                                           "dropdownVerticalFixedPlacement": "bottom",
                                         "searchPlaceholder": "جستجو...",
                                        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                                        "placeholder": "لطفا انتخاب کنید",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-lg p-2 max-h-60 overflow-auto",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 cursor-pointer hover:bg-gray-200 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-white bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"

                                    }'

                                    multiple name="{{ $field->id }}[]" id="{{ $field->id }}"
                                    class="p-3 block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>


                                    @foreach ($form_options as $k=>$option)
                                        @php
                                            $option_decode=(array)json_decode($option->data_key);

                                        @endphp

                                        @if(count($option_decode)>0 and array_key_exists('name',$option_decode))
                                            <option
                                                @if (is_array(old($field->id)) and in_array($option_decode['name'], old($field->id))) selected
                                                @endif

                                                value="{{$option_decode['name']}}">{{$option_decode['name'] }}<small> ({{$option_decode['code']}} - {{$company_name}})</small></option>
                                        @endif

                                    @endforeach
                                </select>
                                @break
                            @case('Form Select')
                                @php
                                    // Decode the JSON string into an array
                                   $options = json_decode($field->options, true);

                                   if ($options){
                                        if (is_array($options) and count($options)>0){
                                       $options=$options[0];
                                       }
                                        }

                                    $form_options = \App\Models\SubmitedForm::where('form_id', (int)$options)->get();



                                @endphp

                                <select
                                    data-hs-select='{
                                         "hasSearch": true,
                                           "dropdownVerticalFixedPlacement": "bottom",
                                         "searchPlaceholder": "جستجو...",
                                        "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
                                        "placeholder": "لطفا انتخاب کنید",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-lg p-2 max-h-60 overflow-auto",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 cursor-pointer hover:bg-gray-200 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-white bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"

                                    }'

                                    name="{{ $field->id }}" id="{{ $field->id }}"
                                    class="p-3 block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>


                                    @foreach ($form_options as $k=>$option)
                                        @php
                                            $option_decode=(array)json_decode($option->data_key);
                                            $company_name=$option->form_company->name;
                                        @endphp

                                        @if(count($option_decode)>0 and array_key_exists('name',$option_decode))
                                            <option
                                                @if ($option_decode['name'] == old($field->id)) selected @endif

                                            value="{{$option_decode['name']}}">{{$option_decode['name'] }}<small> ({{$option_decode['code']}} - {{$company_name}})</small></option>
                                        @endif

                                    @endforeach
                                </select>
                                @break

                            @case('Decimal')
                                <input type="number"
                                       value="{{old($field->id)}}"
                                       min="0" max="10000000" step="0.001" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @default
                                <p class="text-red-600">Unsupported field type: {{ $fieldType->name }}</p>
                        @endswitch
                    @else
                        <p class="text-red-600">No field type associated with this field.</p>
                    @endif
                </div>
            @endforeach
        </div>



    </div>
@endsection
