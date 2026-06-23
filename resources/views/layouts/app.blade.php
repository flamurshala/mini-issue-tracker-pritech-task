<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mini Issue Tracker')</title>
    <style>
        body {
            margin: 0;
            background: #f6f7f9;
            color: #1f2937;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }

        .alert {
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 14px 16px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #166534;
        }

        nav[role="navigation"] {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        nav[role="navigation"] svg {
            height: 20px;
            width: 20px;
        }

        nav[role="navigation"] .hidden {
            display: none;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span {
            align-items: center;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            display: inline-flex;
            justify-content: center;
            min-height: 32px;
            min-width: 32px;
            padding: 6px 10px;
            text-decoration: none;
        }

        nav[role="navigation"] span[aria-current="page"] span {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }

        .toolbar-card {
            align-items: end;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            display: grid;
            gap: 18px;
            grid-template-columns: minmax(240px, 2fr) repeat(3, minmax(150px, 1fr)) auto;
            margin-bottom: 20px;
            padding: 18px;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 5px;
            box-sizing: border-box;
            display: block;
            height: 42px;
            margin-top: 6px;
            padding: 9px 11px;
            width: 100%;
        }

        .button-primary {
            background: #2563eb;
            border: 0;
            border-radius: 6px;
            color: #ffffff;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 14px;
            text-decoration: none;
            white-space: nowrap;
        }

        .button-danger {
            background: none;
            border: 0;
            color: #dc2626;
            cursor: pointer;
            padding: 0;
        }

        .table-wrap {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .data-table {
            border-collapse: collapse;
            width: 100%;
        }

        .data-table th {
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            color: #4b5563;
            font-size: 13px;
            padding: 12px 14px;
            text-align: left;
            white-space: nowrap;
        }

        .data-table td {
            border-bottom: 1px solid #e5e7eb;
            padding: 14px;
            vertical-align: top;
        }

        .data-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .column-title {
            min-width: 220px;
        }

        .column-project {
            min-width: 180px;
        }

        .column-tags {
            min-width: 180px;
        }

        .column-nowrap {
            white-space: nowrap;
        }

        .badge-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag-badge,
        .status-badge,
        .priority-badge {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: 12px;
            line-height: 1;
            padding: 6px 9px;
            white-space: nowrap;
        }

        .tag-badge {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .tag-dot {
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 999px;
            display: inline-block;
            height: 10px;
            margin-right: 6px;
            width: 10px;
        }

        .status-badge {
            background: #eef2ff;
            color: #3730a3;
        }

        .priority-badge {
            background: #ecfdf5;
            color: #166534;
        }

        .actions-inline {
            align-items: center;
            display: flex;
            gap: 14px;
            white-space: nowrap;
        }

        .issues-table {
            table-layout: fixed;
        }

        .issues-table .col-title {
            width: 22%;
        }

        .issues-table .col-project {
            width: 17%;
        }

        .issues-table .col-status {
            width: 10%;
        }

        .issues-table .col-priority {
            width: 10%;
        }

        .issues-table .col-due-date {
            width: 12%;
        }

        .issues-table .col-tags {
            width: 18%;
        }

        .issues-table .col-actions {
            width: 11%;
        }

        .issues-table td {
            overflow-wrap: anywhere;
            word-break: normal;
        }

        .issues-table .cell-compact {
            overflow-wrap: normal;
            white-space: normal;
        }

        .issues-table .status-badge,
        .issues-table .priority-badge,
        .issues-table .tag-badge {
            font-size: 11px;
            padding: 5px 7px;
        }

        .issue-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            min-width: 0;
        }

        .issue-actions {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .issue-actions a,
        .issue-actions button {
            font-size: 13px;
        }

        .remember-row {
            margin-bottom: 16px;
            margin-top: 16px;
        }

        .remember-label {
            align-items: center;
            cursor: pointer;
            display: inline-flex;
            gap: 8px;
        }

        .remember-label input[type="checkbox"] {
            flex: 0 0 auto;
            height: auto;
            margin: 0;
            width: auto;
        }

        @media (max-width: 900px) {
            .toolbar-card {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;
            }
        }

        @media (max-width: 1024px) {
            .container {
                padding-left: 20px;
                padding-right: 20px;
            }

            nav > .container {
                flex-wrap: wrap;
                row-gap: 12px;
            }

            nav > .container > div {
                margin-left: 0 !important;
            }

            .toolbar-card {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            input:not([type="checkbox"]):not([type="radio"]),
            select,
            textarea {
                box-sizing: border-box;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            * {
                box-sizing: border-box;
            }

            html,
            body {
                max-width: 100%;
                overflow-x: hidden;
            }

            img,
            svg {
                max-width: 100%;
            }

            .container {
                padding: 16px;
            }

            nav > .container {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 10px !important;
                padding-bottom: 14px !important;
                padding-top: 14px !important;
            }

            nav > .container > div {
                align-items: flex-start !important;
                flex-wrap: wrap;
                gap: 10px !important;
                width: 100%;
            }

            main.container > div[style*="justify-content: space-between"] {
                align-items: flex-start !important;
                flex-direction: column;
            }

            main.container > div[style*="justify-content: space-between"] > div {
                align-items: flex-start !important;
                flex-wrap: wrap;
            }

            .toolbar-card {
                grid-template-columns: 1fr;
                gap: 14px;
                padding: 14px;
            }

            .toolbar-card > div:last-child {
                align-items: stretch !important;
                flex-direction: column;
                width: 100%;
            }

            .button-primary,
            button[type="submit"] {
                min-height: 44px;
            }

            form[style*="max-width"] {
                max-width: none !important;
                width: 100%;
            }

            form > div[style*="display: flex"] {
                align-items: flex-start !important;
                flex-wrap: wrap;
            }

            input:not([type="checkbox"]):not([type="radio"]),
            select,
            textarea {
                font-size: 16px;
                width: 100% !important;
            }

            section {
                padding: 16px !important;
            }

            #attach-tag-form,
            #assign-user-form {
                flex-direction: column;
                max-width: none !important;
            }

            #attach-tag-form button,
            #assign-user-form button,
            #comment-form button {
                width: 100%;
            }

            #attached-tags li,
            .assigned-user-item {
                align-items: flex-start !important;
                flex-direction: column;
            }

            #comments-pagination button {
                min-height: 40px;
            }

            .table-wrap {
                border: 0;
                overflow: visible;
            }

            .responsive-table {
                display: block;
            }

            .responsive-table thead {
                display: none;
            }

            .responsive-table tbody,
            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }

            .responsive-table tr {
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                margin-bottom: 12px;
                padding: 12px;
            }

            .responsive-table td {
                border-bottom: 0 !important;
                padding: 7px 0 !important;
                overflow-wrap: anywhere;
            }

            .responsive-table td::before {
                color: #6b7280;
                content: attr(data-label);
                display: block;
                font-size: 12px;
                font-weight: 700;
                margin-bottom: 3px;
                text-transform: uppercase;
            }

            .issues-table {
                table-layout: auto;
            }

            .issues-table .col-title,
            .issues-table .col-project,
            .issues-table .col-status,
            .issues-table .col-priority,
            .issues-table .col-due-date,
            .issues-table .col-tags,
            .issues-table .col-actions {
                width: auto;
            }

            .issue-actions,
            .actions-inline {
                flex-wrap: wrap;
                gap: 12px;
            }

            .issue-tags,
            .badge-list {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 430px) {
            .container {
                padding: 14px;
            }

            h1 {
                font-size: 26px;
                line-height: 1.2;
            }
        }
    </style>
</head>
<body>
    @include('partials.navbar')

    <main class="container">
        @include('partials.errors')

        @yield('content')
    </main>
</body>
</html>
