@section('meta')
<title>{{ config('app.name') }} | {{ (@$social ? __('Edit') . ' ' . \Str::Lower(__('Social Media')) . ': ' . $social->socialmedia->name : __('Social Media') . ' ' . \Str::Lower(__('Add'))) }}</title>
    <meta name="description" content="{{ (@$social ? __('Social Media Edit') : __('Social Media Add')) }}" />
@endsection

<x-adminLayout>

    <div class="{{ $cssNs }}">

                    @include('admin.layouts.breadcrumb', [
                        'title' => __('Social Media'),
                        'description' => (@$social ? __('Edit') . ' ' . \Str::Lower(__('Social Media')) . ': ' . $social->socialmedia->name : __('Social Media') . ' ' . \Str::Lower(__('Add'))),
                        'breadcrum' => [
                            __('Social Media') => route('social.index'),
                            (@$social ? __('Edit') . ' ' . \Str::Lower(__('Social Media')) . ': ' . $social->socialmedia->name : __('Social Media') . ' ' . \Str::Lower(__('Add'))) => '#'
                        ],
                    ])
                    @if ($errors->any())

                    <div class="alert alert-fill-danger alert-dismissible fade show" role="alert">
                        {{ __('Item Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                    @endif

                    <form class="form-content" method="post" action="{{ (@$social ? route('social.update', $social) : route('social.store')) }}">

                        @csrf

                        @if(@$social)

                        @method('PATCH')

                        @endif

                        <div class="row">

                            <div class="col-md-12 grid-margin stretch-card">

                                <div class="card">

                                    <div class="card-body">

                                        <div class="col-md-6">

                                            <x-form.select
                                                name="social_media_id"
                                                :required="true"
                                                :label="__('Social Media')"
                                                :value="(old('social_media_id') ? old('social_media_id') : (@$social ? $social->social_media_id : null))"
                                                :options="\App\Models\SocialMedia::all()->sortBy('type')"
                                                :valueWrapper="['id', 'name']"
                                                :disabledOption="__('Select Icon')"
                                            />

                                            <x-form.input
                                                type="text"
                                                name="content"
                                                :label="__('Url')"
                                                :value="(old('content') ? old('content') : (@$social ? $social->content : null))"
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary">{{ (@$social ? __('Edit') : __('Add')) }}</button>
                        </div>

                    </form>

                </div>

</x-adminLayout>
