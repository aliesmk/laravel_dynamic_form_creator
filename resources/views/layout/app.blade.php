<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'Dynamic Form')</title>
</head>
<body class="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }} bg-gray-100 dark:bg-gray-900 antialiased">
<div class="flex">
    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 rounded-md mt-7" id="sidebar">
        <div class="p-4">
            <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">Dashboard</h1>
        </div>
        <nav class="mt-6">
            <ul class="space-y-2">
                <li>
                    <a href="/" class="flex items-center p-2 text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">
                        <span class="material-icons">{{ __('messages.Dashboard') }}</span>
                    </a>
                </li>
                <li class="mt-4">
                    <a class="flex items-center p-2 text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 rounded {{ request()->routeIs('form.*') ? 'dark:nav-active-dark nav-active' : '' }}" href="{{ route('form.index') }}">
                        <span class="material-icons">{{ __('messages.Forms') }}</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">
                        <span class="material-icons">settings</span>
                        <span class="ml-3">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">
                        <span class="material-icons">bar_chart</span>
                        <span class="ml-3">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">
                        <span class="material-icons">logout</span>
                        <span class="ml-3">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-6 h-screen overflow-x-hidden overflow-y-scroll">
        <header
            class="flex justify-between bg-white dark:bg-gray-800 px-3  border-r  border-gray-200 dark:border-gray-700 rounded-md ">
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    @if (session('message'))
                    Swal.fire({
                        icon: '{{ session('icon', 'info') }}',
                        title: '{{ session('title', 'پیام') }}',
                        text: '{{ session('message') }}',
                        confirmButtonText: 'باشه'
                    });
                    @endif
                });
            </script>
            <div class="relative inline-block text-left">
                <div>
                    <button id="language-dropdown"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            aria-haspopup="true" aria-expanded="true">
                        {{ __('messages.language') }}
                    </button>
                </div>
                <button id="toggleSidebar" class="md:hidden p-2 text-gray-900 dark:text-gray-100">
                    <span class="material-icons">menu</span>
                </button>

                <div id="dropdown-menu"
                     class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none z-10"
                     role="menu" aria-orientation="vertical" aria-labelledby="language-dropdown">
                    <div class="py-1" role="none">
                        <a href="{{ url()->current() }}?lang=en"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                           role="menuitem">
                            <svg width="24" height="24px" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                 class="iconify iconify--twemoji"
                                 preserveAspectRatio="xMidYMid meet">
                                <path fill="#00247D"
                                      d="M0 9.059V13h5.628zM4.664 31H13v-5.837zM23 25.164V31h8.335zM0 23v3.941L5.63 23zM31.337 5H23v5.837zM36 26.942V23h-5.631zM36 13V9.059L30.371 13zM13 5H4.664L13 10.837z"></path>
                                <path fill="#CF1B2B"
                                      d="M25.14 23l9.712 6.801a3.977 3.977 0 0 0 .99-1.749L28.627 23H25.14zM13 23h-2.141l-9.711 6.8c.521.53 1.189.909 1.938 1.085L13 23.943V23zm10-10h2.141l9.711-6.8a3.988 3.988 0 0 0-1.937-1.085L23 12.057V13zm-12.141 0L1.148 6.2a3.994 3.994 0 0 0-.991 1.749L7.372 13h3.487z"></path>
                                <path fill="#EEE"
                                      d="M36 21H21v10h2v-5.836L31.335 31H32a3.99 3.99 0 0 0 2.852-1.199L25.14 23h3.487l7.215 5.052c.093-.337.158-.686.158-1.052v-.058L30.369 23H36v-2zM0 21v2h5.63L0 26.941V27c0 1.091.439 2.078 1.148 2.8l9.711-6.8H13v.943l-9.914 6.941c.294.07.598.116.914.116h.664L13 25.163V31h2V21H0zM36 9a3.983 3.983 0 0 0-1.148-2.8L25.141 13H23v-.943l9.915-6.942A4.001 4.001 0 0 0 32 5h-.663L23 10.837V5h-2v10h15v-2h-5.629L36 9.059V9zM13 5v5.837L4.664 5H4a3.985 3.985 0 0 0-2.852 1.2l9.711 6.8H7.372L.157 7.949A3.968 3.968 0 0 0 0 9v.059L5.628 13H0v2h15V5h-2z"></path>
                                <path fill="#CF1B2B" d="M21 15V5h-6v10H0v6h15v10h6V21h15v-6z"></path>
                            </svg>
                        </a>
                        <a href="{{ url()->current() }}?lang=fa"
                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600"
                           role="menuitem">
                            <svg width="24px" height="24px" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                                 class="iconify iconify--twemoji" preserveAspectRatio="xMidYMid meet">

                                <path fill="#DA0001" d="M0 27a4 4 0 0 0 4 4h28a4 4 0 0 0 4-4v-4H0v4z">

                                </path>

                                <path fill="#EEE" d="M0 13h36v10H0z">

                                </path>

                                <path fill="#239F40" d="M36 13V9a4 4 0 0 0-4-4H4a4 4 0 0 0-4 4v4h36z">

                                </path>

                                <path fill="#E96667" d="M0 23h36v1H0z">

                                </path>

                                <g fill="#BE1931">

                                    <path
                                        d="M19.465 14.969c.957.49 3.038 2.953.798 5.731c1.391-.308 3.162-4.408-.798-5.731zm-2.937 0c-3.959 1.323-2.189 5.423-.798 5.731c-2.24-2.778-.159-5.241.798-5.731zm1.453-.143c.04.197 1.101.436.974-.573c-.168.408-.654.396-.968.207c-.432.241-.835.182-.988-.227c-.148.754.587.975.982.593z">

                                    </path>

                                    <path
                                        d="M20.538 17.904c-.015-1.248-.677-2.352-1.329-2.799c.43.527 1.752 3.436-.785 5.351l.047-5.097l-.475-.418l-.475.398l.08 5.146l-.018-.015c-2.563-1.914-1.233-4.837-.802-5.365c-.652.447-1.315 1.551-1.329 2.799c-.013 1.071.477 2.243 1.834 3.205a6.375 6.375 0 0 1-1.678.201c.464.253 1.34.192 2.007.131l.001.068l.398.437l.4-.455v-.052c.672.062 1.567.129 2.039-.128a6.302 6.302 0 0 1-1.732-.213c1.344-.961 1.83-2.127 1.817-3.194z">

                                    </path>

                                </g>

                                <path fill="#7BC58C" d="M0 12h36v1H0z">

                                </path>

                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <button id="dark-mode-toggle"
                    class="flex items-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200  rounded">
                <svg id="theme-icon" xmlns="http://www.w3.org/2000/svg" width="25" height="20" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <!-- آیکون خورشید -->
                    <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff"
                         viewBox="0 0 256 256">
                        <path
                            d="M120,40V16a8,8,0,0,1,16,0V40a8,8,0,0,1-16,0Zm72,88a64,64,0,1,1-64-64A64.07,64.07,0,0,1,192,128Zm-16,0a48,48,0,1,0-48,48A48.05,48.05,0,0,0,176,128ZM58.34,69.66A8,8,0,0,0,69.66,58.34l-16-16A8,8,0,0,0,42.34,53.66Zm0,116.68-16,16a8,8,0,0,0,11.32,11.32l16-16a8,8,0,0,0-11.32-11.32ZM192,72a8,8,0,0,0,5.66-2.34l16-16a8,8,0,0,0-11.32-11.32l-16,16A8,8,0,0,0,192,72Zm5.66,114.34a8,8,0,0,0-11.32,11.32l16,16a8,8,0,0,0,11.32-11.32ZM48,128a8,8,0,0,0-8-8H16a8,8,0,0,0,0,16H40A8,8,0,0,0,48,128Zm80,80a8,8,0,0,0-8,8v24a8,8,0,0,0,16,0V216A8,8,0,0,0,128,208Zm112-88H216a8,8,0,0,0,0,16h24a8,8,0,0,0,0-16Z"></path>
                    </svg>
                    <!-- آیکون ماه -->
                    <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000"
                         viewBox="0 0 256 256">
                        <path
                            d="M155.64,199.28a80,80,0,0,1,0-142.56,8,8,0,0,0,0-14.25A94.93,94.93,0,0,0,112,32a96,96,0,0,0,0,192,94.93,94.93,0,0,0,43.64-10.47,8,8,0,0,0,0-14.25ZM112,208A80,80,0,1,1,134.4,51.16a96.08,96.08,0,0,0,0,153.68A79.82,79.82,0,0,1,112,208Zm139.17-87.35-26.5-11.43-2.31-29.84a8,8,0,0,0-14.14-4.47L189.63,97.42l-27.71-6.85a8,8,0,0,0-8.81,11.82L168.18,128l-15.07,25.61a8,8,0,0,0,8.81,11.82l27.71-6.85,18.59,22.51a8,8,0,0,0,14.14-4.47l2.31-29.84,26.5-11.43a8,8,0,0,0,0-14.7ZM213.89,134a8,8,0,0,0-4.8,6.73l-1.15,14.89-9.18-11.11a8,8,0,0,0-6.17-2.91,8.4,8.4,0,0,0-1.92.23l-14.12,3.5,7.81-13.27a8,8,0,0,0,0-8.12l-7.81-13.27,14.12,3.5a8,8,0,0,0,8.09-2.68l9.18-11.11,1.15,14.89a8,8,0,0,0,4.8,6.73l13.92,6Z"></path>
                    </svg>
                </svg>
            </button>
        </header>

        <div class="mt-4">
            @if($errors->any())
                <div class="bg-red-500 text-white p-3 rounded-md shadow-md">


                    {{ implode('', $errors->all(':message')) }}

                </div>
            @endif
            @yield('content')
        </div>
    </main>
