<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_author_can_create_and_update_an_article_using_prefixed_routes(): void
    {
        $this->withoutVite();
        $this->actingAs(User::factory()->create());

        $this->get('/home')->assertOk()
            ->assertSee('href="/author/create"', false)
            ->assertSee('href="/author/blog"', false);

        $this->get('/author/create')->assertOk()
            ->assertSee('action="/author/insert"', false)
            ->assertSee('href="/author/blog"', false);

        $this->post('/author/insert', [
            'title' => 'First article',
            'content' => 'Article content',
            'status' => 'active',
        ])->assertRedirect('/author/blog');

        $this->assertDatabaseHas('blogs', ['title' => 'First article']);
        $article = Blog::where('title', 'First article')->firstOrFail();
        $id = $article->id;
        $this->assertNotNull($article->created_at);
        $this->assertNotNull($article->updated_at);

        $this->get('/author/edit/'.$id)->assertOk()
            ->assertSee('/author/update/'.$id, false)
            ->assertSee('href="/author/blog"', false);

        $this->put('/author/update/'.$id, [
            'title' => 'Updated article',
            'content' => 'Updated content',
            'status' => 'inactive',
        ])->assertRedirect('/author/blog');

        $this->assertDatabaseHas('blogs', [
            'id' => $id,
            'title' => 'Updated article',
            'content' => 'Updated content',
            'status' => 'inactive',
        ]);

        $this->get('/author/blog')->assertOk()->assertSee('Updated article');
    }

    public function test_author_can_toggle_status_and_delete_an_article(): void
    {
        $this->actingAs(User::factory()->create());
        $article = Blog::create([
            'title' => 'Status test',
            'content' => 'Article content',
            'status' => 'active',
        ]);

        $this->deleteJson('/author/chang/'.$article->id)
            ->assertOk()->assertExactJson(['success' => true, 'status' => 'inactive']);
        $this->assertSame('inactive', $article->fresh()->status);

        $this->delete('/author/chang/'.$article->id)->assertRedirect('/author/blog');
        $this->assertSame('active', $article->fresh()->status);

        $this->from('/author/blog')->delete('/author/delete/'.$article->id)
            ->assertRedirect('/author/blog');
        $this->assertModelMissing($article);
    }

    public function test_mass_assignment_does_not_overwrite_article_id(): void
    {
        $article = Blog::create([
            'id' => 98765,
            'title' => 'Allowed title',
            'content' => 'Allowed content',
            'status' => 'active',
        ]);

        $this->assertNotEquals(98765, $article->id);
        $originalId = $article->id;
        $article->update(['id' => 98765, 'title' => 'Changed title']);

        $this->assertSame($originalId, $article->fresh()->id);
        $this->assertSame('Changed title', $article->fresh()->title);
    }

    public function test_invalid_status_is_rejected_without_saving(): void
    {
        $this->actingAs(User::factory()->create());
        $this->postJson('/author/insert', [
            'title' => 'Invalid article',
            'content' => 'Article content',
            'status' => 'unexpected',
        ])->assertUnprocessable()->assertJsonValidationErrors('status');

        $this->assertDatabaseCount('blogs', 0);
    }

    public function test_missing_articles_return_not_found(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/author/edit/999')->assertNotFound();
        $this->put('/author/update/999', [
            'title' => 'Missing article',
            'content' => 'Article content',
            'status' => 'active',
        ])->assertNotFound();
        $this->delete('/author/chang/999')->assertNotFound();
        $this->delete('/author/delete/999')->assertNotFound();
    }
}
