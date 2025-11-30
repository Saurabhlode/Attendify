<div x-data="liveStats()" x-init="init()" class="hidden md:flex items-center space-x-4 text-sm">
    <div class="flex items-center space-x-2 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full">
        <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
        <span x-text="stats.label"></span>
        <span x-text="stats.value" class="font-semibold"></span>
    </div>
</div>

<script>
function liveStats() {
    return {
        stats: { label: 'Loading...', value: '' },
        
        init() {
            this.fetchStats();
            setInterval(() => this.fetchStats(), 30000); // Update every 30 seconds
        },
        
        async fetchStats() {
            try {
                const response = await fetch('/api/stats');
                const data = await response.json();
                
                @if(auth()->user()->role === 'Admin')
                    this.stats = { 
                        label: 'Active Today:', 
                        value: data.total_sessions_today || 0 
                    };
                @elseif(auth()->user()->role === 'Teacher')
                    this.stats = { 
                        label: 'Sessions Today:', 
                        value: data.sessions_today || 0 
                    };
                @else
                    this.stats = { 
                        label: 'Attendance Today:', 
                        value: data.attendance_today || 0 
                    };
                @endif
            } catch (error) {
                console.error('Failed to fetch stats:', error);
            }
        }
    }
}
</script>