@extends('layouts.child_module')
	
@section('data')
	
@endsection
@section('scripts')
	<script type="text/javascript">
		$.ajaxSetup(
		{
			headers:
			{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
@endsection