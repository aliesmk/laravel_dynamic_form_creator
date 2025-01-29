@extends('layout.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">{{ __('messages.form_management') }}</h1>

        <!-- Create Field Type Form -->
        <form action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data"
              class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-md shadow-md border border-gray-300 dark:border-gray-600">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm text-gray-700 dark:text-gray-300">{{ __('messages.name') }}</label>
                <input type="text"
                       class="mt-1 block w-full px-4 py-2 border-gray-300 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                       id="name" name="name" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm text-gray-700 dark:text-gray-300">{{ __('messages.description') }}</label>
                <textarea
                    class="mt-1 block w-full px-4 py-2 border-gray-300 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                    id="description" name="description"></textarea>
            </div>

            <button type="submit"
                    class="inline-flex items-center px-2 py-1 bg-teal-500 border border-transparent rounded-md shadow-sm text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                {{ __('messages.create_form') }}
            </button>
        </form>

        <hr class="my-6 border-gray-300 dark:border-gray-600">

        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-200">{{ __('messages.forms') }}</h2>

        <form action="{{ route('form.index') }}" method="GET" class="mt-6">
            <div class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 p-3 mb-2 rounded shadow w-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2 mb-4">
                    <div>
                        <input placeholder="{{ __('messages.search') }}" type="text" value="{{request('search')}}"
                               class="text-gray-700 dark:text-gray-300 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               id="search" name="search">
                    </div>
                    <div>
                        <select id="final" name="final"
                                data-hs-select='{
                                        "placeholder": "{{ __('messages.select_status') }}",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-md shadow-lg p-2",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 dark:text-gray-300 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-gray-200 bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                    }'>
                            <option></option>
                            <option @if(request('final')=='false') selected @endif value="false">{{ __('messages.draft') }}</option>
                            <option @if(request('final')=='true') selected @endif value="true">{{ __('messages.published') }}</option>
                        </select>
                    </div>
                    <div>
                        <select id="archive" name="archive"
                                data-hs-select='{
                                        "placeholder": "{{ __('messages.select_archive_status') }}",
                                        "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
                                        "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
                                        "dropdownClasses": "z-50 w-full mt-2 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-md shadow-lg p-2",
                                        "optionClasses": "py-2 px-4 flex justify-between items-center text-sm text-gray-800 dark:text-gray-300 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 focus:bg-teal-100",
                                        "optionTemplate": "<div class=\"flex justify-between items-center w-full\"><span data-title></span><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 w-5 h-5 text-gray-200 bg-teal-500 rounded-full\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"20 6 9 17 4 12\"/></svg></span></div>"
                                    }'>
                            <option></option>
                            <option @if(request('archive')=='false') selected @endif value="false">{{ __('messages.not_archived') }}</option>
                            <option @if(request('archive')=='true') selected @endif value="true">{{ __('messages.archived') }}</option>
                        </select>
                    </div>
                </div>
                <button type="submit"
                        class="text-sm p-2 bg-teal-500 text-white rounded-md shadow-md hover:bg-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    {{ __('messages.search') }}
                </button>
            </div>
        </form>

        @if(count($forms) == 0)
            <div class="text-center bg-gray-100 dark:bg-gray-700 font-bold mt-10 text-gray-600 dark:text-gray-300" style="font-size: 26px">
                {{ __('messages.no_data_to_display') }}
            </div>
        @else
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.row') }}</th>
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.form_version') }}</th>
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.name') }}</th>
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.description') }}</th>
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.status') }}</th>
                    <th class="py-2 px-4 border-b text-right text-sm text-gray-700 dark:text-gray-300">{{ __('messages.archive') }}</th>
                    <th class="py-2 px-4 border-b text-center text-sm text-gray-700 dark:text-gray-300">{{ __('messages.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($forms as $key => $form)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                        <td class="py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">
                            {{ ($forms->currentPage() - 1) * $forms->perPage() + $key + 1 }}
                        </td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">{{ __('messages.version', ['code' => $form->code]) }}</td>
                        <td class="overme py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->name }}</td>
                        <td class="overme py-2 px-4 border-b text-sm cursor-pointer text-gray-600 dark:text-gray-300">
                            <abbr title="{{ $form->description }}">
                                {{ $form->description }}
                            </abbr>
                        </td>
                        <td class="py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->final ? __('messages.published') : __('messages.draft') }}</td>
                        <td class="py-2 px-4 mb-1 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->archive ? __('messages.yes') : __('messages.no') }}</td>
                        <td class="py-2 px-4 mb-1 border-b text-sm text-gray-600 dark:text-gray-300">
                            <form class="inline-flex" action="{{ route('form.final', $form->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(!$form->final)
                                    <button type="submit" name="final" value="true"
                                            class="inline-flex mx-2 items-center px-2 py-1 text-sm text-white bg-lime-500 rounded hover:bg-lime-700">
                                        {{ __('messages.finalize') }}
                                        <i class="ph ph-check-circle text-lime-500"></i>
                                    </button>
                                @else
                                    <div class="inline-flex border mx-2 rounded p-1 border-lime-600 justify-center justify-content-center">
                                        <p class="text-lime-600">{{ __('messages.submitted') }}</p>
                                        <i class="ph ph-check p-1 text-lime-600"></i>
                                    </div>
                                @endif
                            </form>
                            <a href="{{ route('form.edit', $form->id) }}"
                               class="inline-flex mx-1 mb-1 items-center px-2 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">{{ __('messages.edit') }}</a>
                            <a href="{{ route('form.generate', $form->id) }}"
                               class="inline-flex mx-1 mb-1 items-center px-2 py-1 text-sm text-white bg-teal-500 rounded hover:bg-teal-600">{{ __('messages.view') }}</a>
                            <a href="{{ route('submission.users', $form->id) }}"
                               class="inline-flex mx-1 items-center px-2 py-1 text-sm text-white bg-emerald-400 rounded hover:bg-emerald-500">{{ __('messages.users') }}</a>
                            <form class="inline-flex" action="{{ route('form.replicate', $form->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex mx-1 items-center px-2 py-1 text-sm text-white rounded hover:bg-gray-200">
                                    <i class="ph ph-copy text-lg text-gray-400"></i>
                                </button>
                            </form>
                            <form class="inline-flex" action="{{ route('form.destroy', $form->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="items-center mx-1 text-md text-white rounded hover:bg-rose-200">
                                    <i class="ph ph-trash text-lg px-2 text-rose-500"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
@endsection
