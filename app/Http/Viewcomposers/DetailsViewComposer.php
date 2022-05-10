<?php

// Namespacing.
namespace app\Http\ViewComposers;

// Facades.
use Illuminate\View\View;

// Models.
use App\Models\Details;

class DetailsViewComposer
{
    public function compose(View $view)
    {
        // Get all the company information.
        $details = Details::where('id', 1)->first();

        // Pass variable to view.
        $view->with('details', $details);
    }
}
