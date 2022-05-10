@section('meta')
<title>{{ config('app.name') }} | {{ $page ? $page->meta_title : config('cms.common.settings.head.meta_title') }}</title>
    <meta name="description" content="{{ $page ? $page->meta_description : config('cms.common.settings.head.meta_description') }}">
    <meta name="keywords" content="{{ $page ? $page->meta_tags : config('cms.common.settings.head.meta_tags') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $page ? $page->og_title : config('cms.common.settings.head.meta_title') }}" />
    <meta property="og:description" content="{{ $page ? $page->og_description : config('cms.common.settings.head.meta_description') }}" />
    <meta property="og:url" content="{{ $page ? $page->og_slug : url() }}" />
    <meta property="og:type" content="{{ $page ? $page->og_type : config('cms.common.settings.head.og_type') }}" />
    <meta property="og:locale" content="{{ $page ? $page->og_locale : config('cms.common.settings.head.og_locale') }}" />
    <meta property="og:updated_time" content="{{ $page ? $page->last_edit_at->toIso8601String() : now() }}" />
    <meta property="og:image" content="{{ $page->getFirstMediaUrl('pageOgImage') ? $page->getFirstMediaUrl('pageOgImage') : URL::asset('img/common/og_image_default.jpg') }}" />
@endsection

@pushOnce('styles')
@endPushOnce

@pushOnce('scripts')
@endPushOnce

<x-front-layout>

    <main class="{{ $cssNs }}">

        @include('components.page-slider')

        <div class="main-container">

            <div class="mx-auto max-w-screen-xl w-full px-5 md:px-16 xl:px-0">

                <h2>{{ config('app.name') }} </h2>
                {!! $page->content !!}

            </div>

        </div>

        <div class="main-container">

            <div class="mx-auto max-w-screen-xl w-full px-5 md:px-16 xl:px-0">

                <form method="post" action="{{ route('contact.index')}}" class="w-7/12">

                    <div class="form-group">

                        <label for="name">Naam:</label>
                        <input id="name" type="text" name="name" placeholder="Naam" autofocus/>

                    </div>

                    <div class="form-group">

                        <label for="company">Bedrijf:</label>
                        <input id="company" type="text" name="company" placeholder="Bedrijf"/>

                    </div>

                    <div class="form-group">

                        <label for="email">E-mail adres:</label>
                        <input id="email" type="email" name="email" placeholder="E-mail adres"/>

                    </div>

                    <div class="form-group">

                        <label for="email">E-mail adres:</label>
                        <input id="email" type="email" name="email" placeholder="E-mail adres"/>

                    </div>

                    <div class="form-group">

                        <label for="phone">Telefoonnummer:</label>
                        <input id="phone" type="text" name="phone" placeholder="Telefoonnummer"/>

                    </div>

                    <div class="form-group">

                        <label for="message">Bericht:</label>
                        <textarea placeholder="Bericht" name="message" id="message"></textarea>

                    </div>

                </form>

            </div>

        </div>

        <div class="sub-container">



        </div>

    </main>

</x-front-layout>
