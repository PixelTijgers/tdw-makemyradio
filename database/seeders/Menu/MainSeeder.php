<?php

// Namespacing.
namespace Database\Seeders\Menu;

// Facades.
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models.
use App\Models\Page;

// Enums
use App\Enums\PublishedState;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'page_title' => 'Home',
                'menu_title' => 'Home',
                'slug' => '/',
                'content' => '<p>Dit is een zin, volgens wijsneus Naomi.</p>',

                'meta_title' => 'Home',
                'meta_description' => 'Dit is een stuk tekst.',
                'meta_tags' => 'Website, Webdesign, Design',

                'og_title' => 'Home',
                'og_description' => 'Dit is een stuk tekst.',
                'og_slug' => '/',
                'og_type' => 'website',
                'og_locale' => 'nl_NL',
            ],
            [
                'page_title' => 'Expertises',
                'menu_title' => 'Expertises',
                'slug' => '/expertises',
                'content' => '<p>Dit is een stuk tekst.</p>',

                'meta_title' => 'Expertises',
                'meta_description' => 'Dit is een stuk tekst.',
                'meta_tags' => 'Website, Webdesign, Design',

                'og_title' => 'Expertises',
                'og_description' => 'Dit is een stuk tekst.',
                'og_slug' => '/expertises',
                'og_type' => 'website',
                'og_locale' => 'nl_NL',
            ],
            [
                'page_title' => 'Over Pixeltijgers',
                'menu_title' => 'Over Pixeltijgers',
                'slug' => '/over-pixeltijgers',
                'content' => '<p>Dit is een stuk tekst.</p>',

                'meta_title' => 'Over Pixeltijgers',
                'meta_description' => 'Dit is een stuk tekst.',
                'meta_tags' => 'Website, Webdesign, Design',

                'og_title' => 'Over Pixeltijgers',
                'og_description' => 'Dit is een stuk tekst.',
                'og_slug' => '/over-pixeltijgers',
                'og_type' => 'website',
                'og_locale' => 'nl_NL',
            ],
            [
                'page_title' => 'Contact',
                'menu_title' => 'Contact',
                'slug' => '/contact',
                'content' => '<p>Dit is een stuk tekst.</p>',

                'meta_title' => 'Contact',
                'meta_description' => 'Dit is een stuk tekst.',
                'meta_tags' => 'Website, Webdesign, Design',

                'og_title' => 'Contact',
                'og_description' => 'Dit is een stuk tekst.',
                'og_slug' => '/contact',
                'og_type' => 'website',
                'og_locale' => 'nl_NL',
            ],
        ];

        foreach($pages as $page) {

            // Create page in the database.
            $createPage = Page::create([
                    'status' => PublishedState::Published,
                    'published_at' => now(),

                    'last_edited_administrator_id' => 1,
                    'last_edit_at' => now(),
                ] + $page);

            // Sync with the navigation menu.
            $createPage->navigation_menus()->sync([2]);

        }
    }
}
