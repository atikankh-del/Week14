<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class BlogDisplayTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_only_published_articles_newest_first_with_short_content(): void
    {
        $this->withoutVite();
        $latest = Blog::factory()->create([
            'title' => 'Newest article', 'status' => 'active',
            'content' => '<p><b>'.str_repeat('เนื้อหาบทความ', 20).'</b></p>', 'created_at' => now(),
        ]);
        Blog::factory()->create([
            'title' => 'Older article', 'status' => 'active', 'created_at' => now()->subDay(),
        ]);
        Blog::factory()->create(['title' => 'Hidden draft', 'status' => 'inactive']);

        $this->get('/')->assertOk()
            ->assertSeeInOrder(['Newest article', 'Older article'])
            ->assertDontSee('Hidden draft')
            ->assertSee(Str::limit(strip_tags($latest->content), 100))
            ->assertDontSee($latest->content)
            ->assertSee(route('blogs.detail', $latest->id));
    }

    public function test_home_handles_no_published_articles(): void
    {
        $this->withoutVite();
        $this->get('/')->assertOk()->assertSee('ยังไม่มีบทความที่เผยแพร่');
    }

    public function test_detail_preserves_summernote_images_and_trusted_video_embeds(): void
    {
        $this->withoutVite();
        $image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aX1sAAAAASUVORK5CYII=';
        $video = 'https://www.youtube.com/embed/dQw4w9WgXcQ';
        $article = Blog::factory()->create([
            'status' => 'active',
            'content' => '<img src="'.$image.'"><img src="https://example.com/photo.jpg">'
                .'<iframe src="'.$video.'" width="640" height="360"></iframe>'
                .'<iframe src="//www.youtube.com/embed/xJC9b8-31Qs" width="640" height="360" class="note-video-clip"></iframe>'
                .'<iframe src="https://evil.example/video"></iframe>'
                .'<iframe src="https://www.youtube.com.evil.example/embed/test"></iframe>'
                .'<a href="https://youtu.be/dQw4w9WgXcQ">YouTube</a>',
        ]);

        $this->get(route('blogs.detail', $article->id))->assertOk()
            ->assertSee($image, false)
            ->assertSee('src="https://example.com/photo.jpg"', false)
            ->assertSee('src="'.$video.'"', false)
            ->assertSee('src="//www.youtube.com/embed/xJC9b8-31Qs"', false)
            ->assertSee('href="https://youtu.be/dQw4w9WgXcQ"', false)
            ->assertDontSee('evil.example', false);
    }

    public function test_public_detail_renders_formatted_content_safely_and_hides_drafts(): void
    {
        $this->withoutVite();
        $article = Blog::factory()->create([
            'status' => 'active', 'content' => '<script>alert("test")</script><p><b>ข้อความตัวหนา</b></p><img src="https://example.com/a.png" onerror="alert(1)">'.str_repeat('เนื้อหา', 20),
        ]);
        foreach (['blogs.detail', 'blogs.show'] as $route) {
            $this->get(route($route, $article->id))->assertOk()
                ->assertSee('<b>ข้อความตัวหนา</b>', false)
                ->assertSee(str_repeat('เนื้อหา', 20))
                ->assertDontSee('<script>alert(', false)
                ->assertDontSee('onerror=', false);
        }
        $article->update(['status' => 'inactive']);
        $this->get(route('blogs.detail', $article->id))->assertNotFound();
        $this->get('/detail/999999')->assertNotFound();
    }
}
