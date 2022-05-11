<h6 class="card-title mt-4">{{ __('Slider') }}</h6>
<p class="mb-4 text-muted small">{{ __('Slider Description') }}</p>

<button class="addButton btn btn-primary mb-3 float-right" type="button">{{ __('Add Slide') }}</button>

<ul id="nestedImages" class="mt-4">

    @include('admin.modules.page.includes.slider.template')

    @if(!$pageSlides->isEmpty())

        @foreach($pageSlides as $key => $slide)

            <li class="slider-item mb-3">

                <div class="row">

                    <div class="col-md-12 mb-3">

                        <div class="border-bottom d-flex justify-content-end w-full pb-3">

                            <button class="closeButton btn btn-danger" type="button">{{ __('Delete Slide') }}</button>

                            <span class="btn btn-primary ml-3"><i class="fa-solid fa-grip-dots-vertical"></i></span>

                        </div>

                    </div>

                    <div class="col-md-7">

                        <input type="hidden" name="pageSlider[{{ $key }}][model_id]" value="{{ $slide->id }}" />
                        <input type="hidden" name="pageSlider[{{ $key }}][_lft]" value="{{ $slide->_lft }}" class="hidden-lft"/>

                        <x-form.input
                            type="text"
                            name="pageSlider[{{ $key }}][title]"
                            :label="__('Title')"
                            :required="false"
                            :value="$slide->title"
                        />

                        <x-form.textarea
                            name="pageSlider[{{ $key }}][figcaption]"
                            maxLength="165"
                            :label="__('Figcaption')"
                            :required="false"
                            :value="$slide->figcaption"
                        />

                    </div>

                    <div class="col-md-5">

                        <x-form.file
                            name="pageSlider[{{ $key + 1 }}][pageSliderImage]"
                            duplicateName="pageSlider[{{ $key }}][pageSliderImage][currentImage]"
                            :label="__('Image')"
                            :file="$slide->getFirstMediaUrl('pageSliderImage')"
                            extensions="jpg jpeg png"
                            :required="false"
                            :duplicate="true"
                            duplicateClass="pageSlide"
                            :required="false"
                        />

                        <x-form.input
                            type="text"
                            name="pageSlider[{{ $key }}][alt]"
                            :label="__('Description')"
                            :required="false"
                            :value="$slide->alt"
                        />

                    </div>

                </div>

            </li>

        @endforeach

    @endif

</ul>
