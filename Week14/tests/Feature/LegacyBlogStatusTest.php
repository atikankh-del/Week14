<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LegacyBlogStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_legacy_boolean_statuses_are_preserved_and_can_be_updated(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('status')->default(true)->change();
        });
        $published = DB::table('blogs')->insertGetId(['title' => 'Published', 'content' => 'Original content', 'status' => 1]);
        $draft = DB::table('blogs')->insertGetId(['title' => 'Draft', 'content' => 'Draft content', 'status' => 0]);

        (require database_path('migrations/2026_09_14_090000_normalize_blog_status.php'))->up();

        $this->assertDatabaseHas('blogs', ['id' => $published, 'status' => 'active', 'content' => 'Original content']);
        $this->assertDatabaseHas('blogs', ['id' => $draft, 'status' => 'inactive']);
        Blog::findOrFail($published)->update(['status' => 'inactive', 'content' => '<p>Edited</p>']);
        $this->assertDatabaseHas('blogs', ['id' => $published, 'status' => 'inactive', 'content' => '<p>Edited</p>']);
    }
}