</div>

<footer class="bg-gray-200 dark:bg-gray-800 footer mt-auto py-3 px-3 md:mr-64">
    <div class="container rtl:space-x-reverse text-sm text-gray-500 dark:text-gray-400">
        <span class="text-sm text-gray-500 dark:text-gray-400">تمامی حقوق برای گروه <span class="text-teal-500"></span> محفوظ است. نسخه {{config('dynamic_form.app_version')}}</span>
    </div>
</footer>

<script>
    const toggleButton = document.getElementById('dark-mode-toggle');
    const htmlElement = document.documentElement; // تگ html
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    const themeText = document.getElementById('theme-text');

    // بررسی حالت ذخیره شده در localStorage
    if (localStorage.getItem('theme') === 'dark') {
        htmlElement.setAttribute('data-theme', 'dark');
        sunIcon.classList.remove('hidden'); // نمایش آیکون خورشید
        moonIcon.classList.add('hidden'); // مخفی کردن آیکون ماه

    } else {
        htmlElement.setAttribute('data-theme', 'light');
        sunIcon.classList.add('hidden'); // مخفی کردن آیکون خورشید
        moonIcon.classList.remove('hidden'); // نمایش آیکون ماه
    }

    toggleButton.addEventListener('click', () => {
        // تغییر حالت
        if (htmlElement.getAttribute('data-theme') === 'dark') {
            htmlElement.setAttribute('data-theme', 'light');
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
            localStorage.setItem('theme', 'light');
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            localStorage.setItem('theme', 'dark');
        }
    });

    const languageDropdownButton = document.getElementById('language-dropdown');
    const dropdownMenu = document.getElementById('dropdown-menu');

    languageDropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', (event) => {
        if (!languageDropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    });
</script>
</body>
</html>
