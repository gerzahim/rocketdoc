@php $editing = isset($template) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $template->name : '')) }}"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <div class="prose">
        <x-inputs.textarea name="document" id="document" label="Document" rows="5" >
            {{ old('document', ($editing ? $template->document : '')) }}
        </x-inputs.textarea>
    </div>
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