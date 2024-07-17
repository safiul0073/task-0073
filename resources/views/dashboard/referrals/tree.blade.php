<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Direct and Indirect Referrals') }}
            </h2>
            {{-- my referral link --}}
            <div class="flex items-center space-x-4">
                <x-nav-link href="/join?referrel_code={{ auth()->user()->code }}">
                    {{ __('My Referral Link') }}
                </x-nav-link>
                <div class="flex space-x-2 items-center">
                    <p>Copy Referral Link</p>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                        onclick="copyReferralLink()"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>
                    </button>
                </div>
                <input type="text" id="referralLink"
                    value="{{ route('join.referrer', ['referrel_code' => auth()->user()->code]) }}"
                    style="position: absolute; left: -9999px;">

            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <ul class="list-disc pl-5">
                        @include('dashboard.referrals.partials.referral_tree', ['node' => $referrals])
                    </ul>
                </div>
            </div>

        </div>
    </div>
    @push('js')
        <script>
            function copyReferralLink() {
                // Get the referral link input element
                var referralLink = document.getElementById("referralLink");

                // Select the text field
                referralLink.select();
                referralLink.setSelectionRange(0, 99999); // For mobile devices

                // Copy the text inside the text field
                navigator.clipboard.writeText(referralLink.value).then(function() {
                    alert("Referral link copied to clipboard!");
                }, function(err) {
                    alert("Failed to copy referral link: ", err);
                });
            }
        </script>
    @endpush
</x-app-layout>
