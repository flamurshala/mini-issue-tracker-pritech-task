@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">Projects</h1>
        @auth
            <a href="{{ route('projects.create') }}" style="background: #2563eb; border-radius: 6px; color: #ffffff; padding: 10px 14px;">Create Project</a>
        @else
            <a href="{{ route('login') }}">Login to create projects</a>
        @endauth
    </div>

    @if ($projects->isEmpty())
        <p>No projects found.</p>
    @else
        <table class="responsive-table" style="width: 100%; border-collapse: collapse; background: #ffffff;">
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Name</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Description</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Start Date</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Deadline</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Owner</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Issues</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td data-label="Name" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->name }}</td>
                        <td data-label="Description" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->description ? \Illuminate\Support\Str::limit($project->description, 80) : 'No description' }}</td>
                        <td data-label="Start Date" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->start_date ?? 'Not set' }}</td>
                        <td data-label="Deadline" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->deadline ?? 'Not set' }}</td>
                        <td data-label="Owner" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->user?->name ?? 'No owner' }}</td>
                        <td data-label="Issues" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $project->issues_count }}</td>
                        <td data-label="Actions" style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <a href="{{ route('projects.show', $project) }}">View</a>
                                @can('update', $project)
                                    <a href="{{ route('projects.edit', $project) }}">Edit</a>
                                @endcan
                                @can('delete', $project)
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $projects->links() }}
        </div>
    @endif
@endsection
