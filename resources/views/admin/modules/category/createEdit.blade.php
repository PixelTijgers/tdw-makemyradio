@section('meta')
<title>{{ config('app.name') }} | {{ (@$category ? __('Edit') . ' ' . \Str::Lower(__('Category')) . ': ' . $category->name  : __('Category') . ' ' . \Str::Lower(__('Add'))) }}</title>
    <meta name="description" content="{{ (@$category ? __('Category Edit') : __('Category Add')) }}" />
@endsection

<x-adminLayout>

    <div class="{{ $cssNs }}">

                    @include('admin.layouts.breadcrumb', [
                        'title' => __('Category'),
                        'description' => (@$category ? __('Edit') . ' ' . \Str::Lower(__('Category')) . ': ' . $category->name  : __('Category Add')),
                        'breadcrum' => [
                            __('Category') => route('category.index'),
                            (@$category ? __('Edit') . ' ' . \Str::Lower(__('Category')) . ': ' . $category->name  : __('Category') . ' ' . \Str::Lower(__('Add'))) => '#'
                        ],
                    ])
                    @if ($errors->any())

                    <div class="alert alert-fill-danger alert-dismissible fade show" role="alert">
                        {{ __('Item Error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                    </div>
                    @endif

                    <form class="form-content" method="post" action="{{ (@$category ? route('category.update', $category) : route('category.store')) }}">

                        @csrf

                        @if(@$category)

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
                                                :value="(old('name') ? old('name') : (@$category ? $category->name : null))"
                                            />

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary">{{ (@$category ? __('Edit') : __('Add')) }}</button>
                        </div>

                    </form>

                </div>

</x-adminLayout>
