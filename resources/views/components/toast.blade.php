<div x-data="toast()" x-init="init()" @toast.window="show($event.detail)"
    class="fixed inset-0 flex flex-col items-end justify-start px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end z-50 space-y-4">
    <template x-for="(toast, index) in toasts" :key="index">
        <div x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0"
                        x-bind:class="{
                            'text-green-400': toast.type === 'success',
                            'text-red-400': toast.type === 'error',
                            'text-blue-400': toast.type === 'info',
                            'text-yellow-400': toast.type === 'warning'
                        }">
                        <template x-if="toast.type === 'success'">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'info'">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </template>
                        <template x-if="toast.type === 'warning'">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </template>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p x-text="toast.message" class="text-sm font-medium text-gray-900"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="remove(toast.id)"
                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 h-1 w-full">
                <div class="h-1 transition-all duration-500 ease-linear"
                    x-bind:class="{
                        'bg-green-500': toast.type === 'success',
                        'bg-red-500': toast.type === 'error',
                        'bg-blue-500': toast.type === 'info',
                        'bg-yellow-500': toast.type === 'warning'
                    }"
                    x-bind:style="`width: ${toast.progress}%`"></div>
            </div>
        </div>
    </template>
</div>

<script>
    function toast() {
        return {
            toasts: [],
            init() {
                // Check for session flashes
                @if (session('success'))
                    this.show({
                        type: 'success',
                        message: '{{ session('success') }}'
                    });
                @endif

                @if (session('error'))
                    this.show({
                        type: 'error',
                        message: '{{ session('error') }}'
                    });
                @endif
            },
            show(event) {
                const toast = {
                    id: Date.now(),
                    type: event.type || 'info',
                    message: event.message,
                    progress: 100,
                    timeout: setTimeout(() => {
                        this.remove(toast.id);
                    }, 5000) // 5 seconds
                };

                // Decrease progress bar every 50ms
                const interval = setInterval(() => {
                    toast.progress -= 1;

                    if (toast.progress <= 0) {
                        clearInterval(interval);
                    }
                }, 50);

                toast.interval = interval;

                this.toasts.push(toast);
            },
            remove(id) {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) {
                    clearTimeout(toast.timeout);
                    clearInterval(toast.interval);
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }
            }
        }
    }
</script>
