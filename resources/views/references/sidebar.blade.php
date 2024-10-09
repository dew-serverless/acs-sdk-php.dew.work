<aside class="fixed pt-8 pb-16 w-80 bg-slate-50 overflow-auto overscroll-y-contain h-screen">
    <header class="flex px-4">
        <h1 class="font-black text-2xl">ACS SDK PHP</h1>
        <div class="ml-4">
            <svg width="32" xmlns="http://www.w3.org/2000/svg" height="32" fill="none"><g data-testid="Logo / 32"><defs><clipPath id="a" class="frame-clip frame-clip-def"><rect rx="6" ry="6" width="32" height="32"/></clipPath></defs><g clip-path="url(#a)"><g class="fills"><rect width="32" height="32" class="frame-background" style="fill: rgb(248, 250, 252); fill-opacity: 1;" ry="6" rx="6"/></g><g class="frame-children"><path d="M14.946 4.5C7.742 4.5 4 8.954 4 16.101 4 23.249 7.742 27.5 14.946 27.5 22.151 27.5 28 23.249 28 16.101 28 8.954 22.151 4.5 14.946 4.5Z" style="fill: rgb(117, 189, 245); fill-opacity: 1;" class="fills" data-testid="Ellipse"/></g></g></g></svg>
        </div>
    </header>

    <div
        x-data="{
            open: false,
            toggle() {
                if (this.open) {
                    return this.close()
                }

                this.$refs.button.focus()

                this.open = true

                setTimeout(() => {
                    this.$refs.active.scrollIntoView({
                        block: 'center'
                    })
                }, 50)
            },
            close(focusAfter) {
                if (! this.open) return

                this.open = false

                focusAfter && focusAfter.focus()
            }
        }"
        x-on:keydown.escape.prevent.stop="close($refs.button)"
        x-on:focusin.window="! $refs.panel.contains($event.target) && close()"
        x-id="['dropdown-button']"
        class="relative"
    >
        <div class="mt-8 px-4">
            <button
                x-ref="button"
                x-on:click="toggle()"
                :aria-expanded="open"
                :aria-controls="$id('dropdown-button')"
                class="flex items-center w-full py-2.5 px-4 bg-white rounded-md shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50"
            >
                <span class="text-base font-bold text-slate-800 leading-none break-all">{{ $product }}</span>
                <span class="inline-block px-2 text-sm text-slate-300 leading-none">/</span>
                <span class="text-base text-slate-600 leading-none">{{ $version }}</span>
                <svg class="ml-auto -mr-1 h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div
            x-ref="panel"
            x-show="open"
            x-transition.origin.top.left
            x-on:click.outside="close($refs.button)"
            :id="$id('dropdown-button')"
            class="absolute w-72 left-4 mt-2 z-10 bg-white"
            style="display: none;"
        >
            <div class="shadow-lg rounded-md max-h-96 overflow-y-auto ring-1 ring-black ring-opacity-5">
                @foreach ($products as $product)
                    @foreach ($product['versions'] as $version)
                        <a
                            {{ strtolower(Request::route('product')) === strtolower($product['code']) && Request::route('version') === $version ? 'x-ref=active' : null }}
                            href="{{ route('references.apis.index', [
                                'locale' => Request::route('locale'),
                                'product' => strtolower($product['code']),
                                'version' => $version,
                            ]) }}"
                            class="block px-4 py-2 cursor-pointer {{ strtolower(Request::route('product')) === strtolower($product['code']) && Request::route('version') === $version ? 'bg-slate-200' : 'hover:bg-slate-100' }}"
                            role="menuitem"
                            tabindex="-1"
                        >
                            <span class="block font-bold text-base text-slate-700">{{ $product['code'] }}</span>
                            <span class="block text-sm text-slate-500">{{ $product['name'] }}</span>
                            <span class="block text-sm text-slate-500">
                                {{ $version }}{{ $product['defaultVersion'] === $version ? '*' : null }}
                            </span>
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="mt-4">
        @foreach ($directories as $directory)
            <x-sidebar.navigation
                :definition="$directory"
                :displayDivider="true"
            />
        @endforeach
    </div>
</aside>
