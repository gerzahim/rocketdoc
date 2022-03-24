@php $editing = isset($release) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $release->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.select name="project_id" label="Project" required>
            @php $selected = old('project_id', ($editing ? $release->project_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Project</option>
            @foreach($projects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>



    <x-inputs.group class="w-full lg:w-6/12">
        <x-inputs.date
            name="released_at"
            label="Released At"
            value="{{ old('released_at', ($editing ? optional($release->released_at)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <div class="px-4 my-4 w-full">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.tickets.name')
        </h4>

        <div class="py-2">
            @foreach ($tickets as $ticket)
            <div>
                <x-inputs.checkbox
                    id="ticket{{ $ticket->id }}"
                    name="tickets[]"
                    label="{{ ucfirst($ticket->name) }}"
                    value="{{ $ticket->id }}"
                    :checked="isset($release) ? $release->tickets()->where('id', $ticket->id)->exists() : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>


    @if($editing)
        <x-inputs.group class="w-full lg:w-6/12">
            <x-inputs.textarea name="document" label="Document" maxlength="255"
            >{{ old('document', ($editing ? $release->document : ''))
            }}</x-inputs.textarea
            >

        </x-inputs.group>
        <x-inputs.group class="w-full lg:w-6/12">
            <h5 class="font-medium text-gray-700">
                @lang('crud.releases.inputs.document')
            </h5>
{{--            {!!  $document_parsed ?? '-' !!}--}}
            {{  $document_parsed ?? '-' }}
        </x-inputs.group>
    @endif
</div>
