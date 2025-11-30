<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); document.documentElement.classList.toggle('dark', darkMode)" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendify - Smart Attendance Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900 transition-colors duration-300">
    <!-- Navigation -->
    <nav class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center card-lift">
                        <span class="text-white font-bold text-lg">A</span>
                    </div>
                    <span class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:scale-105 transition-transform duration-300">Attendify</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    <button @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode)" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                        </svg>
                    </button>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 btn-3d">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 nav-item">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 btn-3d">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Parallax -->
    <section class="relative overflow-hidden min-h-screen flex items-center" x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.scrollY">
        <!-- Parallax Background Layers -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800"></div>
        
        <!-- Floating Elements with Parallax -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-32 h-32 bg-blue-200/30 dark:bg-blue-800/30 rounded-full blur-xl" :style="`transform: translateY(${scrollY * 0.3}px) rotate(${scrollY * 0.1}deg)`"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-purple-200/30 dark:bg-purple-800/30 rounded-full blur-xl" :style="`transform: translateY(${scrollY * -0.2}px) rotate(${scrollY * -0.1}deg)`"></div>
            <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-indigo-200/20 dark:bg-indigo-800/20 rounded-full blur-2xl" :style="`transform: translateY(${scrollY * 0.4}px)`"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 z-10">
            <div class="text-center perspective-1000">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 transform-gpu" :style="`transform: translateY(${scrollY * -0.1}px) rotateX(${Math.min(scrollY * 0.02, 15)}deg)`">
                    <span class="bg-gradient-to-r from-blue-600 via-purple-600 to-blue-800 bg-clip-text text-transparent inline-block transform hover:scale-105 transition-transform duration-300">Smart Attendance</span>
                    <br>
                    <span class="text-gray-900 dark:text-white inline-block transform hover:scale-105 transition-transform duration-300">Management System</span>
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto transform-gpu" :style="`transform: translateY(${scrollY * -0.05}px)`">
                    Streamline attendance tracking with role-based access control, real-time reporting, and intuitive design for educational institutions.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center transform-gpu" :style="`transform: translateY(${scrollY * -0.03}px)`">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-2xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 perspective-preserve">
                        Get Started
                    </a>
                    <a href="#features" class="px-8 py-4 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-lg transform hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">Everything you need to manage attendance efficiently</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 perspective-1000">
                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Role-Based Access</h3>
                    <p class="text-gray-600 dark:text-gray-300">Secure access control for Admins, Teachers, and Students with appropriate permissions.</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Smart Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-300">Automated attendance tracking with self-marking options and teacher verification.</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Advanced Reports</h3>
                    <p class="text-gray-600 dark:text-gray-300">Comprehensive reporting with CSV export and detailed analytics.</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 715.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Subject Management</h3>
                    <p class="text-gray-600 dark:text-gray-300">Complete subject and enrollment management with academic term support.</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Session Scheduling</h3>
                    <p class="text-gray-600 dark:text-gray-300">Flexible class session management with real-time attendance tracking.</p>
                </div>

                <div class="bg-white dark:bg-gray-700 p-8 rounded-2xl shadow-sm card-3d">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mb-6 card-lift">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Modern Interface</h3>
                    <p class="text-gray-600 dark:text-gray-300">Clean, responsive design with dark mode support and intuitive navigation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Information Section -->
    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Demo Access</h2>
                <p class="text-xl text-gray-600 dark:text-gray-300">Try the system with different user roles</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 p-8 rounded-2xl border border-red-200 dark:border-red-800 card-3d">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4 card-lift">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-red-900 dark:text-red-100 mb-2">Admin</h3>
                        <p class="text-red-700 dark:text-red-300 mb-4">Full system access and management</p>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg text-left">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Login Credentials:</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">admin@attendify.com</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">password</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-8 rounded-2xl border border-blue-200 dark:border-blue-800 card-3d">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 card-lift">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-2">Teacher</h3>
                        <p class="text-blue-700 dark:text-blue-300 mb-4">Manage classes and attendance</p>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg text-left">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Login Credentials:</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">john@attendify.com</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">password</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-8 rounded-2xl border border-green-200 dark:border-green-800 card-3d">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 card-lift">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-green-900 dark:text-green-100 mb-2">Student</h3>
                        <p class="text-green-700 dark:text-green-300 mb-4">View subjects and mark attendance</p>
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg text-left">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Login Credentials:</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">alice@attendify.com</p>
                            <p class="font-mono text-sm text-gray-900 dark:text-white">password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center card-lift">
                        <span class="text-white font-bold text-lg">A</span>
                    </div>
                    <span class="font-bold text-2xl hover:scale-105 transition-transform duration-300">Attendify</span>
                </div>
                
                <div class="text-center md:text-right">
                    <p class="text-gray-400 mb-2">Smart Attendance Management System</p>
                    <p class="text-sm text-gray-500">
                        Developed with ❤️ by 
                        <a href="https://github.com/Saurabhlode" target="_blank" class="text-blue-400 hover:text-blue-300 font-semibold transition-colors">
                            Saurabh Lode
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-500 text-sm">
                    © {{ date('Y') }} Attendify. Built with Laravel & Tailwind CSS.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>