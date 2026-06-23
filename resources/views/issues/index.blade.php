@extends('layouts.app')

@section('title', 'Issues')

@section('content')
    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px;">
        <h1 style="margin: 0;">Issues</h1>
        <a href="{{ route('issues.create') }}" class="button-primary">Create Issue</a>
    </div>

    <form id="issues-filter-form" action="{{ route('issues.index') }}" method="GET" class="toolbar-card">
        <div>
            <label for="issue-search">Search</label>
            <input
                id="issue-search"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search title or description"
                class="form-control"
            >
        </div>

        <div>
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">All statuses</option>
                <option value="open" @selected(request('status') === 'open')>Open</option>
                <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                <option value="closed" @selected(request('status') === 'closed')>Closed</option>
            </select>
        </div>

        <div>
            <label for="priority">Priority</label>
            <select id="priority" name="priority" class="form-control">
                <option value="">All priorities</option>
                <option value="low" @selected(request('priority') === 'low')>Low</option>
                <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                <option value="high" @selected(request('priority') === 'high')>High</option>
            </select>
        </div>

        <div>
            <label for="tag">Tag</label>
            <select id="tag" name="tag" class="form-control">
                <option value="">All tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected((string) request('tag') === (string) $tag->id)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; min-height: 42px;">
            <button type="submit" class="button-primary">Filter</button>
            <a href="{{ route('issues.index') }}" style="align-self: center;">Clear</a>
        </div>
    </form>

    <div id="issues-search-message" aria-live="polite" style="margin-bottom: 16px;"></div>

    <div id="issues-results">
        @include('issues.partials.table', ['issues' => $issues])
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('issues-filter-form');
            const searchInput = document.getElementById('issue-search');
            const resultsContainer = document.getElementById('issues-results');
            const messageContainer = document.getElementById('issues-search-message');
            let debounceTimer = null;

            function buildUrl(pageUrl = null) {
                const formData = new FormData(filterForm);
                const params = new URLSearchParams();

                for (const [key, value] of formData.entries()) {
                    if (value) {
                        params.append(key, value);
                    }
                }

                if (pageUrl) {
                    const url = new URL(pageUrl, window.location.origin);

                    url.search = '';
                    for (const [key, value] of params.entries()) {
                        url.searchParams.append(key, value);
                    }

                    if (new URL(pageUrl, window.location.origin).searchParams.has('page')) {
                        url.searchParams.set('page', new URL(pageUrl, window.location.origin).searchParams.get('page'));
                    }

                    return url.toString();
                }

                const query = params.toString();

                return query ? `${filterForm.action}?${query}` : filterForm.action;
            }

            async function fetchIssues(url = null) {
                const requestUrl = url || buildUrl();
                messageContainer.textContent = 'Searching...';

                try {
                    const response = await fetch(requestUrl, {
                        method: 'GET',
                        headers: {
                            'Accept': 'text/html',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });

                    if (!response.ok) {
                        messageContainer.textContent = 'Could not load issues.';
                        return;
                    }

                    resultsContainer.innerHTML = await response.text();
                    messageContainer.textContent = '';
                    window.history.replaceState({}, '', requestUrl);
                    bindPaginationLinks();
                } catch (error) {
                    messageContainer.textContent = 'Search request failed.';
                }
            }

            function debounceSearch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    fetchIssues();
                }, 400);
            }

            function bindPaginationLinks() {
                resultsContainer.querySelectorAll('nav a').forEach(function (link) {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        fetchIssues(link.href);
                    });
                });
            }

            searchInput.addEventListener('input', debounceSearch);

            filterForm.querySelectorAll('select').forEach(function (select) {
                select.addEventListener('change', function () {
                    fetchIssues();
                });
            });

            filterForm.addEventListener('submit', function (event) {
                event.preventDefault();
                fetchIssues();
            });

            bindPaginationLinks();
        });
    </script>
@endsection
