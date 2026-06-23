@if ($issues->isEmpty())
    <p>No issues found.</p>
@else
    <div class="table-wrap">
        <table class="data-table issues-table responsive-table">
            <thead>
                <tr>
                    <th class="col-title">Title</th>
                    <th class="col-project">Project</th>
                    <th class="col-status">Status</th>
                    <th class="col-priority">Priority</th>
                    <th class="col-due-date">Due Date</th>
                    <th class="col-tags">Tags</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($issues as $issue)
                    <tr>
                        <td data-label="Title">{{ $issue->title }}</td>
                        <td data-label="Project">{{ $issue->project->name }}</td>
                        <td data-label="Status" class="cell-compact">
                            <span class="status-badge">{{ ucwords(str_replace('_', ' ', $issue->status)) }}</span>
                        </td>
                        <td data-label="Priority" class="cell-compact">
                            <span class="priority-badge">{{ ucfirst($issue->priority) }}</span>
                        </td>
                        <td data-label="Due Date" class="cell-compact">{{ $issue->due_date ?? 'No due date' }}</td>
                        <td data-label="Tags">
                            @if ($issue->tags->isEmpty())
                                <span style="color: #6b7280;">No tags</span>
                            @else
                                <div class="issue-tags">
                                    @foreach ($issue->tags as $tag)
                                        <span class="tag-badge">
                                            @if ($tag->color)
                                                <span class="tag-dot" style="background: {{ $tag->color }};"></span>
                                            @endif
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td data-label="Actions" class="cell-compact">
                            <div class="issue-actions">
                                <a href="{{ route('issues.show', $issue) }}">View</a>
                                <a href="{{ route('issues.edit', $issue) }}">Edit</a>
                                <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 20px;">
        {{ $issues->links() }}
    </div>
@endif
