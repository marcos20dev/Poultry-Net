<div class="bg-white rounded-2xl shadow-lg p-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-gray-500 text-sm font-medium">{{ $title }}</h2>
            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $value }}</p>
            @if($subValue)
                <p class="text-gray-500 text-sm mt-1">{{ $subValue }}</p>
            @endif
            @if($trend)
                <div class="flex items-center mt-2">
                    <span class="text-{{ $trendColor ?? 'green' }}-500 text-sm font-medium flex items-center">
                        <i class="mr-1" data-feather="trending-{{ $trendColor == 'red' ? 'down' : 'up' }}" width="14"></i> {{ $trend }}
                    </span>
                    @if($trendText)
                        <span class="text-gray-500 text-sm ml-2">{{ $trendText }}</span>
                    @endif
                </div>
            @endif
        </div>
        <div class="bg-{{ $color }}-100 p-3 rounded-lg">
            <i class="text-{{ $color }}-600" data-feather="{{ $icon }}" width="24"></i>
        </div>
    </div>
</div>
