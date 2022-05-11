<div class="main-container home-container">

    <div class="mx-auto max-w-screen-xl w-full px-5 md:px-16 xl:px-0">

        <div class="flex flex-col w-full justify-between">

            <div class="flex w-full">

                <h3 class="text-2xl md:text-3xl">{!! $page->page_title !!}</h3>

            </div>

            <div class="flex flex-col md:flex-row justify-between w-full">

                <div class="flex flex-col md:w-6/12">

                    {!! $page->content !!}

                    <a class="btn -mt-5 md:-mt-0" href="{{ url('over-ons') }}">Lees meer</a>

                </div>

                <div class="flex md:w-6/12 md:ml-5 mt-10 md:mt-0">

                    <figure>

                        <img src="{{ asset('img/common/DPonAir_v01.png') }}" alt="Make My Radio: DPonAir." />

                    </figure>

                </div>

            </div>

        </div>

    </div>

</div>
