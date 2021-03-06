<nav class="w-full py-4 bg-calypso-500 shadow">
    <div class="w-full container mx-auto flex flex-wrap items-center justify-between">
        <nav>
            <ul class="flex items-center justify-between text-sm text-white uppercase no-underline">
                <li>
                    <a class="text-quill-400 hover:underline px-3 {{ url()->current() === route('pages.home') ? 'underline' : '' }}" title="Go to the homepage" href="{{ route('pages.home') }}">
                        Home
                    </a>
                </li>
                <li>
                    <a class="text-quill-400 hover:underline px-3 {{ url()->current() === route('pages.about') ? 'underline' : '' }}" title="Go to the about page" href="{{ route('pages.about') }}">
                        About
                    </a>
                </li>
                <li>
                    <a class="text-quill-400 hover:underline px-3 {{ url()->current() === route('search.show') ? 'underline' : '' }}" title="Go to the search page" href="{{ route('search.show') }}">
                        Search
                    </a>
                </li>
            </ul>
        </nav>

        <div class="flex items-center text-lg no-underline text-white pr-6">
            <a class="pl-6" href="https://github.com/ChrisCrawford1/vatflights" title="Redirect to the source code in GitHub">
                <i class="fab fa-github transform duration-300 ease-in-out hover:-translate-y-1 hover:text-purple-700"></i>
            </a>
        </div>
    </div>
</nav>
