@extends('layout.app')

@section('content')
    <div class="container mx-auto p-6 dark:bg-gray-800 dark:text-white">
        <div class="flex justify-between bg-white dark:bg-gray-700 p-4 m-16 mb-6 rounded-md shadow-md border border-gray-300 dark:border-gray-600">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ __('messages.edit_form') }} {{$form->name}}</h1>
            <a onclick="window.history.back();"
               class="btn add-option bg-gray-600 text-white px-2 py-1 rounded hover:bg-gray-400 dark:bg-gray-500 dark:hover:bg-gray-400">{{ __('messages.back') }}</a>
        </div>

        <form action="{{ route('form.update',$form->id) }}" method="POST"
              class="mb-6 m-16 mt-6 bg-white dark:bg-gray-700 p-4 rounded-md shadow-md border border-gray-300 dark:border-gray-600" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.name') }}</label>
                <input type="text" value="{{$form->name}}"
                       class="mt-1 block w-full px-4 py-2 border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                       id="name" name="name" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.description') }}</label>
                <textarea
                    class="mt-1 block w-full px-4 py-2 border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    id="description" name="description">{{trim($form->description)}}</textarea>
            </div>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-teal-500 border border-transparent rounded-md shadow-sm text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 dark:bg-teal-600 dark:hover:bg-teal-500">
                {{ __('messages.edit') }}
            </button>
        </form>

        <form method="POST" action="{{ route('form.update', $form->id) }}"
              class="mb-6 m-16 mt-6 bg-white dark:bg-gray-700 p-4 rounded-md shadow-md border border-gray-300 dark:border-gray-600">
            @csrf
            @method('PATCH')

            <div>
                <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ __('messages.fields') }}</h2>
                <div id="fields-container">
                    @foreach ($form_fields as $field)
                        <div class="field-item mb-14 border rounded p-4 bg-gray-200 dark:bg-gray-800">
                            <button
                                    class="remove-field bg-rose-200 p-2 text-rose-600 mb-2 rounded hover:bg-rose-400 dark:bg-rose-600 dark:text-white">
                                x
                            </button>
                            <div class="flex flex-col mb-3 mt-10">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.field_name') }}</label>
                                <input type="text" required name="fields[{{ $loop->index }}][label]"
                                       value="{{ $field->label }}"
                                       class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2">

                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.field_key') }}</label>
                                <input type="text" required name="fields[{{ $loop->index }}][key]"
                                       value="{{ $field->key }}"
                                       class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2">

                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.tooltip') }}</label>
                                <input type="text" name="fields[{{ $loop->index }}][tooltip]"
                                       value="{{ $field->tooltip }}"
                                       class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.sequence') }}</label>

                                <input type="number" name="fields[{{ $loop->index }}][sequence]"
                                       value="{{ $field->sequence ?? 1 }}"
                                       class="block rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2">
                            </div>

                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">{{ __('messages.field_type') }}</label>

                            <select data-target="option_select{{ $loop->index }}" name="fields[{{ $loop->index }}][type]" data-loop-index="{{ $loop->index }}"
                                    class="type-field-select block w-full rounded-md border-gray-500 bg-teal-500 text-gray-100 shadow-sm
                                    focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200"
                                    onfocus="this.classList.remove('bg-teal-500');
                            this.classList.add('bg-gray-100');this.classList.remove('text-gray-100');
                            this.classList.add('text-gray-900')"
                                    onblur="this.classList.remove('bg-gray-100');
                            this.classList.add('bg-teal-500');this.classList.remove('text-gray-900');
                            this.classList.add('text-gray-100')">
                                @foreach ($fieldTypes as $fieldType)
                                    <option
                                        value="{{ $fieldType->name }}" {{ $field->fieldTypes->name === $fieldType->name ? 'selected' : '' }}>
                                        {{ $fieldType->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($field->options)
                                @if($field->fieldTypes->name == 'Form' or $field->fieldTypes->name == 'Form Select')

                                    @php $form_id = json_decode($field->options);
                                    if ($form_id){
                                        if (is_array($form_id) and count($form_id)>0){
                                            $form_id=$form_id[0];
                                        }
                                    }
                                    @endphp
                                    <div class="options-container">
                                        <select id="option_select{{ $loop->index }}" name="fields[{{ $loop->index }}][options]"
                                                data-loop-index="{{ $loop->index }}"
                                                class=" block w-full rounded-md border-gray-500 bg-teal-500 text-gray-900 shadow-sm
                                                    focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2 dark:bg-gray-600 dark:border-gray-500 dark:text-gray-200"
                                                onfocus="this.classList.remove('bg-teal-500');
                                                    this.classList.add('bg-gray-100');this.classList.remove('text-gray-100');
                                                    this.classList.add('text-gray-900')"
                                                onblur="this.classList.remove('bg-gray-100');
                                                    this.classList.add('bg-teal-500');this.classList.remove('text-gray-900');
                                                    this.classList.add('text-gray-100')">
                                            @foreach ($forms as $form)
                                                <option
                                                    value="{{ $form->id }}" {{ $form->id === (int)$form_id ? 'selected' : '' }}>
                                                    {{ $form->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="options-container">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.options') }} (برای {{ $field->fieldTypes->name }})</label>
                                        <div class="options-list space-y-2">
                                            @foreach (json_decode($field->options, true) ?? [] as $option)
                                                <div class="option-item flex items-center space-x-2">
                                                    <input type="text"
                                                           name="fields[{{ $loop->parent->index }}][options][]"
                                                           value="{{ $option }}"
                                                           class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm p-2">
                                                    <button
                                                            class="remove-option p-2 bg-rose-200 text-rose-600 px-3 py-1 rounded hover:bg-rose-400 dark:bg-rose-600 dark:text-white">
                                                        X
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button"
                                                class="add-option bg-teal-500 text-white px-2 py-1 mt-4 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-500">
                                            {{ __('messages.add_option') }}
                                        </button>
                                    </div>

                                @endif
                            @else
                                <div class="options-container">

                                </div>

                            @endif

                            <div class="flex items-center mb-4">
                                <input id="required-checkbox-{{ $loop->index }}" type="checkbox"
                                       name="fields[{{ $loop->index }}][required]"
                                       @checked(old('required', $field->required ))
                                       class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:bg-gray-600 dark:border-gray-500">
                                <label for="required-checkbox-{{ $loop->index }}"
                                       class="ml-2 mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.required') }}</label>
                            </div>

                            @php $isOptional = collect($fieldTypes)->firstWhere('name', $field->type)['is_optional'] ?? false; @endphp
                            @if ($isOptional)
                                <div class="options-container">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.options') }} (for {{ $field->type }})</label>
                                    <div class="options-list space-y-2">
                                        @foreach (json_decode($field->options, true) ?? [] as $option)
                                            <div class="option-item flex items-center space-x-2">
                                                <input type="text"
                                                       name="[{{ $loop->parent->index }}][options][]"
                                                       value="{{ $option }}"
                                                       class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm p-2">
                                                <button type="button"
                                                        class="remove-option p2 bg-rose-200 text-rose-600 px-3 py-1 rounded hover:bg-rose-400 dark:bg-rose-600 dark:text-white">
                                                    X
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button"
                                            class="add-option bg-teal-500 text-white px-2 py-1 mt-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-500">
                                        {{ __('messages.add_option') }}
                                    </button>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
                <div class="flex mt-2">
                    <button type="button" id="add-field"
                            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-gray-500 dark:hover:bg-gray-400 m-2">{{ __('messages.add_field') }}
                    </button>

                    <button type="submit" class="bg-teal-500 text-white px-4 py-2 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-500 m-2">{{ __('messages.save') }}
                    </button>
                </div>

            </div>
        </form>

    </div>

    <script>
        // Add dynamic options for optional fields
        document.addEventListener('DOMContentLoaded', function() {
            const fieldsContainer = document.getElementById('fields-container');

            // Add Field Button
            document.getElementById('add-field').addEventListener('click', function() {
                const fieldIndex = fieldsContainer.children.length;
                const newField = `
                <div class="field-item mb-9 border rounded p-4 bg-gray-200 dark:bg-gray-800">
   <button class="remove-field p-2 bg-rose-200 text-rose-600 mb-2 rounded hover:bg-rose-400 dark:bg-rose-600 dark:text-white">
                                x
                            </button>
                    <div class="flex flex-col mb-3 mt-10">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.field_name') }}</label>
                        <input type="text" name="fields[${fieldIndex}][label]"
                            class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2" placeholder="{{ __('messages.field_name') }}" required>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.field_key') }}</label>
                        <input type="text" name="fields[${fieldIndex}][key]"
                            class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2" placeholder="{{ __('messages.field_key') }}" required>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.tooltip') }}</label>
                        <input type="text" name="fields[${fieldIndex}][tooltip]"
                            class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2" placeholder="{{ __('messages.tooltip') }}">
                         <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.sequence') }}</label>
                        <input type="number" name="fields[${fieldIndex}][sequence]"
                            class="block rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2" placeholder="{{ __('messages.sequence') }}" required>
                    </div>

                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.field_type') }}</label>
                    <select data-target="option_select${fieldIndex}" name="fields[${fieldIndex}][type]" data-loop-index=${fieldIndex} class="type-field-select block w-full rounded-md border-gray-300 dark:border-gray-500 bg-teal-500 text-gray-100 shadow-sm
                            focus:border-teal-500 focus:ring-teal-500 sm:text-sm mb-3 p-2 dark:bg-gray-600 dark:text-gray-200"
                            onfocus="this.classList.remove('bg-teal-500'); this.classList.add('bg-gray-100');this.classList.remove('text-gray-100'); this.classList.add('text-gray-900')"
                            onblur="this.classList.remove('bg-gray-100'); this.classList.add('bg-teal-500');this.classList.remove('text-gray-900'); this.classList.add('text-gray-100')">
                        @foreach ($fieldTypes as $fieldType)
                <option value="{{ $fieldType->name }}">{{ $fieldType->name }}</option>
                        @endforeach
                </select>
                <div class="flex items-center mb-4">
                    <input id="required-checkbox" type="checkbox" value="" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:bg-gray-600 dark:border-gray-500">
                    <label for="required-checkbox" class="ml-2 mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.required') }}?</label>
          </div>
          <!-- Options -->
          <div class="options-container hidden">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.options') }}</label>
              <div class="options-list space-y-2"></div>
              <button type="button" class="add-option bg-teal-500 text-white px-2 py-1 mt-4 mb-4 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-500">{{ __('messages.add_option') }}</button>
          </div>

      </div>`;
                fieldsContainer.insertAdjacentHTML('beforeend', newField);
            });

            // Remove Field Button
            fieldsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-field')) {
                    e.target.closest('.field-item').remove();
                }
            });

            // Add Option Button
            fieldsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-option')) {
                    const fieldItem = e.target.closest('.field-item');
                    const fieldIndex = Array.from(fieldsContainer.children).indexOf(fieldItem);
                    const optionsList = fieldItem.querySelector('.options-list');
                    const newOption = `
                    <div class="option-item flex items-center space-x-2">
                        <input type="text" name="fields[${fieldIndex}][options][]" value=""
                            class="block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-600 dark:border-gray-500 text-gray-800 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm p-2" required>
                        <button type="button" class="remove-option bg-rose-200 text-rose-600 px-3 py-1 rounded hover:bg-rose-400 dark:bg-rose-600 dark:text-white">X</button>
                    </div>`;
                    optionsList.insertAdjacentHTML('beforeend', newOption);
                }
            });

            // Remove Option Button
            fieldsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-option')) {
                    e.target.closest('.option-item').remove();
                }
            });

            // Show/Hide Options Container based on Field Type
            fieldsContainer.addEventListener('change', function(e) {
                const selectElement = document.getElementById(e.target.dataset.target);
                if (selectElement) {
                    selectElement.remove();
                    console.log('Select element removed.');
                } else {
                    console.log('No select element found');
                }

                if (e.target.tagName === 'SELECT') {
                    const field_type = ['Checkbox', 'Radio', 'Select', 'Multi-select', 'Color Picker', 'Range'];

                    if (e.target.value == 'Form' || e.target.value == 'Form Select') {
                        const optionsContainer = e.target.closest('.field-item').querySelector('.options-container');

                        if (optionsContainer){
                            optionsContainer.classList.add('hidden');
                        }

                        const forms = @json($forms);

                        const newSelect = document.createElement('select');

                        newSelect.setAttribute('id', e.target.dataset.target);

                        console.log(e.target.dataset.target)

                        // Apply Tailwind classes for styling
                        newSelect.classList.add(
                            'block',
                            'w-full',
                            'rounded-md',
                            'border-gray-300',
                            'bg-teal-500',
                            'border-gray-900',
                            'focus:border-teal-500',
                            'focus:ring-teal-500',
                            'sm:text-sm',
                            'mb-3',
                            'p-2',
                            'dark:bg-gray-600',
                            'dark:border-gray-500',
                            'dark:text-gray-200'
                        );

                        forms.forEach(form => {
                            const option = document.createElement('option');
                            option.value = form.id;
                            option.textContent = form.name;

                            option.classList.add('px-4', 'py-2', 'text-gray-700');

                            newSelect.appendChild(option);
                        });

                        newSelect.name = 'fields[' + e.target.dataset.loopIndex + '][options][]';

                        const container = e.target.parentElement;
                        container.appendChild(newSelect);
                    } else {
                        console.log(e.target.classList.contains('type-field-select'))
                        if( e.target.classList.contains('type-field-select')) {
                            console.log(e.target.value)
                            const isOptional = @json($fieldTypes).
                            find(ft => ft.name === e.target.value)?.is_optional || false;
                            const optionsContainer = e.target.closest('.field-item').querySelector('.options-container');
                            if (optionsContainer && optionsContainer.children.length > 0) {
                                optionsContainer.classList.toggle('hidden', !isOptional);
                            } else {
                                console.log(e.target.value)
                                if (field_type.includes(e.target.value)) {
                                    console.log(5555)
                                    optionsContainer.innerHTML =`<div class="options-container">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.options') }}</label>
              <div class="options-list space-y-2"></div>
              <button type="button" class="add-option bg-teal-500 text-white px-2 py-1 mt-4 mb-4 rounded hover:bg-teal-600 dark:bg-teal-600 dark:hover:bg-teal-500">{{ __('messages.add_option') }}</button>
          </div>`
                                }
                            }
                        }
                    }
                }
            });

            function reindexFields() {
                Array.from(fieldsContainer.children).forEach((fieldItem, fieldIndex) => {
                    fieldItem.querySelectorAll('input[name], select[name]').forEach(input => {
                        input.name = input.name.replace(/\[fields\]\[\d+\]/, `[fields][${fieldIndex}]`);
                    });
                });
            }

            fieldsContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-field')) {
                    e.target.closest('.field-item').remove();
                    reindexFields();
                }
            });
        });
    </script>
@endsection
