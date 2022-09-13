<table class="w-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <thead class="bg-gray-200 border-b border-gray-300">
        <tr class="">
            @foreach ($headers as $header)
                <th class="px-6 py-3 {{  $header['classes'] }}">{{ $header['name'] }}</th>
            @endforeach
            
        </tr>
    </thead>
        
        <tbody class="pt-1 p-6 bg-white border-b border-gray-200">
            {{ $slot }}
            
        </tbody>
    </table>