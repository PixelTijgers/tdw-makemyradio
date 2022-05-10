<h6 class="card-title mt-4">{{ __('Message') }}</h6>
<p class="mb-4 text-muted small">{{ __('Message Description') }}</p>

<div class="row">

    <div class="col-md-7">

        <x-form.input
            type="text"
            name="title"
            :label="__('Title')"
            :value="(old('title') ? old('title') : (@$post ? $post->title : null))"
        />

        <x-form.textarea
            name="intro"
            maxLength="165"
            :description="__('Intro Description')"
            :label="__('Intro')"
            :value="(old('intro') ? old('intro') : (@$post ? $post->intro : null))"
        />

        <x-form.rich-text
            name="content"
            :label="__('Message')"
            :value="(old('content') ? old('content') : (@$post ? $post->content : null))"
        />

        <x-form.slug
            name="slug"
            slugField="title"
            :description="__('Url Description')"
            :label="__('Url')"
            :model="@$post"
            :modelName="\App\Models\Post::where('id', @$post->parent_id)->first()"
            :value="(old('slug') ? old('slug') : (@$post ? $post->slug : null))"
        />

    </div>

    <div class="col-md-4 offset-md-1">

        <x-form.file
            extensions="jpg jpeg png"
            name="postImage"
            :label="__('Image')"
            :file="(@$post ? $post->getFirstMediaUrl('postImage') : null)"
            :description="__('Image Description')"
            :required="false"
        />

        <x-form.select
            name="category_id"
            :label="__('Category')"
            :cols="['col-3', 'col-4']"
            :value="(old('category_id') ? old('category_id') : (@$post ? $post->category_id : null))"
            :options="\App\Models\Category::all()->sortBy('name')"
            :valueWrapper="['id', 'name']"
            :disabledOption="__('Select Category')"
        />

        <x-form.select
            name="administrator_id"
            :label="__('Author')"
            :cols="['col-3', 'col-4']"
            :value="(old('administrator_id') ? old('administrator_id') : (@$post ? $post->administrator_id : null))"
            :options="\App\Models\Administrator::all()->sortBy('name')"
            :valueWrapper="['id', 'name']"
            :disabledOption="__('Select Administrator')"
        />

        <x-form.date-time
            name="published_at"
            :label="__('Published At')"
            :value="(old('published_at') ? old('published_at') : (@$post ? $post->published_at : null))"
            :description="__('Published At Description')"
        />

        <x-form.date-time
            name="unpublished_at"
            :label="__('Unpublished At')"
            :value="(old('unpublished_at') ? old('unpublished_at') : (@$post ? $post->unpublished_at : null))"
            :description="__('Unpublished At Description')"
        />

        <x-form.select
            name="status"
            :label="__('Status')"
            :cols="['col-3', 'col-4']"
            :value="(old('status') ? old('status') : (@$page ? $page->status : null))"
            :options="[
               'archived'   =>  __('Archived'),
               'draft'   =>  __('Draft'),
               'published' => __('Published'),
               'unpublished'   =>  __('Unpublished')
            ]"
            :disabledOption="__('Select Status')"
        />

    </div>

</div>
