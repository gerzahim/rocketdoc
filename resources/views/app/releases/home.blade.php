<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.releases.index_title')
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    @lang('crud.releases.index_title')
                </x-slot>


                <div class="block w-full overflow-auto scrolling-touch prose">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <tbody class="text-gray-600">
                            @forelse($releases as $release)
                            <tr class="hover:bg-gray-50" id="{{$release->name}}">
                                <td class="px-4 py-3 text-left">
                                    {!! html_entity_decode($release->document) ?? '-' !!}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
{{--                        <tfoot>--}}
{{--                            <tr>--}}
{{--                                <td colspan="5">--}}
{{--                                    <div class="mt-10 px-4">--}}
{{--                                        {!! $releases->render() !!}--}}
{{--                                    </div>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                        </tfoot>--}}
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
