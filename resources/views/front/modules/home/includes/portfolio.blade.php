<div class="primary-container">

    <div class="mx-auto max-w-screen-xl w-full px-5 md:px-16 xl:px-0">

        <div class="portfolio flex flex-col md:flex-row md:flex-wrap md:justify-between">

            @foreach(App\Models\Post::orderBy('created_at', 'ASC')->limit(3)->get() as $item)
            <div class="portfolio-item flex flex-col w-full @if($loop->index === 0) pr-2 @elseif($loop->index === 1) pl-2 @else px-0 @endif @if(!$loop->last) md:w-1/2 @else md:w-full @endif lg:w-1/3 lg:px-5 mb-10">

                <figure>

                    <img src="{{ asset('img/common/portfolio_1.png') }}" alt="Portfolio Item 1" />

                </figure>

                <div class="meta flex flex-col">

                    <h3 class="text-2xl">{{ $item->title }}</h3>

                    <p>{{ $item->intro }}</p>

                    <a href="{{ url($item->slug) }}" class="btn">Lees meer</a>

                </div>

            </div>
            @endforeach()

        </div>

    </div>

</div>
