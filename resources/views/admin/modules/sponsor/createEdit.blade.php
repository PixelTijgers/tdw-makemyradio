@section('meta')
<title>{{ config('app.name') }} | {{ (@$sponsor ? __('Edit') . ' ' . \Str::Lower(__('Sponsor')) . ': ' . $sponsor->name  : __('Sponsor') . ' ' . \Str::Lower(__('Add'))) }}</title>
    <meta name="description" content="{{ (@$sponsor ? __('Sponsor Edit') : __('Sponsor Add')) }}" />
@endsection

<x-adminLayout>

    <div class="{{ $cssNs }}">

                    @include('admin.layouts.breadcrumb', [
                        'title' => __('Sponsor'),
                        'description' => (@$sponsor ? __('Edit') . ' ' . \Str::Lower(__('Sponsor')) . ': ' . $sponsor->name  : __('Sponsor Add')),
                        'breadcrum' => [
                            __('Sponsor') => route('sponsor.index'),
                            (@$sponsor ? __('Edit') . ' ' . \Str::Lower(__('Sponsor')) . ': ' . $sponsor->name  : __('Sponsor') . ' ' . \Str::Lower(__('Add'))) => '#'
                        ],
                    ])
                    @if ($errors->any())

                    <div class="alert alert-fill-danger alert-dismissible fade show" role="alert">
                        {{ __('Item Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                    @endif

                    <form class="form-content" method="post" action="{{ (@$sponsor ? route('sponsor.update', $sponsor) : route('sponsor.store')) }}">

                        @csrf

                        @if(@$sponsor)

                        @method('PATCH')

                        @endif

                        <div class="row">

                            <div class="col-md-12 grid-margin stretch-card">

                                <div class="card">

                                    <div class="card-body">

                                        <div class="col-md-6">

                                            <x-form.input
                                                type="text"
                                                name="name"
                                                :label="__('Name')"
                                                :value="(old('name') ? old('name') : (@$sponsor ? $sponsor->name : null))"
                                            />

                                            <x-form.file
                                                extensions="jpg jpeg png"
                                                name="postImage"
                                                :label="__('Image')"
                                                :file="(@$post ? $post->getFirstMediaUrl('postImage') : null)"
                                                :description="__('Image Description')"
                                                :required="false"
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary">{{ (@$sponsor ? __('Edit') : __('Add')) }}</button>
                        </div>

                    </form>

                </div>

</x-adminLayout>
