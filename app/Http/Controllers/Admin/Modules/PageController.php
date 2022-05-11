<?php

// Controller namespacing.
namespace App\Http\Controllers\Admin\Modules;
use App\Http\Controllers\Controller;

// Facades.
use Illuminate\Support\Facades\Validator;

// Models.
use App\Models\Page;
use App\Models\PageSlide;
use App\Models\NavigationMenu;
use App\Models\NavigationMenuPage;

// Request
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;

// Traits
use App\Traits\HasRightsTrait;
use App\Traits\MediaHandlerTrait;

class PageController extends Controller
{
    /**
     * Traits
     *
     */
    use HasRightsTrait;
    use MediaHandlerTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check which navigation menu is selected. Default is main menu.
        if(request()->input('navigationMenuId') !== null)
            $navigationMenuId = request()->input('navigationMenuId');
        else
            $navigationMenuId = 2;

        // Return the navigation menu and menu pages.
        $navigationMenu = $this->getNavigationMenu($navigationMenuId);
        $navigationMenuPages = $this->getNavigationMenuPages($navigationMenu);

        // Init view.
        return view('admin.modules.page.index', compact('navigationMenu', 'navigationMenuPages'));
    }

    /**
     * Process the nested data
     *
     * @param Array $parents
     * @param Array $children
     *
     * @return mixed
     */
    protected function processChildren($parents = [], $children = []) {

        // Turn $parents into a collection.
        $parents = collect($parents)->sortBy('order')->toArray();

        // Loop through the parents.
        foreach($parents as $key => $value) {

            // Set children array.
            $parentChildren = [];

            // Loop through children.
            foreach($children as $childKey => $childValue) {
                if($childValue['parentId'] === $value['id'])
                    $parentChildren[] = $childValue;
            }

            // Add values to array.
            $parents[$key]['children'] = collect($this->processChildren($parentChildren, $children))->sortBy('order')->toArray();
        }

        // Return array.
        return $parents;
    }

    /**
     * Update the ranks in the database
     *
     * @return mixed
     */
    protected function updateSortable(Request $request)
    {
        // Set empty array's.
        $parents = [];
        $children = [];

        // Set request data.
        $requestData = $request->sortableOrder;

        // Loop through results.
        foreach ($requestData as $key => $sortableOrder) {
            $sortableOrder['children'] = [];

            if (@!$sortableOrder['parentId'])
                $parents[] = $sortableOrder;
            else
                $children[] = $sortableOrder;
        }

        // Build tree.
        Page::rebuildTree($this->processChildren($parents, $children));

        // Return response true.
        return response()->json('Volgorde met succes opgeslagen', 200);
    }

    /**
     * Return the navigation menus.
     *
     * @return mixed
     */
    protected function getNavigationMenu($navigationMenuId)
    {
        // Return the selected navigation menu.
        return NavigationMenu::where('id', $navigationMenuId)->firstOrFail();
    }

    /**
     * Return the navigation menu truee.
     *
     * @return mixed
     */
    protected function getNavigationMenuPages(NavigationMenu $navigationMenu)
    {
        // Return the selected navigation menu pages.
        return Page::whereHas('navigation_menus', function($query) use ($navigationMenu) {
            $query->whereId($navigationMenu->id);
        })->orderBy('_lft', 'asc')->get()->toTree();
    }

    /**
     * Process the image request.
     *
     * @param  collection $request
     * @param  int  $page
     * @param  string $imageName
     * @return \Illuminate\Http\Response
     */
    protected function processImage($request, $model, $imageName)
    {
        // Only change page image when there's a file uploaded.
        if($request->exists($imageName . 'CurrentImage') && !$request->filled($imageName . 'CurrentImage'))
            // Delete image.
            $model->clearMediaCollection($imageName);
        elseif($request->hasFile($imageName))
            // Upload image.
            $this->manageInputMedia($model, $imageName);
    }

    /**
     * Process the image request.
     *
     * @param  collection $request
     * @param  int  $page
     * @param  string $imageName
     * @return \Illuminate\Http\Response
     */
    protected function processPageSlider($request, $model)
    {
        // Add new slides.
        foreach(collect($request->pageSlider)->slice(1)->toArray() as $key => $slide)
        {
            $pageSlide = PageSlide::updateOrCreate([
                'id' => @$slide['model_id']
            ],
            [
                'page_id' => $model->id,
                'title' => $slide['title'],
                'figcaption' => $slide['figcaption'],
                'alt' => $slide['alt'],
                '_lft' => $slide['_lft'],
            ]);

            if($request->hasFile('pageSlider.' . $key))
            {
                $pageSlide->addMediaFromRequest('pageSlider.' . $key)->toMediaCollection('pageSliderImage');
            }

            $modelIdCollection[] = (@$slide['model_id'] ? $slide['model_id'] : $pageSlide->id);
        };

        PageSlide::where('page_id', $model->id)->whereNotIn('id', $modelIdCollection)->delete();

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Init view.
        return view('admin.modules.page.createEdit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $page
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        // Post data to database.
        $page = Page::create([
            'slug'  => $request->slug,
            'og_slug' => $request->og_slug,
        ] + $request->validated());

        // Page OG image.
        $this->processImage($request, $page, 'ogImage');

        // Check if any navigation menu item is selected.
        if ($request->navigation_menu !== null)
            // Update the navigation menu.
            $page->navigation_menus()->sync($request->navigation_menu);
        else
            // Return back with message.
            return redirect()->back()->with([
                'type' => 'danger',
                'message' => __('Select Navigation')
            ])->withInput();

        // Return back with message.
        return redirect()->route('page.index')->with([
                'type' => 'success',
                'message' => __('Item Add')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        // Get the pageslides.
        $pageSlides = PageSlide::where('page_id', $page->id)->orderBy('_lft', 'ASC')->get();

        // Init view.
        return view('admin.modules.page.createEdit', compact('page', 'pageSlides'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageRequest  $request
     * @param  int  $page
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, Page $page)
    {
                // Check if any navigation menu item is selected.
        if ($request->navigation_menu !== null)
        {
            // Update the navigation menu.
            $page->navigation_menus()->sync($request->navigation_menu);

            // Build the page slug.
            if($page->id === 1)
            {
                $updatePageSlug = '/';
                $og_slug = $updatePageSlug;
            }
            else
            {
                $pageSlug = Page::where('id', $page->parent_id)->first();
                $updatePageSlug = ($pageSlug !== null ? $pageSlug->slug . '/' . $request->slug : '/' . $request->slug);
                $og_slug = ($pageSlug !== null ? $pageSlug->og_url . '/' . $request->slug : '/' . $request->slug);
            }

            // Set data to save into database.
            $page->update([
                'slug'  => $updatePageSlug,
                'og_slug' => $og_slug,
                'last_edited_administrator_id' => auth()->user()->id,
                'last_edit_at' => \Carbon\Carbon::now(),
            ] + $request->validated());

            // Page OG image.
            $this->processImage($request, $page, 'ogImage');

            // Page slides.
            $this->processPageSlider($request, $page);

            // Save data.
            $page->save();
        }
        else
            // Return back with message.
            return redirect()->back()->with([
                'type' => 'danger',
                'message' => __('Select Navigation')
            ])->withInput();

        // Return back with message.
        return redirect()->route('page.index')->with([
                'type' => 'success',
                'message' => __('Item Edit')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if($page->id === 1)
        {
            // Return back with message.
            return redirect()->route('page.index')->with([
                    'type' => 'danger',
                    'message' => __('Page Delete')
                ]
            );
        }

        // Delete the page from the pivot table.
        NavigationMenuPage::where('page_id', $page->id)->delete();

        // Delete the model.
        $page->delete();

        // Return back with message.
        return redirect()->back()->with([
            'type' => 'success',
            'message' => __('Item Delete')
        ]);
    }
}
