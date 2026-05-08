@php
    /** @var list<string> $columns */
    /** @var list<list<string>> $rows */
@endphp

<div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
    <table class="min-w-full divide-y divide-gray-200 text-sm dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
                @foreach ($columns as $column)
                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wide text-gray-700 dark:text-gray-200">{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
            @foreach ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td class="px-3 py-2 align-top text-gray-800 dark:text-gray-200">{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
