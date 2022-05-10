<h6 class="card-title mt-4">{{ __('Message') }}</h6>
<p class="mb-4 text-muted small">{{ __('Message Description') }}</p>

<div class="row">

    <div class="col-md-7">

        <x-form.input
            type="text"
            name="menu_title"
            :label="__('Menu Title')"
            :value="(old('menu_title') ? old('menu_title') : (@$page ? $page->menu_title : null))"
        />

        <x-form.input
            type="text"
            name="page_title"
            :label="__('Page Title')"
            :value="(old('page_title') ? old('page_title') : (@$page ? $page->page_title : null))"
        />

        <x-form.rich-text
            name="content"
            :label="__('Message')"
            :value="(old('content') ? old('content') : (@$page ? $page->content : null))"
        />
        @if($page->id !== 1)
        <x-form.slug
            name="slug"
            slugField="page_title"
            :description="__('Url Description')"
            :label="__('Url')"
            :model="@$page"
            :modelName="\App\Models\Post::where('id', @$page->parent_id)->first()"
            :value="(old('slug') ? old('slug') : (@$page ? $page->slug : null))"
        />
        @endif

    </div>

    <div class="col-md-4 offset-md-1">

        <x-form.checkbox
            name="navigation_menu[]"
            :label="__('Select Menu')"
            :values="(@$page ? $page->navigation_menus : null)"
            :options="App\Models\NavigationMenu::orderBy('id')->pluck('name', 'id')"
            :optionsTranslated="true"
            :description="__('Select Menu Description')"
        />

        <x-form.switcher
            name="visible_in_menu"
            :label="__('Visible In Menu')"
            :value="(old('visible_in_menu') === null ? (@$page ? $page->visible_in_menu : 1) : 0)"
            :required="false"
        />

        <x-form.date-time
            name="published_at"
            :label="__('Published At')"
            :value="(old('published_at') ? old('published_at') : (@$page ? $page->published_at : null))"
            :description="__('Published At Description')"
        />

        <x-form.date-time
            name="unpublished_at"
            :label="__('Unpublished At')"
            :value="(old('unpublished_at') ? old('unpublished_at') : (@$page ? $page->unpublished_at : null))"
            :description="__('Unpublished At Description')"
            :required="false"
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
