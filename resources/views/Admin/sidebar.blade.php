<div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()">
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
            <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16 bg-white"></div>

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
                        src="https://raw.githubusercontent.com/kamona-ui/dashboard-alpine/main/public/assets/images/logo.png"
                        alt="K-UI"
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
                            src="https://avatars.githubusercontent.com/u/57622665?s=460&u=8f581f4c4acd4c18c33a87b3e6476112325e8b38&v=4"
                            alt="Ahmed Kamel"
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
                    </div>
                </div>
            </nav>

            <!-- Left mini bar -->
            <nav
                aria-label="Options"
                class="z-20 flex-col items-center flex-shrink-0 hidden w-16 py-4 bg-white border-r-2 border-emerald-100 shadow-md sm:flex rounded-tr-3xl rounded-br-3xl"
            >
                <!-- Logo -->
                <div class="flex-shrink-0 py-4">
                    <a href="#">
                        <img
                            class="w-10 h-auto"
                            src="https://raw.githubusercontent.com/kamona-ui/dashboard-alpine/main/public/assets/images/logo.png"
                            alt="K-UI"
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
                            src="https://avatars.githubusercontent.com/u/57622665?s=460&u=8f581f4c4acd4c18c33a87b3e6476112325e8b38"
                            alt="Ahmed Kamel"
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
                                src="https://raw.githubusercontent.com/kamona-ui/dashboard-alpine/main/public/assets/images/logo.png"
                                alt="K-UI"
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
                        <a href="{{ route('admin.candidate.table') }}"
                           class="flex items-center space-x-2 text-emerald-600 transition-colors rounded-lg group hover:bg-emerald-600 hover:text-white">
                                <span aria-hidden="true"
                                      class="p-2 transition-colors rounded-lg group-hover:bg-emerald-700 group-hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-6 h-6"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                      <path
                                          stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M15 12a3 3 0 100-6 3 3 0 000 6zM9 15a6 6 0 0112 0M5 12a2 2 0 100-4 2 2 0 000 4zM3 19a4 4 0 018 0M17.5 15.5l1.5 1.5m0-1.5l-1.5 1.5"
                                      />
                                    </svg>
                                </span>
                            <span>Manage Candidates</span>
                        </a>

                        <a href="{{ route('admin.candidate.users') }}"
                           class="flex items-center space-x-2 text-emerald-600 transition-colors rounded-lg group hover:bg-emerald-600 hover:text-white">
                                <span aria-hidden="true"
                                      class="p-2 transition-colors rounded-lg group-hover:bg-emerald-700 group-hover:text-white">
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
                                          d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zm6 8a4 4 0 00-3-3.87M6 11a4 4 0 00-3 3.87"
                                      />
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
