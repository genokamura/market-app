<x-app-layout>
    <x-header>
            {{ __('Exhibit Complete!!') }}
    </x-header>

    <x-card>
        {{ __("Exhibit completed. Thank you!!") }}

        <!-- TODO: add link to exhibited item page -->

        <div align="right">
            <a href="{{ route('item.exhibit.create') }}" class="btn btn-primary btn-sm">
                <x-primary-button>
                    {{ __('Continue to Exhibits') }}
                </x-primary-button>
            </a>
        </div>
    </x-card>
</x-app-layout>
