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

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="document" label="Document" maxlength="255"
            >{{ old('document', ($editing ? $template->document : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
