<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.releases.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('releases.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                    @lang('crud.releases.show_title')
                </x-slot>

                <div class="mt-4 px-4">
                    {{--
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.releases.inputs.name')
                        </h5>
                        <span>{{ $release->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.releases.inputs.project_id')
                        </h5>
                        <span
                            >{{ optional($release->project)->name ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.releases.inputs.status')
                        </h5>
                        <span>{{ $release->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.releases.inputs.released_at')
                        </h5>

                        @php
                            $dt = new \Carbon\Carbon($release->released_at);
                            $release_released_at = $dt->toFormattedDateString();
                        @endphp
                        <span>{{ $release_released_at ?? '-' }}</span>
                    </div>
                    --}}
                    <div class="mb-4 prose">
                        {{--
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.releases.inputs.document')
                            <button id="button1" onclick="copyToClipboard('document12');return false;">Click to copy</button>
                        </h5>
                        <br>
                        <span>{!! $release->document ?? '-' !!}</span>
                        --}}
                        <article id="document12">
                            {!! html_entity_decode($release->document) ?? '-' !!}
                        </article>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('releases.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Release::class)
                    <a href="{{ route('releases.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
    @push('copy-clipboard-scripts')
        <script>
            function copyToClipboard(id) {
                var r = document.createRange();
                r.selectNode(document.getElementById(id));
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(r);
                document.execCommand('copy');
                window.getSelection().removeAllRanges();

                // var copyText = document.querySelector("#document12");
                // console.log(copyText);
                // copyText.select();
                // document.execCommand("copy");
            }


        </script>
    @endpush
</x-app-layout>
