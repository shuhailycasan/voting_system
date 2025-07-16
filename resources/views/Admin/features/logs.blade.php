@extends('Admin.dashboard')

@section('content')
    <div class="mx-55 min-h-screen">
        <div class="border-2 border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-4">Activity Logs</h2>

            <table class="min-w-full bg-white dark:bg-gray-800 shadow-md rounded">
                <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm">
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">User</th>
                    <th class="p-3 text-left">Action</th>
                    <th class="p-3 text-left">Details</th>
                </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200">
                @forelse ($logs as $log)
                    <tr class="border-b border-gray-200 dark:border-gray-600">
                        <td class="p-3">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        <td class="p-3">
                            {{ $log->causer ? $log->causer->name : 'System' }}
                        </td>
                        <td class="p-3">{{ $log->description }}</td>
                        <td class="p-3 text-sm">
                            @foreach ($log->properties->toArray() as $key => $value)
                                <div>
                                    <strong>{{ $key }}:</strong>
                                    <pre class="text-xs">{{ print_r($value, true) }}</pre>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">No logs available</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
