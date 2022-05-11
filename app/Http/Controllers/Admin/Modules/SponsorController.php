<?php

// Controller namespacing.
namespace App\Http\Controllers\Admin\Modules;
use App\Http\Controllers\Controller;

// Facades.
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;

// Models.
use App\Models\Sponsor;

// Request
use App\Http\Requests\SponsorRequest;

// Traits
use App\Traits\DataTableActionsTrait;
use App\Traits\HasRightsTrait;
use App\Traits\MediaHandlerTrait;

class SponsorController extends Controller
{
    /**
     * Traits
     *
     */
    use DataTableActionsTrait;
    use HasRightsTrait;
    use MediaHandlerTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        // Init datatables.
        if (request()->ajax()) {
            return DataTables::of(Sponsor::query())
            ->addColumn('action', function (Sponsor $sponsor) {
                return
                    '<div class="d-flex">' .
                    $this->setAction('sponsor.index', $sponsor, 'view', 'categories', false) .
                    $this->setAction('sponsor.edit', $sponsor, 'update', 'categories') .
                    $this->setAction('sponsor.destroy', $sponsor, 'destroy', 'categories') .
                    '</div>';
            })
            ->make(true);
        }

        // Set values.
        $html = $builder
                    ->addColumn([
                        'title' => __('Name'),
                        'data' => 'name'
                    ])
                    ->addAction([
                        'title' => __('Actions'),
                        'class' => 'actionHandler'
                    ])
                    ->parameters([
                        'order' =>
                            [0,'asc']
                    ]);

        // Init view.
        return view('admin.modules.sponsor.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Init view.
        return view('admin.modules.sponsor.createEdit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request)
    {
        // Post data to database.
        $sponsor = Sponsor::Create($request->validated());

        // Sponsor image.
        $this->processImage($request, $sponsor, 'sponsorImage');

        // Return back with message.
        return redirect()->route('sponsor.index')->with([
                'type' => 'success',
                'message' => __('Item Add')
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsor $sponsor)
    {
        // Init view.
        return view('admin.modules.sponsor.createEdit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorRequest $request, Sponsor $sponsor)
    {
        // Set data to save into database.
        $sponsor->update($request->validated());

        // Sponsor image.
        $this->processImage($request, $sponsor, 'sponsorImage');

        // Save data.
        $sponsor->save();

        // Return back with message.
        return redirect()->route('sponsor.index')->with([
                'type' => 'success',
                'message' => __('Item Edit')
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        // Delete the model.
        $sponsor->delete();

        // Return back with message.
        return redirect()->back()->with([
            'type' => 'success',
            'message' => __('Item Delete')
        ]);
    }
}
