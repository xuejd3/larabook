<div class="relative">
  <input class="bg-gray-100 appearance-none border-2 border-gray-200 rounded py-2 px-4 text-gray-800 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="search-input" type="text" placeholder="{{ config('larabook.plugins.docsearch.placeholder') }}">
  <div class="absolute right-0 top-0 mt-3 mr-4 text-gray-600">
    <svg version="1.1" class="h-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 40 40" style="enable-background:new 0 0 52.966 52.966;" xml:space="preserve">
    <path d="M26.806 29.012a16.312 16.312 0 0 1-10.427 3.746C7.332 32.758 0 25.425 0 16.378 0 7.334 7.333 0 16.38 0c9.045 0 16.378 7.333 16.378 16.38 0 3.96-1.406 7.593-3.746 10.426L39.547 37.34c.607.608.61 1.59-.004 2.203a1.56 1.56 0 0 1-2.202.004L26.807 29.012zm-10.427.627c7.322 0 13.26-5.938 13.26-13.26 0-7.324-5.938-13.26-13.26-13.26-7.324 0-13.26 5.936-13.26 13.26 0 7.322 5.936 13.26 13.26 13.26z" fill-rule="evenodd"></path>
    </svg>
  </div>
</div>

@push('footer-prepend-script')
  <script>
    var LARABOOK_ALGOLIA_API_KEY    = '{{ config('larabook.plugins.docsearch.api_key') }}';
    var LARABOOK_ALGOLIA_INDEX_NAME = '{{ config('larabook.plugins.docsearch.index_name') }}';
  </script>
@endpush
