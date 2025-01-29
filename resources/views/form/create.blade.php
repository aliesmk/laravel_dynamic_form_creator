@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800">Create New Field Type</h1>

        <form action="{{ route('field_types.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" class="form-control mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="name" name="name" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea class="form-control mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" id="description" name="description"></textarea>
            </div>
            <div class="mb-4">
                <label for="is_optional" class="inline-flex items-center text-gray-700">
                    <input type="checkbox" id="is_optional" name="is_optional" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="ml-2 text-sm font-medium">Is Optional</span>
                </label>
            </div>
            <button type="submit" class="btn bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">Create Field Type</button>
            <a href="{{ route('field_types.index') }}" class="btn bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
        </form>
    </div>
@endsection
