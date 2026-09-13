@if(session('success') || session('error') || session('status'))
<div id="toast-notification" class="fixed top-10 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300 opacity-0 -translate-y-4">
    @if(session('success') || session('status'))
        <div class="bg-green-600 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 border border-green-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-medium text-sm">{{ session('success') ?? session('status') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-2 border border-red-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-medium text-sm">{{ session('error') }}</span>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById('toast-notification');
        if (toast) {
            // Animasi masuk
            setTimeout(() => {
                toast.classList.remove('opacity-0', '-translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            }, 10);

            // Menghilang dalam 1 detik sesuai permintaan
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', '-translate-y-4');
                
                // Hapus dari DOM
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 1000); 
        }
    });
</script>
@endif
