@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">{{ $project->name }}</h1>
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="{{ route('projects.index') }}">Back to Projects</a>
            <a href="{{ route('issues.create') }}">Create Issue</a>
            <a href="{{ route('projects.edit', $project) }}">Edit Project</a>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Delete Project</button>
            </form>
        </div>
    </div>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; margin-bottom: 20px; padding: 20px;">
        <p><strong>Description:</strong></p>
        <p>{{ $project->description ?? 'No description provided.' }}</p>
        <p><strong>Start Date:</strong> {{ $project->start_date ?? 'Not set' }}</p>
        <p><strong>Deadline:</strong> {{ $project->deadline ?? 'Not set' }}</p>
        <p><strong>Created:</strong> {{ $project->created_at?->format('Y-m-d') }}</p>
    </section>

    <section style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px; padding: 20px;">
        <h2 style="margin-top: 0;">Related Issues</h2>

        @if ($project->issues->isEmpty())
            <p>No issues found for this project.</p>
        @else
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Title</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Status</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Priority</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Due Date</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Tags</th>
                        <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($project->issues as $issue)
                        <tr>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->title }}</td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ str_replace('_', ' ', $issue->status) }}</td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->priority }}</td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->due_date ?? 'No due date' }}</td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                                @if ($issue->tags->isEmpty())
                                    No tags
                                @else
                                    {{ $issue->tags->pluck('name')->join(', ') }}
                                @endif
                            </td>
                            <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                                <a href="{{ route('issues.show', $issue) }}">View Issue</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
