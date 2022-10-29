<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>🚀 RocketDoc - PSM Changelog</title>
        
        <!-- Scripts -->
        @if( env('APP_ENV') == 'local')
            <script src="{{ asset('js/app.js') }}" defer></script>
        @else
            <script src="{{ asset('js/app.js', true) }}" defer></script>
        @endif


{{--        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>--}}
        <script src="{{ asset('js/alpinejs.cdn.min.js') }}" defer></script>
        
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('fonts/ionicons.woff', true) }}" rel="stylesheet">
        
        <!-- Styles -->
        @if( env('APP_ENV') == 'local')
            <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @else
            <link href="{{ asset('css/app.css', true) }}" rel="stylesheet">
        @endif
{{--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">--}}
        <link href="{{ asset('css/notyf.min.css') }}" rel="stylesheet">
        
        <!-- Icons -->
        <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
{{--        <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">--}}

        
        <script type="module">
            import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
        </script>
        @livewireStyles
    </head>
    
    <body class="min-h-screen bg-gray-50">
        <div id="app">
            @include('layouts.nav')
        
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        
        @livewireScripts
        
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>
        
        @stack('scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

        
        @if (session()->has('success')) 
            <script>
                const notyf = new Notyf({dismissible: true})
                notyf.success('{{ session('success') }}')
            </script>
        @endif

        @if(Session::has('error'))
            <script>
                const notyf = new Notyf({dismissible: true})
                notyf.error('{!!Session::get('error')!!}')
            </script>
        @endif

        
        <script>
            /* Simple Alpine Image Viewer */
            document.addEventListener('alpine:init', () => {
                Alpine.data('imageViewer', (src = '') => {
                    return {
                        imageUrl: src,
        
                        refreshUrl() {
                            this.imageUrl = this.$el.getAttribute("image-url")
                        },
        
                        fileChosen(event) {
                            this.fileToDataUrl(event, src => this.imageUrl = src)
                        },
        
                        fileToDataUrl(event, callback) {
                            if (! event.target.files.length) return
        
                            let file = event.target.files[0],
                                reader = new FileReader()
        
                            reader.readAsDataURL(file)
                            reader.onload = e => callback(e.target.result)
                        },
                    }
                })
            })
        </script>
        @if( env('APP_ENV') == 'local')
            <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
        @else
            <script src="{{ asset('js/ckeditor/ckeditor.js', true) }}"></script>
        @endif

        @stack('ckeditor-scripts')
        @stack('copy-clipboard-scripts')
        @stack('clear-generate')
    </body>
</html>