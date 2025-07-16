@extends('Admin.dashboard')

@section('content')
    <div class="px-4 py-6 border border-emerald-400">
        <div class="max-w-full overflow-x-auto lg:max-w-[1200px] lg:mx-auto">
            <div class="border-2 border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                <h2 class="text-xl md:text-2xl font-bold mb-4 px-4 pt-4">Activity Logs</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 text-sm md:text-base">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="p-3 text-left whitespace-nowrap">Date</th>
                            <th class="p-3 text-left whitespace-nowrap">User</th>
                            <th class="p-3 text-left whitespace-nowrap">Action</th>
                            <th class="p-3 text-left whitespace-nowrap">Details</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-700 dark:text-gray-200">
                        @forelse ($logs as $log)
                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                <td class="p-3 whitespace-nowrap">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-3 whitespace-nowrap">
                                    {{ $log->causer ? $log->causer->name : 'System' }}
                                </td>
                                <td class="p-3 whitespace-nowrap">{{ $log->description }}</td>
                                <td class="p-3 text-xs md:text-sm">
                                    @foreach ($log->properties->toArray() as $key => $value)
                                        <div class="mb-2">
                                            <strong>{{ $key }}:</strong>
                                            <pre class="bg-gray-100 dark:bg-gray-900 p-2 rounded overflow-x-auto max-w-full">{{ print_r($value, true) }}</pre>
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
                </div>

                <div class="mt-4 px-4 pb-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
