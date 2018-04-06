@extends(config('sirgrimorum.pages.extends', 'layouts.app'))

@section(config('sirgrimorum.pages.content', 'content'))
{!!\Sirgrimorum\Pages\Pages::buildPage($pagina)!!}
@stop

@if (is_array(config('sirgrimorum.pages.jses',[])))
@push(config('sirgrimorum.pages.js_section', config("sirgrimorum.crudgenerator.js_section")))
@foreach(config('sirgrimorum.pages.jses',[]) as $jsLoad)
<script src="{{ asset($jsLoad) }}" defer></script>
@endforeach
@endpush
@endif

@if (is_array(config('sirgrimorum.pages.csses',[])))
@push(config('sirgrimorum.pages.css_section', config("sirgrimorum.crudgenerator.css_section")))
@foreach(config('sirgrimorum.pages.csses',[]) as $cssLoad)
<link href="{{ asset($cssLoad) }}" rel="stylesheet">
@endforeach
@endpush
@endif