@extends('layouts.app')

@section('title', 'Issues')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">Issues</h1>
        <a href="{{ route('issues.create') }}" style="background: #2563eb; border-radius: 6px; color: #ffffff; padding: 10px 14px;">Create Issue</a>
    </div>

    @if ($issues->isEmpty())
        <p>No issues found.</p>
    @else
        <table style="width: 100%; border-collapse: collapse; background: #ffffff;">
            <thead>
                <tr>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Title</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Project</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Status</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Priority</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Due Date</th>
                    <th style="border-bottom: 1px solid #e5e7eb; padding: 12px; text-align: left;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues as $issue)
                    <tr>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->title }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->project->name }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ str_replace('_', ' ', $issue->status) }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->priority }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">{{ $issue->due_date ?? 'No due date' }}</td>
                        <td style="border-bottom: 1px solid #e5e7eb; padding: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <a href="{{ route('issues.show', $issue) }}">View</a>
                                <a href="{{ route('issues.edit', $issue) }}">Edit</a>
                                <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: 0; color: #dc2626; cursor: pointer; padding: 0;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            {{ $issues->links() }}
        </div>
    @endif
@endsection
