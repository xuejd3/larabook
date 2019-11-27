@extends('larabook::layout')
@section('title', $title)

@section('content')
  <div class="lg:flex items-stretch h-full">
    @include('larabook::ads.before-sidebar')
    @include('larabook::partials.sidebar')
    @include('larabook::ads.after-sidebar')

    <div id="docs-content" class="min-h-screen w-full lg:static lg:max-h-full lg:overflow-visible w-full lg:w-3/4 xl:w-4/5 flex">
      <div class="markdown-body mb-6 px-6 max-w-3xl mx-auto lg:ml-0 lg:mr-auto xl:mx-0 xl:px-12 w-full xl:w-3/4">
        <div class="my-6">
          @include('larabook::ads.before-content')
        </div>
        <article id="content" class="w-full">
          @include('larabook::partials.content-header')

          <div v-pre>
            {!! $content !!}
          </div>

          <footer class="border-t py-4 mt-6">
{{--            @include('larabook::partials.footer')--}}
          </footer>
        </article>
        <div class="my-6">
          @include('larabook::ads.after-content')
        </div>
      </div>
      @include('larabook::partials.toc')
    </div>
  </div>
@stop
