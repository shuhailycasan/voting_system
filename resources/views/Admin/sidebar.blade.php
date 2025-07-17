<div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()" class="">
    <div class="flex h-screen antialiased text-gray-900 bg-white dark:bg-dark dark:text-light">
        <!-- Loading screen -->
        <div
            x-ref="loading"
            class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-emerald-800"
        >
            Loading.....
        </div>

        <!-- Sidebar -->
        <div class="flex flex-shrink-0 transition-all">
            <div
                x-show="isSidebarOpen"
                @click="isSidebarOpen = false"
                class="fixed inset-0 z-10 backdrop-blur-sm  lg:hidden"
            ></div>
            <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16 bg-white lg:hidden"></div>

            <!-- Mobile bottom bar -->
            <nav
                aria-label="Options"
                class="fixed inset-x-0 bottom-0 flex flex-row-reverse items-center justify-between px-4 py-2 bg-white border-t border-emerald-100 sm:hidden shadow-t rounded-t-3xl"
            >
                <!-- Menu button -->
                <button
                    @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                    class="p-2 transition-colors rounded-lg shadow-md hover:bg-emerald-800 hover:text-white focus:outline-none focus:ring focus:ring-emerald-600 focus:ring-offset-white focus:ring-offset-2"
                    :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-emerald-600' : 'text-gray-500 bg-white'"
                >
                    <span class="sr-only">Toggle sidebar</span>
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h7"/>
                    </svg>
                </button>

                <!-- Logo -->
                <a href="#">
                    <img
                        class="w-10 h-auto"
                        src="https://img.freepik.com/premium-vector/s-c-sc-cs-initial-logo-design-vector-graphic-idea-creative-green-color_388320-1311.jpg"
                        alt="SC"
                    />
                </a>

                <!-- User avatar button -->
                <div class="relative flex items-center flex-shrink-0 p-2" x-data="{ isOpen: false }">
                    <button
                        @click="isOpen = !isOpen; $nextTick(() => {isOpen ? $refs.userMenu.focus() : null})"
                        class="transition-opacity rounded-lg opacity-80 hover:opacity-100 focus:outline-none focus:ring focus:ring-emerald-600 focus:ring-offset-white focus:ring-offset-2"
                    >
                        <img
                            class="w-8 h-8 rounded-lg shadow-md"
                            src="https://avatars.githubusercontent.com/u/61223017?v=4"
                            alt="Shuhaily Casan"
                        />
                        <span class="sr-only">User menu</span>
                    </button>
                    <div
                        x-show="isOpen"
                        @click.away="isOpen = false"
                        @keydown.escape="isOpen = false"
                        x-ref="userMenu"
                        tabindex="-1"
                        class="absolute w-48 py-1 mt-2 origin-bottom-left bg-white rounded-md shadow-lg left-10 bottom-14 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-label="user menu"
                    >
                        <a href="{{ route('admin.logout') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</a>
                        <a href="{{ route('admin.logout') }}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">User Logs</a>
                    </div>
                </div>
            </nav>

            <!-- Left mini bar -->
            <nav
                aria-label="Options"
                class="z-20 flex-col items-center flex-shrink-0 hidden w-16 py-4 bg-white border-r-2 border-emerald-100 shadow-md md:flex rounded-tr-3xl rounded-br-3xl"
            >

            <!-- Logo -->
                <div class="flex-shrink-0 py-4">
                    <a href="#">
                        <img
                            class="w-10 h-auto"
                            src="https://img.freepik.com/premium-vector/s-c-sc-cs-initial-logo-design-vector-graphic-idea-creative-green-color_388320-1311.jpg"
                            alt="SC"
                        />
                    </a>
                </div>
                <div class="flex flex-col items-center flex-1 p-2 space-y-4">
                    <!-- Menu button -->
                    <button
                        @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'"
                        class="p-2 transition-colors rounded-lg shadow-md hover:bg-emerald-800 hover:text-white focus:outline-none focus:ring focus:ring-emerald-600 focus:ring-offset-white focus:ring-offset-2"
                        :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-emerald-600' : 'text-gray-500 bg-white'"
                    >
                        <span class="sr-only">Toggle sidebar</span>
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h7"/>
                        </svg>
                    </button>
                </div>

                <!-- User avatar -->
                <div class="relative flex items-center flex-shrink-0 p-2" x-data="{ isOpen: false }">
                    <button
                        @click="isOpen = !isOpen; $nextTick(() => {isOpen ? $refs.userMenu.focus() : null})"
                        class="transition-opacity rounded-lg opacity-80 hover:opacity-100 focus:outline-none focus:ring focus:ring-emerald-600 focus:ring-offset-white focus:ring-offset-2"
                    >
                        <img
                            class="w-10 h-10 rounded-lg shadow-md"
                            src="https://avatars.githubusercontent.com/u/61223017?v=4"
                            alt="Shuhaily Casan"
                        />
                        <span class="sr-only">User menu</span>
                    </button>
                    <div
                        x-show="isOpen"
                        @click.away="isOpen = false"
                        @keydown.escape="isOpen = false"
                        x-ref="userMenu"
                        tabindex="-1"
                        class="absolute w-48 py-1 mt-2 origin-bottom-left bg-white rounded-md shadow-lg left-10 bottom-14 focus:outline-none"
                        role="menu"
                        aria-orientation="vertical"
                        aria-label="user menu"
                    >

                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Sign out
                            </button>
                            <a href="{{ route('admin.logs.index') }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Logs</a>
                        </form>
                    </div>
                </div>
            </nav>

            <div
                x-transition:enter="transform transition-transform duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition-transform duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                x-show="isSidebarOpen"
                class="fixed inset-y-0 left-0 z-10 flex-shrink-0 w-64 bg-white border-r-2 border-emerald-100 shadow-lg sm:left-16 rounded-tr-3xl rounded-br-3xl sm:w-72 lg:static lg:w-64"
            >
                <nav x-show="currentSidebarTab == 'linksTab'" aria-label="Main" class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-center flex-shrink-0 py-10">
                        <a href="#">
                            <!-- <svg
                              class="text-emerald-600"
                              width="96"
                              height="53"
                              fill="currentColor"
                              xmlns="http://www.w3.org/2000/svg"
                            >
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M7.691 34.703L13.95 28.2 32.09 52h8.087L18.449 23.418 38.594.813h-8.157L7.692 26.125V.812H.941V52h6.75V34.703zm27.61-7.793h17.156v-5.308H35.301v5.308zM89.19 13v22.512c0 3.703-1.02 6.574-3.058 8.613-2.016 2.04-4.934 3.059-8.754 3.059-3.773 0-6.68-1.02-8.719-3.059-2.039-2.063-3.058-4.945-3.058-8.648V.813h-6.68v34.874c.047 5.297 1.734 9.458 5.062 12.481 3.328 3.023 7.793 4.535 13.395 4.535l1.793-.07c5.156-.375 9.234-2.098 12.234-5.168 3.024-3.07 4.547-7.02 4.57-11.848V13h-6.785zM89 8h7V1h-7v7z"
                              />
                            </svg> -->
                            <img
                                class="w-24 h-auto"
                                src="https://img.freepik.com/premium-vector/s-c-sc-cs-initial-logo-design-vector-graphic-idea-creative-green-color_388320-1311.jpg"
                                alt="SC"
                            />
                        </a>
                    </div>

                    <!-- Links -->
                    <div class="flex-1 px-4 space-y-2 overflow-hidden hover:overflow-auto">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center w-full space-x-2 text-white bg-emerald-600 rounded-lg">
                                <span aria-hidden="true" class="p-2 bg-emerald-700 rounded-lg">
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                      <path
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                                      />
                                    </svg>
                                </span>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.rankings') }}"
                           class="flex items-center space-x-2 text-emerald-600 transition-colors rounded-lg group hover:bg-emerald-600 hover:text-white">
                            <span aria-hidden="true"
                                  class="p-2 transition-colors rounded-lg group-hover:bg-emerald-700 group-hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                    </svg>


                            </span>
                            <span>Official Rankings</span>
                        </a>

                        <a href="{{ route('admin.candidate.table') }}"
                           class="flex items-center space-x-2 text-emerald-600 transition-colors rounded-lg group hover:bg-emerald-600 hover:text-white">
                                <span aria-hidden="true"
                                      class="p-2 transition-colors rounded-lg group-hover:bg-emerald-700 group-hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>

                                </span>
                            <span>Manage Candidates</span>
                        </a>

                        <a href="{{ route('admin.candidate.users') }}"
                           class="flex items-center space-x-2 text-emerald-600 transition-colors rounded-lg group hover:bg-emerald-600 hover:text-white">
                                <span aria-hidden="true"
                                      class="p-2 transition-colors rounded-lg group-hover:bg-emerald-700 group-hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                      <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </span>
                            <span>Manage users</span>
                        </a>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>


<script>
    const setup = () => {
        return {
            isSidebarOpen: false,
            currentSidebarTab: null,
            isSettingsPanelOpen: false,
            isSubHeaderOpen: false,
            watchScreen() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false
                }
            }
        }
    }
</script>
