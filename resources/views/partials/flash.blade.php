@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md shadow-sm">
            {{ session('error') }}
        </div>
    </div>
@endif

@if (session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
         class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 rounded-md shadow-sm">
            {{ session('info') }}
        </div>
    </div>
@endif
