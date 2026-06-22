@extends('layouts.app')

@section('title', 'Edit Issue')

@section('content')
    <h1>Edit Issue</h1>

    <form action="{{ route('issues.update', $issue) }}" method="POST" style="display: grid; gap: 16px; max-width: 700px;">
        @csrf
        @method('PUT')

        <div>
            <label for="project_id">Project</label>
            <select id="project_id" name="project_id" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('project_id', $issue->project_id) == $project->id)>
                        {{ $project->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="title">Title</label>
            <input id="title" type="text" name="title" value="{{ old('title', $issue->title) }}" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">{{ old('description', $issue->description) }}</textarea>
        </div>

        <div>
            <label for="status">Status</label>
            <select id="status" name="status" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                @foreach (['open' => 'Open', 'in_progress' => 'In Progress', 'closed' => 'Closed'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $issue->status) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority" required style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
                @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('priority', $issue->priority) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="due_date">Due Date</label>
            <input id="due_date" type="date" name="due_date" value="{{ old('due_date', $issue->due_date) }}" style="display: block; margin-top: 6px; width: 100%; padding: 10px;">
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" style="background: #2563eb; border: 0; border-radius: 6px; color: #ffffff; cursor: pointer; padding: 10px 14px;">Update Issue</button>
            <a href="{{ route('issues.show', $issue) }}">Cancel</a>
        </div>
    </form>
@endsection
