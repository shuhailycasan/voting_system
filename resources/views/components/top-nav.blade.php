<nav class="bg-white border-b border-emerald-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-xl mx-auto flex flex-wrap items-center justify-between p-4">
        <!-- Logo & Title -->
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img  src="https://img.freepik.com/premium-vector/s-c-sc-cs-initial-logo-design-vector-graphic-idea-creative-green-color_388320-1311.jpg"
                  class="h-8" alt="Logo" />
            <span class="self-center text-2xl font-bold text-emerald-700 whitespace-nowrap">Voting System</span>
        </a>

        <!-- Hamburger Button -->
        <button data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-300"
                aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Nav Links -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
                class="flex flex-col md:flex-row items-center gap-2 md:gap-6 mt-4 md:mt-0 font-medium bg-gray-50 md:bg-white border md:border-none rounded-lg p-4 md:p-0">
                <li>
                    <a href="#"
                       class="text-emerald-700 md:text-emerald-700 font-semibold block py-2 px-3 rounded-md hover:bg-emerald-100 md:hover:bg-transparent transition">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#"
                       class="text-gray-700 hover:text-emerald-600 block py-2 px-3 rounded-md hover:bg-emerald-50 md:hover:bg-transparent transition">
                        Candidates
                    </a>
                </li>
                <li>
                    <a href="#"
                       class="text-gray-700 hover:text-emerald-600 block py-2 px-3 rounded-md hover:bg-emerald-50 md:hover:bg-transparent transition">
                        Rules
                    </a>
                </li>
                <li>
                    <a href="#"
                       class="text-gray-700 hover:text-emerald-600 block py-2 px-3 rounded-md hover:bg-emerald-50 md:hover:bg-transparent transition">
                        Contact
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
