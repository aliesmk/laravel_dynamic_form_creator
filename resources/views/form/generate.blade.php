@extends('layout.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white shadow-md rounded-lg">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold text-gray-800">{{ $form->name }}</h1>
            <a onclick="window.history.back();"
               class="btn add-option bg-gray-600  mb-4 text-white px-2 py-1 mt-4 rounded hover:bg-gray-400">بازگشت</a>
        </div>
        <p class="text-gray-600 mt-2">{{ $form->description }}</p>

        <form action="#" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf

            @foreach ($fields as $field)
                <div class="mb-6">
                    <label for="{{ $field->id }}"
                           class="block text-sm font-medium text-gray-700 mb-2">{{ $field->label }}</label>
                    @php
                        $fieldType = $field->fieldTypes;
                    @endphp
                    @if ($fieldType)
                        @switch($fieldType->name)
                            @case('Text')
                                <input type="text" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full py-1 border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Textarea')
                                <textarea name="{{ $field->id }}" id="{{ $field->id }}"
                                          placeholder="{{ $field->placeholder }}"
                                          class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      {{ $field->required ? 'required' : '' }}></textarea>
                                @break

                            @case('Number')
                                <input type="number" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Email')
                                <input type="email" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Password')
                                <input type="password" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Date')
                                <input type="date" name="{{ $field->id }}" id="{{ $field->id }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Datetime')
                                <input type="datetime-local" name="{{ $field->id }}" id="{{ $field->id }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Checkbox')
                                <div class="flex space-x-4">
                                    @php
                                        // Decode the JSON string into an array
                                        $options = json_decode($field->options, true);
                                    @endphp

                                    @if (is_array($options))
                                        @foreach ($options as $option)
                                            <label class="inline-flex items-center text-gray-700">
                                                <input type="checkbox" name="{{ $field->id }}" value="{{ $option }}"
                                                       class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <span class="ml-2">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p class="text-red-500">Invalid options data</p>
                                    @endif
                                </div>
                                @break

                            @case('Radio')
                                <div class="flex space-x-4">
                                    @php
                                        // Decode the JSON string into an array
                                        $options = json_decode($field->options, true);
                                    @endphp

                                    @if (is_array($options))
                                        @foreach ($options as $option)
                                            <label class="inline-flex items-center text-gray-700">
                                                <input type="radio" name="{{ $field->id }}" value="{{ $option }}"
                                                       class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                                <span class="ml-2">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    @else
                                        <p class="text-red-500">Invalid options data</p>
                                    @endif
                                </div>
                                @break

                            @case('Select')
                                <div class="flex space-x-4">
                                    @php
                                        // Decode the JSON string into an array
                                        $options = json_decode($field->options, true);
                                    @endphp

                                    @if (is_array($options))
                                        <select name="{{ $field->id }}" id="{{ $field->id }}"
                                                class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            {{ $field->required ? 'required' : '' }}>
                                            @foreach ($options as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p class="text-red-500">Invalid options data</p>
                                    @endif
                                </div>
                                @break

                            @case('Multi-select')
                                @php
                                    // Decode the JSON string into an array
                                    $options = json_decode($field->options, true);
                                @endphp

                                <select name="{{ $field->id }}[]" id="{{ $field->id }}" multiple
                                        class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                    @foreach ($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                </select>
                                @break

                            @case('File Upload')
                                <input type="file" name="{{ $field->id }}" id="{{ $field->id }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Image Upload')
                                <input type="file" name="{{ $field->id }}" id="{{ $field->id }}" accept="image/*"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('URL')
                                <input type="url" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Phone')
                                <input type="tel" name="{{ $field->id }}" id="{{ $field->id }}"
                                       placeholder="{{ $field->placeholder }}"
                                       class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Color Picker')
                                <input type="color" name="{{ $field->id }}" id="{{ $field->id }}"
                                       class="h-10 w-16 border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                @break

                            @case('Range')
                                <input type="range" name="{{ $field->id }}" id="{{ $field->id }}"
                                       class="block w-full focus:ring-indigo-500 focus:border-indigo-500"
                                    {{ $field->required ? 'required' : '' }}>
                                @break

                            @case('Form')
                                <div class="flex space-x-4">
                                        <select name="{{ $field->id }}" id="{{ $field->id }}"
                                                class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            {{ $field->required ? 'required' : '' }}>
                                            @foreach ($forms as $form)
                                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                @break
                            @case('Form Select')
                                <div class="flex space-x-4">
                                        <select name="{{ $field->id }}" id="{{ $field->id }}"
                                                class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                            {{ $field->required ? 'required' : '' }}>
                                            @foreach ($forms as $form)
                                                <option value="{{ $form->id }}">{{ $form->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                @break
                            @case('Decimal')
                                <div class="flex space-x-4">
                                    <input type="text" inputmode="decimal"
                                           name="{{ $field->id }}" id="{{ $field->id }}"
                                           placeholder="{{ $field->placeholder }}"
                                           class="block w-full border-gray-300 bg-gray-100 text-gray-800 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                           {{ $field->required ? 'required' : '' }}
                                           pattern="[0-9]*[.,]?[0-9]*">
                                </div>
                                @break
                            @default
                                <p class="text-red-600">Unsupported field type: {{ $fieldType->name }}</p>
                        @endswitch
                    @else
                        <p class="text-red-600">No field type associated with this field.</p>
                    @endif
                </div>
            @endforeach

            <button type="submit"
                    class="w-full bg-teal-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                ذخیره
            </button>
        </form>
    </div>
@endsection
