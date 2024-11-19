@if(config('larabook.plugins.google-analytics.id'))
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('larabook.plugins.google-analytics.id') }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag () {dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', '{{ config('larabook.plugins.google-analytics.id') }}');
</script>

@endif
