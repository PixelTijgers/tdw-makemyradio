<div class="main-container home-container">

    <div class="mx-auto max-w-screen-xl w-full px-5 md:px-16 xl:px-0">

        <h3 class="text-3xl">Contact</h3>
        <p>In et tincidunt libero, quis dapibus dui. Praesent dapibus ac mi nec ultricies. Morbi nunc augue, congue a euismod vitae, blandit non arcu. Proin gravida sollicitudin dictum. Ut posuere mauris a semper semper. Etiam gravida, quam laoreet consequat placerat, ex leo laoreet justo, in aliquet velit massa nec mi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris egestas vel lorem eu rutrum. Cras efficitur malesuada nulla, et luctus ex imperdiet id. Duis sempert.</p>

        <div class="flex flex-row justify-between">

            <div class="flex lg:w-7/12">

                <form method="post" action="{{ route('contact.index')}}" class="contact w-full">

                    <div class="form-group">

                        <label for="name">Naam:</label>
                        <input id="name" type="text" name="name" placeholder="Naam" autofocus/>

                    </div>

                    <div class="form-group">

                        <label for="company">Bedrijf:</label>
                        <input id="company" type="text" name="company" placeholder="Bedrijf"/>

                    </div>

                    <div class="form-group">

                        <label for="email">E-mail adres:</label>
                        <input id="email" type="email" name="email" placeholder="E-mail adres"/>

                    </div>

                    <div class="form-group">

                        <label for="email">E-mail adres:</label>
                        <input id="email" type="email" name="email" placeholder="E-mail adres"/>

                    </div>

                    <div class="form-group">

                        <label for="phone">Telefoonnummer:</label>
                        <input id="phone" type="text" name="phone" placeholder="Telefoonnummer"/>

                    </div>

                    <div class="form-group">

                        <label for="message">Bericht:</label>
                        <textarea placeholder="Bericht" name="message" id="message"></textarea>

                    </div>

                    <button class="btn" type="button">Verzend</button>

                </form>

            </div>

            <div class="flex flex-col lg:w-4/12">

                <h3 class="text-3xl">Gegevens</h3>

                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut.
                </p>

                <ul>

                    <li><strong>T:</strong> {{ $details->mobile }}</li>
                    <li><strong>E:</strong> {{ $details->email }}</li>

                </ul>

                <ul>

                    <li><strong>Btw:</strong> {{ $details->vat }}</li>

                </ul>

                <x-social-media />

                <figure>

                    <img src="{{ asset('img/common/Image_003.png') }}" alt="001" />

                </figure>

            </div>

        </div>

    </div>

</div>
