@props(['size' => 'md', 'showText' => true])

@php
$sizeClasses = [
    'sm' => 'w-8 h-8',
    'md' => 'w-12 h-12', 
    'lg' => 'w-16 h-16',
    'xl' => 'w-20 h-20'
];

$textSizes = [
    'sm' => 'text-sm',
    'md' => 'text-lg',
    'lg' => 'text-2xl', 
    'xl' => 'text-3xl'
];

$logoSize = $sizeClasses[$size] ?? $sizeClasses['md'];
$textSize = $textSizes[$size] ?? $textSizes['md'];
@endphp

<div class="flex items-center space-x-3">
    <div class="{{ $logoSize }} bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
        
        <!-- Main logo -->
        <div class="relative z-10 flex items-center justify-center">
            <span class="text-white font-bold {{ $size === 'sm' ? 'text-lg' : ($size === 'md' ? 'text-2xl' : ($size === 'lg' ? 'text-3xl' : 'text-4xl')) }}">A</span>
        </div>
        
        <!-- Shine effect -->
        <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/30 via-transparent to-transparent opacity-60"></div>
    </div>
    
    @if($showText)
        <div class="flex flex-col">
            <span class="font-bold {{ $textSize }} text-gray-900 dark:text-white tracking-tight">Attendify</span>
            @if($size === 'lg' || $size === 'xl')
                <span class="text-xs text-gray-500 dark:text-gray-400 -mt-1">Smart Attendance</span>
            @endif
        </div>
    @endif
</div>