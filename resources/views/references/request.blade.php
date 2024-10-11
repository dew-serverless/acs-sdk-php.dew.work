<section class="mt-16">
    <h2 class="font-bold text-3xl">
        {{ __('Request') }}
    </h2>

    @include('references.request.host')
    @include('references.request.path')
    @include('references.request.header')
    @include('references.request.query')
    @include('references.request.form_data')
    @include('references.request.body')
</section>
