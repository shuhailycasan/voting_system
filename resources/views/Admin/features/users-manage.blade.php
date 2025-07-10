@extends('Admin.dashboard')


@section('content')
<div class="p-4 flex justify-center border border-emerald-400 sm:ml-64 min-h-screen">
    <div class="w-full max-w-4xl p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="  mb-4 rounded-sm bg-gray-50 dark:bg-gray-800 p-4">

            <div class="flex flex-col lg:flex justify-between items-center pb-2">
                <div class="text-center font-bold text-2xl flex justify-center">
                    <h1>List of All Users</h1>
                </div>

                <form action="{{ route('admin.candidate.table') }}" method="GET" class="flex">
                    @csrf
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search name or position..."
                           class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2
                               focus:ring-emerald-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" />


                    <button type="submit"
                            class="bg-emerald-600 text-white px-4 rounded-r-md hover:bg-emerald-700">
                        Search
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Voter Codes</th>
                        <th scope="col" class="px-6 py-3">Has Voted?</th>
                        <th scope="col" class="px-6 py-3">Time Voted</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($usersAll as $userAll)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $userAll->code }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                @if ($userAll->voted)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">Yes</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                {{ $userAll->voted_at }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $userAll->role }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">No voters found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $usersAll->appends(['search' => request('search')])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
