<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gift List') }}
            </h2>
            <x-nav-link :href="route('gifts.create')">
                {{ __('Send Gift') }}
            </x-nav-link>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-bladewind::table>
                        <x-slot name="header">
                            <th>Receiver</th>
                            <th>Amount</th>
                            <th>Sent At</th>
                        </x-slot>
                        @foreach ($bonuses as $bonus)
                            <tr>
                                <td>{{ $bonus?->receiver?->name }}</td>
                                <td>{{ $bonus->amount }}</td>
                                <td>{{ $bonus->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </x-bladewind::table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
