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
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $release->status : '')) @endphp
            <option value="draft" {{ $selected == 'draft' ? 'selected' : '' }} >Draft</option>
            <option value="completed" {{ $selected == 'completed' ? 'selected' : '' }} >Completed</option>
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

    @if($editing)
        <x-inputs.group class="w-full">
            <div class="prose">
                <x-inputs.textarea name="document" id="document" label="Document" rows="5" >
                    {{ old('document', ($editing ? $release->document : '')) }}
                </x-inputs.textarea>
            </div>

        </x-inputs.group>
    @endif
</div>

@push('ckeditor-scripts')
    <script>
        // alert('I\'m coming from child');
        ClassicEditor
            .create( document.querySelector( '#document' ), {
                licenseKey: '',
            })
            .then( editor => {
                console.log( editor );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush