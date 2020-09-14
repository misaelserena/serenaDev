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
        <td><label>{{ $request->loanEnterprise->first()->currency }}</label></td>
      </tr>
      <tr>
        <td><b>Fecha de pago:</b></td>
        @php	
          $time	= $request->loanEnterprise->first()->paymentDate != '' ? strtotime($request->loanEnterprise->first()->paymentDate) : '';
          $date	= $request->loanEnterprise->first()->paymentDate!='' ? date('d-m-Y',$time) : '';
        @endphp
        <td><label>{{ $date }}</label></td>
      </tr>
      <tr>
        <td><b>Forma de pago:</b></td>
        <td><label>{{ $request->loanEnterprise->first()->paymentMethod->method }}</label></td>
      </tr>
      <tr>
        <td><b>Importe a pagar:</b></td>
        <td><label>${{ number_format($request->loanEnterprise->first()->amount,2) }}</label></td>
      </tr>
    </tbody>
  </table>
</div>
<br><br><br>