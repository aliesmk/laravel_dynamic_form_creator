@extends('layout.app')

@section('content')
    <div class="m-2 p-4 bg-white dark:bg-gray-800 rounded-md">

        <!-- Navbar -->
        <nav class="bg-teal-600 p-4 shadow-md rounded-lg container mx-auto">
            <h1 class="text-white text-xl font-bold dark:text-rose-500">داشبورد</h1>
        </nav>

        <div class="container mx-auto my-8 ">

            <div style="margin-bottom: 20px" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 mt-8">
                <div class="bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">تعداد کاربران</h2>
                    <p class="text-3xl font-bold text-violet-600 mt-2">5</p>
                </div>
                <div class="bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">تعداد فرم ها</h2>
                    <p class="text-3xl font-bold text-teal-600 mt-2">6</p>
                </div>
                <div class="bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">تعداد ثبت شده ها</h2>
                    <p class="text-3xl font-bold text-violet-600 mt-2">7</p>
                </div>
                <div class="bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">تعداد تایید شده ها</h2>
                    <p class="text-3xl font-bold text-teal-600 mt-2">8</p>
                </div>
            </div>

            <form id="form_submit" action="#" method="GET">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                    <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">فرم های ثبت شده</h2>
                            <div class="relative w-24">
                                <select
                                    onchange="document.getElementById('form_submit').submit();"
                                    name="date_submit"
                                    class="block w-full appearance-none bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-200 py-2 px-3 pr-8 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer"
                                >
                                    <option value="total" @if(request('date_submit')=='total') selected @endif>همه</option>
                                    <option value="today" @if(request('date_submit')=='today') selected @endif>امروز</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-6">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">فرم های تایید شده</h2>
                            <div class="relative w-24">
                                <select
                                    id="date_approve"
                                    name="date_approve"
                                    onchange="document.getElementById('form_submit').submit();"
                                    class="block w-full appearance-none bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-200 py-2 px-3 pr-8 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer"
                                >
                                    <option value="total" @if(request('date_approve')=='total') selected @endif>همه</option>
                                    <option value="today" @if(request('date_approve')=='today') selected @endif>امروز</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
