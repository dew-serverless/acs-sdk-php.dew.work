<aside class="fixed pt-8 pb-16 w-80 bg-slate-50 overflow-auto overscroll-y-contain h-screen">
    <header class="flex px-4">
        <h1 class="font-black text-2xl">ACS SDK PHP</h1>
        <div class="ml-4">
            <svg width="32" xmlns="http://www.w3.org/2000/svg" height="32" fill="none"><g data-testid="Logo / 32"><defs><clipPath id="a" class="frame-clip frame-clip-def"><rect rx="6" ry="6" width="32" height="32"/></clipPath></defs><g clip-path="url(#a)"><g class="fills"><rect width="32" height="32" class="frame-background" style="fill: rgb(248, 250, 252); fill-opacity: 1;" ry="6" rx="6"/></g><g class="frame-children"><path d="M14.946 4.5C7.742 4.5 4 8.954 4 16.101 4 23.249 7.742 27.5 14.946 27.5 22.151 27.5 28 23.249 28 16.101 28 8.954 22.151 4.5 14.946 4.5Z" style="fill: rgb(117, 189, 245); fill-opacity: 1;" class="fills" data-testid="Ellipse"/></g></g></g></svg>
        </div>
    </header>

    <div>
        @foreach ($directories as $directory)
            <x-sidebar.navigation
                :definition="$directory"
                :displayDivider="true"
            />
        @endforeach
    </div>
</aside>
