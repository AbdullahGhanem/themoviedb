<?php

namespace Ghanem\Themoviedb\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Ghanem\Themoviedb\Tests\TestCase;
use Ghanem\Themoviedb\Models\Movie;

class MovieTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  function a_post_has_a_title()
  {
    $post = Movie::factory()->create(['title' => 'Fake Title']);
    $this->assertEquals('Fake Title', $post->title);
  }
}