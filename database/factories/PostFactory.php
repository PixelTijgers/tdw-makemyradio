<?php

// Factory namepacing.
namespace Database\Factories;

// Facades.
use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(8);

        return [
            'administrator_id'  => \Arr::random([1,2]),
            'category_id'       => \Arr::random([1,2]),
            'slug'              => \Str::slug($title),
            'title'             => $this->faker->sentence(8),
            'intro'             => $this->faker->paragraph(20),
            'content'           => $this->faker->paragraph(20),

            'meta_title'        => $this->faker->sentence(8),
            'meta_description'  => $this->faker->paragraph(15),
            'meta_tags'         => 'Website, Webdesign, Design',

            'og_title'          => $this->faker->sentence(8),
            'og_description'    => $this->faker->paragraph(15),
            'og_url'            => \Str::slug($title),
            'og_type'           => 'website',
            'og_locale'         => 'nl_NL',

            'status'            => 'published',
            'published_at'      => $this->faker->dateTimeBetween('-3 weeks', '+2 days'),
            'unpublished_at'    => $this->faker->dateTimeBetween('+3 days', '+3 weeks'),
        ];
    }
}
