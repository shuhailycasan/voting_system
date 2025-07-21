@extends('Admin.dashboard')

@section('content')
    <div class="px-4 py-6">
        <div class="bg-white rounded-lg max-w-full overflow-x-auto lg:max-w-[1200px] lg:mx-auto">
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                <div class="py-6">
                    <h1 class="text-3xl font-semibold text-center text-gray-800 dark:text-white border-b-4 border-emerald-500 inline-block px-4 pb-2">
                        Activity Logs
                    </h1>
                </div>

                <div class="px-4 pb-4">
                    <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-wrap gap-3 mb-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search log name or description"
                               class="border p-2 rounded text-sm"/>

                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="border p-2 rounded text-sm"/>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="border p-2 rounded text-sm"/>

                        <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">Filter</button>
                        <a href="logs" class="bg-gray-300 text-black px-4 py-2 rounded">Reset</a>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 text-sm md:text-base">
                        <thead>
                        <tr class="bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">
                            <th class="p-3 text-left whitespace-nowrap">Date</th>
                            <th class="p-3 text-left whitespace-nowrap">Role</th>
                            <th class="p-3 text-left whitespace-nowrap">Action</th>
                            <th class="p-3 text-left whitespace-nowrap">Subject</th>
                            <th class="p-3 text-left whitespace-nowrap">Details</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-200">
                        @forelse ($logs as $log)
                            <tr class="border-b border-gray-200 dark:border-gray-600 text-sm">
                                <td class="p-3">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-3">{{ $log->causer->role ?? 'N/A' }}</td>
                                <td class="p-3 capitalize">{{ $log->description }}</td>
                                <td class="p-3">{{ class_basename($log->subject_type) }}</td>
                                <td class="p-3 text-xs">
                                    @foreach($log->properties->toArray() as $key => $value)
                                        <div>
                                            <strong>{{ ucfirst($key) }}:</strong>
                                            {{ is_array($value) ? json_encode($value) : $value }}
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500"> No logs available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 px-4 pb-4">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
