<div class="min-w-0 rounded-lg shadow-xs overflow-hidden bg-white dark:bg-gray-800 m-3">
    <div class="p-4 flex items-center">
        <div class="p-3 rounded-full text-orange-500 dark:text-orange-100 bg-orange-100 dark:bg-orange-500 mr-4">
            {{ $icon }}
        </div>
        <div>
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                {{ $statName }}
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                {{ $statValue }}
            </p>
        </div>
    </div>
</div>
