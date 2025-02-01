@extends('layout.app')

@section('content')
    <div class="container mx-auto p-4">

        <hr class="my-6 border-gray-300 dark:border-gray-600">

        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-200">{{ __('messages.forms') }}</h2>
        <a href="{{route('form.create')}}">
            <button
                class="inline-flex mx-2 items-center px-2 py-1 text-sm text-white bg-teal-500 rounded hover:bg-teal-700">
                {{ __('messages.create_form') }}
                <i class="ph ph-check-circle text-lime-500"></i>
            </button>
        </a>
        <form action="{{ route('form.index') }}" method="GET" class="mt-6">
            <div class="bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 p-3 mb-2 rounded shadow">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2 mb-4">
                    <div>
                        <input placeholder="{{ __('messages.search') }}" type="text" value="{{request('search')}}"
                               class="text-gray-700 dark:text-gray-300 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                               id="search" name="search">
                    </div>
                    <div>
                        <select id="final" name="final"
                                class="block w-full py-3 px-4 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option></option>
                            <option @if(request('final')=='false') selected
                                    @endif value="false">{{ __('messages.draft') }}</option>
                            <option @if(request('final')=='true') selected
                                    @endif value="true">{{ __('messages.published') }}</option>
                        </select>
                    </div>
                    <div>
                        <select id="archive" name="archive"
                                class="block w-full py-3 px-4 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option></option>
                            <option @if(request('archive')=='false') selected
                                    @endif value="false">{{ __('messages.not_archived') }}</option>
                            <option @if(request('archive')=='true') selected
                                    @endif value="true">{{ __('messages.archived') }}</option>
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
            <div class="text-center bg-gray-100 dark:bg-gray-700 font-bold mt-10 text-gray-600 dark:text-gray-300"
                 style="font-size: 26px">
                {{ __('messages.no_data_to_display') }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table
                    class="min-w-full bg-white dark:bg-gray-800 mt-8 rounded-md border-4 border-transparent shadow-sm">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.row') }}</th>
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.name') }}</th>
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.description') }}</th>
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.status') }}</th>
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.archived') }}</th>
                        <th class="py-2 px-4 text-start text-sm text-gray-700 dark:text-gray-300">{{ __('messages.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $key => $form)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                            <td class="py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">
                                {{ ($forms->currentPage() - 1) * $forms->perPage() + $key + 1 }}
                            </td>
                            <td class="overme py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->name }}</td>
                            <td class="overme py-2 px-4 border-b text-sm cursor-pointer text-gray-600 dark:text-gray-300">
                                <abbr title="{{ $form->description }}">
                                    {{ $form->description }}
                                </abbr>
                            </td>
                            <td class="py-2 px-4 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->final ? __('messages.published') : __('messages.draft') }}</td>
                            <td class="py-2 px-4 mb-1 border-b text-sm text-gray-600 dark:text-gray-300">{{ $form->archive ? __('messages.yes') : __('messages.no') }}</td>
                            <td class="py-2 px-4 mb-1 border-b text-sm text-gray-600 dark:text-gray-300">
                                <form class="inline-flex" action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if(!$form->final)
                                        <button type="submit" name="final" value="true"
                                                class="inline-flex mx-2 items-center px-2 py-1 text-sm text-white bg-lime-500 rounded hover:bg-lime-700">
                                            {{ __('messages.finalize') }}
                                            <i class="ph ph-check-circle text-lime-500"></i>
                                        </button>
                                    @else
                                        <div class="inline-flex border mx-2 rounded p-1 border-lime-600 justify-center">
                                            <p class="text-lime-600">{{ __('messages.submitted') }}</p>
                                            <i class="ph ph-check p-1 text-lime-600"></i>
                                        </div>
                                    @endif
                                </form>
                                <a href="{{route('form.edit', $form->id)}}"
                                   class="inline-flex mx-1 mb-1 items-center px-2 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">{{ __('messages.edit') }}</a>
                                <a href="#"
                                   class="inline-flex mx-1 mb-1 items-center px-2 py-1 text-sm text-white bg-teal-500 rounded hover:bg-teal-600">{{ __('messages.view') }}</a>
                                <form class="inline-flex" action="#" method="POST">
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
            </div>
            <div class="mt-2">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
@endsection
