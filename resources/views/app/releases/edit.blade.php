<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.releases.edit_title')
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('releases.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                    @lang('crud.releases.edit_title')
                </x-slot>

                <x-form
                    method="PUT"
                    action="{{ route('releases.update', $release) }}"
                    class="mt-4"
                >
                    @include('app.releases.form-inputs')

                    <div class="mt-10">
                        <a href="{{ route('releases.index') }}" class="button">
                            <i
                                class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                            ></i>
                            @lang('crud.common.back')
                        </a>

                        <a href="{{ route('releases.create') }}" class="button">
                            <i class="mr-1 icon ion-md-add text-primary"></i>
                            @lang('crud.common.create')
                        </a>
                        <button
                                class="button button-secondary"
                                onclick="resetDoc();"
                        >
                            <i class="mr-1 icon ion-md-document"></i>
                            Clear Doc
                        </button>

                        <button
                            type="submit"
                            class="button button-primary float-right"
                        >
                            <i class="mr-1 icon ion-md-save"></i>
                            @lang('crud.common.update')
                        </button>


                    </div>
                </x-form>
            </x-partials.card>
            @push('clear-generate')
                <script>
                    function resetDoc() {
                        event.preventDefault();
                        CKEDITOR.instances.document.setData("Initial content goes here.");
                    }
                </script>
            @endpush

            @can('view-any', App\Models\Issue::class)
            <x-partials.card class="mt-5">
                <x-slot name="title"> Issues </x-slot>

                <livewire:release-issues-detail :release="$release" />
            </x-partials.card>
            @endcan
        </div>
    </div>
</x-app-layout>
