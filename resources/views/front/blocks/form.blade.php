@php
    $formName = $block['props']['form_name'] ?? 'form';
    $fields = $block['props']['fields'] ?? [];
    $submitText = $block['props']['submit_text'] ?? 'Enviar';
    $success = session('form_success.'.$formName);
@endphp
<form method="POST" action="{{ route('forms.submit') }}" class="space-y-4 max-w-2xl mx-auto">
    @csrf
    <input type="hidden" name="_form_name" value="{{ $formName }}">
    <input type="hidden" name="_source_url" value="{{ url()->current() }}">

    @if($success)
        <div class="bg-green-50 border border-green-200 text-green-700 rounded-md p-4 text-sm">
            {{ $success }}
        </div>
    @endif

    @foreach($fields as $f)
        @php
            $name = $f['name'] ?? 'field';
            $type = $f['type'] ?? 'text';
            $label = $f['label'] ?? '';
            $required = ! empty($f['required']);
            $placeholder = $f['placeholder'] ?? '';
            $oldVal = old($name);
            $err = $errors->first($name);
        @endphp
        @if($type === 'checkbox')
            <label class="flex items-start gap-2 text-sm text-gray-700">
                <input type="checkbox" name="{{ $name }}" value="1" @if($oldVal) checked @endif @if($required) required @endif class="mt-1 accent-pink-500">
                <span>{{ $label }} @if($required)<span class="text-pink-600">*</span>@endif</span>
            </label>
        @else
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $label }} @if($required)<span class="text-pink-600">*</span>@endif
                </label>
                @if($type === 'textarea')
                    <textarea name="{{ $name }}" rows="5" placeholder="{{ $placeholder }}" @if($required) required @endif class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">{{ $oldVal }}</textarea>
                @elseif($type === 'select')
                    @php
                        $opts = $f['options'] ?? '';
                        $options = is_string($opts) ? array_filter(array_map('trim', preg_split('/\r?\n/', $opts))) : (array) $opts;
                    @endphp
                    <select name="{{ $name }}" @if($required) required @endif class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                        <option value="">— Selecciona —</option>
                        @foreach($options as $opt)
                            <option value="{{ $opt }}" @selected($oldVal === $opt)>{{ $opt }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="{{ $type }}" name="{{ $name }}" value="{{ $oldVal }}" placeholder="{{ $placeholder }}" @if($required) required @endif class="w-full border border-pink-200 rounded-md px-3 py-2 focus:border-pink-500 focus:outline-none">
                @endif
                @if($err)
                    <p class="text-xs text-red-600 mt-1">{{ $err }}</p>
                @endif
            </div>
        @endif
    @endforeach

    <div>
        <button type="submit" class="bg-gradient-to-br from-pink-600 to-pink-500 hover:from-pink-500 hover:to-pink-400 text-white font-bold uppercase tracking-widest text-sm px-6 py-3 rounded-md transition">
            {{ $submitText }}
        </button>
    </div>
</form>
