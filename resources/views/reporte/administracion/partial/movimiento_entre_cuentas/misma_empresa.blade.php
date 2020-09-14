<center>
  <strong>CONDICIONES DE PAGO</strong>
</center>
<div class="divisor">
  <div class="gray-divisor"></div>
  <div class="orange-divisor"></div>
  <div class="gray-divisor"></div>
</div>
<div>
<table class="employee-details">
  <tbody>
    <tr>
      <td><b>Tipo de moneda:</b></td>
      <td><label>{{ $request->movementsEnterprise->first()->typeCurrency }}</label></td>
    </tr>
    <tr>
      <td><b>Fecha de pago:</b></td>
      @php	
        $time	= $request->movementsEnterprise->first()->paymentDate != '' ? strtotime($request->movementsEnterprise->first()->paymentDate) : '';
        $date	= $request->movementsEnterprise->first()->paymentDate != '' ? date('d-m-Y',$time) : '';
      @endphp
      <td><label>{{ $date }}</label></td>
    </tr>
    <tr>
      <td><b>Forma de pago:</b></td>
      <td><label>{{ $request->movementsEnterprise->first()->paymentMethod->method }}</label></td>
    </tr>
    <tr>
      <td><b>Importe a pagar:</b></td>
      <td><label>${{ number_format($request->movementsEnterprise->first()->amount,2) }}</label></td>
    </tr>
  </tbody>
</table>
<br><br><br>