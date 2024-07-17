@php
    $referrals = $node->referrals ?? $node->direct_referrals;
@endphp
<li class="mb-2">
    <div class="p-2 border rounded bg-gray-100 flex justify-between items-center">
        <div>
            <span class="font-semibold">{{ $node->name }}</span>
        <span class="text-gray-600 text-sm">({{ $node->email }})</span>
        </div>
        <x-nav-link href="/referrers/{{ $node->id }}">
            {{ __('My Direct Referrals') }}
        </x-nav-link>
    </div>
    @if (count($referrals) > 0)

        <ul class="list-disc pl-5 mt-2">
            @foreach ($referrals as $childNode)
                @include('dashboard.referrals.partials.referral_tree', ['node' => $childNode])
            @endforeach
        </ul>
    @endif
</li>
