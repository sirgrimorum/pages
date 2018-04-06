@extends(config('sirgrimorum.pages.extends', 'layouts.app'))

@section(config('sirgrimorum.pages.content', 'content'))
<div style='padding-top: 200px; padding-bottom: 200px;'>
    @handleCrudMessages("error")
</div>
@stop
