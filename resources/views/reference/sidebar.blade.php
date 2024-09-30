<aside class="fixed pt-8 pb-16 w-80 bg-slate-50 overflow-auto overscroll-y-contain h-screen">
    @foreach ($directories as $directory)
        <x-sidebar.navigation
            :definition="$directory"
            :displayDivider="true"
        />
    @endforeach
</aside>
