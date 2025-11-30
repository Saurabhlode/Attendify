<div x-data="{ open: false, notifications: [], unreadCount: 0 }" 
     x-init="
        fetch('/api/notifications')
            .then(response => response.json())
            .then(data => {
                notifications = data.notifications;
                unreadCount = data.unread_count;
            });
        setInterval(() => {
            fetch('/api/notifications')
                .then(response => response.json())
                .then(data => {
                    notifications = data.notifications;
                    unreadCount = data.unread_count;
                });
        }, 30000);
     " 
     class="relative">
    
    <button @click="open = !open" 
            class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg transition-colors">
        <i class="fas fa-bell w-6 h-6 text-lg"></i>
        <span x-show="unreadCount > 0" 
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
              x-text="unreadCount"></span>
    </button>

    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 z-50">
        
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
        </div>
        
        <div class="max-h-96 overflow-y-auto">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                     :class="{ 'bg-blue-50 dark:bg-blue-900/20': !notification.read_at }">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.data.title"></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400" x-text="notification.data.message"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1" x-text="new Date(notification.created_at).toLocaleString()"></p>
                        </div>
                        <div x-show="!notification.read_at" class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    </div>
                </div>
            </template>
            
            <div x-show="notifications.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">
                No notifications yet
            </div>
        </div>
        
        <div x-show="notifications.length > 0" class="p-4 border-t border-gray-200 dark:border-gray-700">
            <button @click="
                fetch('/api/notifications/mark-all-read', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } })
                    .then(() => {
                        notifications.forEach(n => n.read_at = new Date());
                        unreadCount = 0;
                    })
            " class="w-full text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400 font-medium">
                Mark all as read
            </button>
        </div>
    </div>
</div>