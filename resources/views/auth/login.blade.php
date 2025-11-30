<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mb-4">
                    <a href="{{ route('welcome') }}" class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Back to Home
                    </a>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome Back</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Sign in to your Attendify account</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700 card-float">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white form-input">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white form-input">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold btn-3d">
                        Sign In
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">Don't have an account? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 font-medium">Sign up</a>
                    </p>
                </div>
                
                <!-- Demo Credentials -->
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Demo Accounts:</h4>
                    <div class="text-xs space-y-1">
                        <div class="flex justify-between">
                            <span class="text-red-600 dark:text-red-400">Admin:</span>
                            <span class="text-gray-600 dark:text-gray-400">admin@attendify.com</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-blue-600 dark:text-blue-400">Teacher:</span>
                            <span class="text-gray-600 dark:text-gray-400">john@attendify.com</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-green-600 dark:text-green-400">Student:</span>
                            <span class="text-gray-600 dark:text-gray-400">alice@attendify.com</span>
                        </div>
                        <div class="text-center mt-2 text-gray-500 dark:text-gray-400">Password: password</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
