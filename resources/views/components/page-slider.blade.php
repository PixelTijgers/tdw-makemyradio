@if(\App\Models\PageSlide::where('page_id', $page->id)->get() != null)
<div class="{{ $cssNs }}">

    <div id="pageSlider">

        @foreach(\App\Models\PageSlide::where('page_id', $page->id)->orderBy('_lft', 'asc')->get() as $slide)
        <div class="slide">

            <figure>

                <img src="{{ $slide->getFirstMediaUrl('pageSliderImage') }}" alt="{{ $slide->alt }}"/>

            </figure>

            <div class="meta">

                <h3>{{ $slide->title }}</h3>
                <p>{{ $slide->figcaption }} </p>

            </div>

        </div>
        @endforeach

    </div>

</div>
@endif
