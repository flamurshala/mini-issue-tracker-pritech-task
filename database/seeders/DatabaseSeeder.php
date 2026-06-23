<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $projects = Project::factory()
            ->count(5)
            ->create();

        $tags = Tag::factory()
            ->count(8)
            ->create();

        $projects->each(function (Project $project): void {
            Issue::factory()
                ->count(4)
                ->create([
                    'project_id' => $project->id,
                ]);
        });

        Issue::all()->each(function (Issue $issue) use ($tags): void {
            Comment::factory()
                ->count(3)
                ->create([
                    'issue_id' => $issue->id,
                ]);

            $tagIds = $tags->random(rand(1, min(3, $tags->count())))
                ->pluck('id')
                ->toArray();

            $issue->tags()->syncWithoutDetaching($tagIds);
        });
    }
}
