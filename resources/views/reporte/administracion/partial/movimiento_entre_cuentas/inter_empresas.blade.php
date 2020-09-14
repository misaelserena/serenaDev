@php
	$taxes = $retentions = 0;
@endphp
<center>
  <strong>DATOS DEL PEDIDO</strong>
</center>
<div class="divisor">
  <div class="gray-divisor"></div>
  <div class="orange-divisor"></div>
  <div class="gray-divisor"></div>
</div>
<div class="form-container">
  <div class="table-responsive">
    <table id="table" class="table-no-bordered">
      <thead>
        <th>#</th>
        <th>Cantidad</th>
        <th>Unidad</th>
        <th>Descripci&oacute;n</th>
        <th>Precio Unitario</th>
        <th>IVA</th>
        <th>Impuesto Adicional</th>
        <th>Retenciones</th>
        <th>Importe</th>
      </thead>
      <tbody id="body">
        @php
          $countConcept = 1;
        @endphp
        @foreach($request->purchaseEnterprise->first()->detailPurchaseEnterprise as $detail)
          <tr>
            <td>{{ $countConcept }}</td>
            <td>{{ $detail->quantity }}</td>
            <td>{{ $detail->unit }}</td>
            <td>{{ $detail->description }}</td>
            <td>$ {{ number_format($detail->unitPrice,2) }}</td>
            <td>$ {{ number_format($detail->tax,2) }}</td>
            <td>
              @php
                $taxesConcept=0;
              @endphp
              @foreach($detail->taxes as $tax)
                @php
                  $taxesConcept+=$tax->amount;
                @endphp
              @endforeach
              $ {{ number_format($taxesConcept,2) }}
            </td>
            <td>
              @php
                $retentionConcept=0;
              @endphp
              @foreach($detail->retentions as $ret)
                @php
                  $retentionConcept+=$ret->amount;
                @endphp
              @endforeach
              $ {{ number_format($retentionConcept,2) }}
            </td>
            <td>$ {{ number_format($detail->amount,2) }}</td>
          </tr>
          @php
            $countConcept++;
          @endphp
        @endforeach
      </tbody>
    </table>
  </div>
  <br>
</div>
<div class="totales2">
  <div class="totales">
    <textarea name="note" class="input-text" placeholder="Nota" cols="80" readonly="readonly">{{ $request->purchaseEnterprise->first()->notes }}</textarea>
  </div>
  <div class="totales" style="margin-left: 10px;"> 
    <table>
      <tr>
        <td>
          <label class="label-form">Subtotal:</label>
        </td>
        <td>
          <input placeholder="0" readonly class="input-table" type="text" name="subtotal" value="$ {{ number_format($request->purchaseEnterprise->first()->subtotales,2,".",",") }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">Impuesto Adicional:</label>
        </td>
        <td>
          @foreach($request->purchaseEnterprise->first()->detailPurchaseEnterprise as $detail)
            @foreach($detail->taxes as $tax)
              @php 
                $taxes += $tax->amount
              @endphp
            @endforeach
          @endforeach
          <input placeholder="0" readonly class="input-table" type="text" name="amountAA" value="$ {{ number_format($taxes,2) }}" >
        </td>
      </tr>
      <tr>
        <td><label class="label-form">Retenciones:</label></td>
        <td>
          @foreach($request->purchaseEnterprise->first()->detailPurchaseEnterprise as $detail)
            @foreach($detail->retentions as $ret)
              @php 
                $retentions += $ret->amount
              @endphp
            @endforeach
          @endforeach
          <input placeholder="$0.00" readonly class="input-table" type="text" name="amountR" value="$ {{ number_format($retentions,2) }}" >

        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">IVA: </label>
        </td>
        <td>
          <input placeholder="0" readonly class="input-table" type="text" name="totaliva" value="$ {{ number_format($request->purchaseEnterprise->first()->tax,2,".",",") }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">TOTAL:</label>
        </td>
        <td>
          <input id="input-extrasmall" placeholder="0" readonly class="input-table" type="text" name="total" value="$ {{ number_format($request->purchaseEnterprise->first()->amount,2,".",",") }}">
        </td>
      </tr>
    </table>
  </div> 
</div>
<br><br><br>
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
        <td><label>{{ $request->purchaseEnterprise->first()->typeCurrency }}</label></td>
      </tr>
      <tr>
        <td><b>Fecha de pago:</b></td>
        @php	
          $time	= strtotime($request->purchaseEnterprise->first()->paymentDate);
          $date	= date('d-m-Y',$time);
        @endphp
        <td><label>{{ $date }}</label></td>
      </tr>
      <tr>
        <td><b>Forma de pago:</b></td>
        <td><label>{{ $request->purchaseEnterprise->first()->paymentMethod->method }}</label></td>
      </tr>
      @if($request->purchaseEnterprise->first()->idbanksAccounts != "")
        <tr>
          <td><b>Banco:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->bank->description }}</label></td>
        </tr>
        <tr>
          <td><b>Alias:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->alias }}</label></td>
        </tr>
        <tr>
          <td><b>Cuenta:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->account != "" ? $request->purchaseEnterprise->first()->banks->account : "----" }}</label></td>
        </tr>
        <tr>
          <td><b>Clabe:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->clabe != "" ? $request->purchaseEnterprise->first()->banks->clabe : "----" }}</label></td>
        </tr>
        <tr>
          <td><b>Sucursal:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->branch != "" ? $request->purchaseEnterprise->first()->banks->branch : "----" }}</label></td>
        </tr>
        <tr>
          <td><b>Referencia:</b></td>
          <td><label>{{ $request->purchaseEnterprise->first()->banks->reference != "" ? $request->purchaseEnterprise->first()->banks->reference : "----" }}</label></td>
        </tr>

      @endif
      <tr>
        <td><b>Importe a pagar:</b></td>
        <td><label>${{ number_format($request->purchaseEnterprise->first()->amount,2) }}</label></td>
      </tr>
    </tbody>
  </table>
</div>