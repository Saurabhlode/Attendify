<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <x-logo size="lg" />
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Reset Password</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Enter your email to receive a reset link</p>
            </div>
            
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
                <x-auth-session-status class="mb-4" :status="session('status')" />
                
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus 
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition-all duration-200">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        Send Reset Link
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="text-gray-600 dark:text-gray-400">Remember your password? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 font-medium">Sign in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
