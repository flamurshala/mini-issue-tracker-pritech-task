<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Tag;
use App\Models\User;
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
        $users = User::factory()
            ->count(5)
            ->create();

        $projects = Project::factory()
            ->count(5)
            ->state(fn () => [
                'user_id' => $users->random()->id,
            ])
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

        Issue::all()->each(function (Issue $issue) use ($tags, $users): void {
            Comment::factory()
                ->count(3)
                ->create([
                    'issue_id' => $issue->id,
                ]);

            $tagIds = $tags->random(rand(1, min(3, $tags->count())))
                ->pluck('id')
                ->toArray();

            $issue->tags()->syncWithoutDetaching($tagIds);

            $userIds = $users->random(rand(1, min(3, $users->count())))
                ->pluck('id')
                ->toArray();

            $issue->users()->syncWithoutDetaching($userIds);
        });
    }
}
