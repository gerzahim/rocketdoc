@php $editing = isset($ticket) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="key"
            label="Key"
            value="{{ old('key', ($editing ? $ticket->key : '')) }}"
            maxlength="255"
            placeholder="Key"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="summary"
            label="Summary"
            value="{{ old('summary', ($editing ? $ticket->summary : '')) }}"
            maxlength="255"
            placeholder="Summary"
{{--            required--}}
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.url
            name="url"
            label="Url"
            value="{{ old('url', ($editing ? $ticket->url : '')) }}"
            maxlength="255"
            placeholder="Url"
{{--            required--}}
        ></x-inputs.url>
    </x-inputs.group>

    @if($editing)
    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.releases.name')
        </h4>

        <div class="py-2">
            @foreach ($releases as $release)
            <div>
                <x-inputs.checkbox
                    id="release{{ $release->id }}"
                    name="releases[]"
                    label="{{ ucfirst($release->name) }}"
                    value="{{ $release->id }}"
                    :checked="isset($ticket) ? $ticket->releases()->where('id', $release->id)->exists() : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
