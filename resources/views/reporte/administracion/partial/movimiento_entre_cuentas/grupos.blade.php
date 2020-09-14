@php
	$taxes = $retentions = 0;
@endphp
<center>
  <strong>DATOS DEL PROVEEDOR</strong>
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
        <td><b>Razón Social:</b></td>
        <td><label>{{ $request->groups->first()->provider->businessName }}</label></td>
      </tr>
      <tr>
        <td><b>RFC:</b></td>
        <td><label>{{ $request->groups->first()->provider->rfc }}</label></td>
      </tr>
      <tr>
        <td><b>Teléfono:</b></td>
        <td><label>{{ $request->groups->first()->provider->phone }}</label></td>
      </tr>
      <tr>
        <td><b>Calle:</b></td>
        <td><label>{{ $request->groups->first()->provider->address }}</label></td>
      </tr>
      <tr>
        <td><b>Número:</b></td>
        <td><label>{{ $request->groups->first()->provider->number }}</label></td>
      </tr>
      <tr>
        <td><b>Colonia:</b></td>
        <td><label>{{ $request->groups->first()->provider->colony }}</label></td>
      </tr>
      <tr>
        <td><b>CP:</b></td>
        <td><label>{{ $request->groups->first()->provider->postalCode }}</label></td>
      </tr>
      <tr>
        <td><b>Ciudad:</b></td>
        <td><label>{{ $request->groups->first()->provider->city }}</label></td>
      </tr>
      <tr>
        <td><b>Estado:</b></td>
        <td><label>{{ App\State::find($request->groups->first()->provider->state_idstate)->description }}</label></td>
      </tr>
      <tr>
        <td><b>Contacto:</b></td>
        <td><label>{{ $request->groups->first()->provider->contact }}</label></td>
      </tr>
      <tr>
        <td><b>Beneficiario:</b></td>
        <td><label>{{ $request->groups->first()->provider->beneficiary }}</label></td>
      </tr>
      <tr>
        <td><b>Otro</b></td>
        <td><label>{{ $request->groups->first()->provider->commentaries }}</label></td>
      </tr>
    </tbody>
  </table>
  <div class="form-container">
    <div class="table-responsive">
      <table id="table2" class="table-no-bordered">
        <thead>
          <tr>
            <th>Banco</th>
            <th>Alias</th>
            <th>Cuenta</th>
            <th>Sucursal</th>
            <th>Referencia</th>
            <th>CLABE</th>
            <th>Moneda</th>
            <th>Convenio</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($request->groups->first()->provider->providerBank as $bank)
            <tr  @if($request->groups->first()->provider_has_banks_id == $bank->id) class="marktr" @endif>
              <td>
                {{$bank->bank->description}}
              </td>
              <td>
                {{$bank->alias}}
              </td>
              <td>
                {{$bank->account}}
              </td>
              <td>
                {{$bank->branch}}
              </td>
              <td>
                {{$bank->reference}}
              </td>
              <td>
                {{$bank->clabe}}
              </td>
              <td>
                {{$bank->currency}}
              </td>
              <td>
                @if($bank->agreement=='')
                  -------------------------
                @else
                  {{$bank->agreement}}
                @endif
              </td>
              <td>
                <button class="delete-item" type="button"><span class="icon-x delete-span" style="display: none;"></span></button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
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
        @foreach($request->groups->first()->detailGroups as $detail)
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
    <textarea name="note" class="input-text" placeholder="Nota" cols="80" readonly="readonly">{{ $request->groups->first()->notes }}</textarea>
  </div>
  <div class="totales" style="margin-left: 10px;"> 
    <table>
      <tr>
        <td>
          <label class="label-form">Subtotal:</label>
        </td>
        <td>
          <input placeholder="0" readonly class="input-table" type="text" name="subtotal" value="$ {{ number_format($request->groups->first()->subtotales,2,".",",") }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">Impuesto Adicional:</label>
        </td>
        <td>
          @foreach($request->groups->first()->detailGroups as $detail)
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
          @foreach($request->groups->first()->detailGroups as $detail)
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
          <input placeholder="0" readonly class="input-table" type="text" name="totaliva" value="$ {{ number_format($request->groups->first()->tax,2,".",",") }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">TOTAL:</label>
        </td>
        <td>
          <input id="input-extrasmall" placeholder="0" readonly class="input-table" type="text" name="total" value="$ {{ number_format($request->groups->first()->amount,2,".",",") }}">
        </td>
      </tr>
    </table>
  </div> 
</div>