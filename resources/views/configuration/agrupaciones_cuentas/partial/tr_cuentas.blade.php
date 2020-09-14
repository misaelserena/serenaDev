@php
	$countTD = 0;
@endphp
@foreach($accounts as $acc)
	@if($countTD == 0)
		<tr>
	@endif
		@if ($acc->level == 3) 
			<td style="text-align: left;">
				<label class="container">
					<input type="checkbox" name="idAccAcc[]" multiple="multiple" value="{{ $acc->idAccAcc }}">
					<span class="checkmark"></span>{{ $acc->account }} - {{ $acc->description }} ({{ $acc->content }})
				</label>
			</td>
			@php
				$countTD++;
			@endphp
		@endif
	@if($countTD == 3)
		</tr>
		@php
			$countTD = 0;
		@endphp
	@endif
@endforeach