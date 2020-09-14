<center>
  <strong>DATOS DE ORIGEN </strong>
</center>
<div class="divisor">
  <div class="gray-divisor"></div>
  <div class="orange-divisor"></div>
  <div class="gray-divisor"></div>
</div>
<div class="alert alert-danger" id="error_request" role="alert" @if(count($request->adjustment->first()->adjustmentFolios)>0) style="display: none;" @endif>
  <b>Debe seleccionar una solicitud </b>
</div>
<div class="folios" style="display: flex;flex-wrap: wrap;">
  @foreach($request->adjustment->first()->adjustmentFolios as $af)
    <input type="hidden" class="folios_adjustment" value="{{ $af->idFolio }}">
    <div class="profile-table-center" style="border: 1px solid #c6c6c6; max-width: 500px; width: 100%;">
      <div class="profile-table-center-header">FOLIO #{{ $af->idFolio }}</div>
      <div class="profile-table-center-row">
        <div class="left">Empresa:</div>
        <div class="right"><p>{{ $af->requestModel->reviewedEnterprise->name }}</p></div>
      </div>
      <div class="profile-table-center-row">
        <div class="left">Dirección:</div>
        <div class="right"><p>{{ $af->requestModel->reviewedDirection->name }}</p></div>
      </div>
      <div class="profile-table-center-row">
        <div class="left">Departamento:</div>
        <div class="right"><p>{{ $af->requestModel->reviewedDepartment->name }}</p></div>
      </div>
      <div class="profile-table-center-row">
        <div class="left">Clasificación del gasto:</div>
        <div class="right"><p>{{ $af->requestModel->accountsReview()->exists() ? $af->requestModel->accountsReview->account.' '. $af->requestModel->accountsReview->description : 'Varias'  }}</p></div>
      </div>
      <div class="profile-table-center-row no-border">
        <div class="left">Proyecto:</div>
        <div class="right"><p>{{ $af->requestModel->reviewedProject->proyectName }}</p></div>
      </div>
    </div>
  @endforeach
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
        <th width="10%">#</th>
        <th width="10%">Solicitud de</th>
        <th width="10%">Cantidad</th>
        <th width="10%">Unidad</th>
        <th width="10%">Descripci&oacute;n</th>
        <th width="10%">Precio Unitario</th>
        <th width="10%">IVA</th>
        <th width="10%">Impuesto Adicional</th>
        <th width="10%">Retenciones</th>
        <th width="10%">Importe</th>
      </thead>
      <tbody id="body">
        @php
          $countConcept = 1;
        @endphp
        @foreach($request->adjustment->first()->adjustmentFolios as $detail)
          @switch($detail->requestModel->kind)
            @case(1)
              @foreach($detail->requestModel->purchases->first()->detailPurchase as $detpurchase)
                <tr>
                  <td>{{ $countConcept }}</td>
                  <td>{{ $detail->requestModel->requestkind->kind.' #'.$detail->requestModel->folio }}</td>
                  <td>{{ $detpurchase->quantity }}</td>
                  <td>{{ $detpurchase->unit }}</td>
                  <td>{{ $detpurchase->description }}</td>
                  <td>$ {{ number_format($detpurchase->unitPrice,2) }}</td>
                  <td>$ {{ number_format($detpurchase->tax,2) }}</td>
                  <td>
                    @php
                      $taxesConcept=0;
                    @endphp
                    @foreach($detpurchase->taxes as $tax)
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
                    @foreach($detpurchase->retentions as $ret)
                      @php
                        $retentionConcept+=$ret->amount;
                      @endphp
                    @endforeach
                    $ {{ number_format($retentionConcept,2) }}
                  </td>
                  <td>$ {{ number_format($detpurchase->amount,2) }}</td>
                </tr>
                @php
                  $countConcept++;
                @endphp
              @endforeach
            @break

            @case(3)
              @foreach($detail->requestModel->expenses->first()->expensesDetail as $detexpenses)
                <tr>
                  <td>{{ $countConcept }}</td>
                  <td>{{ $detail->requestModel->requestkind->kind.' #'.$detail->requestModel->folio }}</td>
                  <td> - </td>
                  <td> - </td>
                  <td>{{ $detexpenses->description }}</td>
                  <td>$ {{ number_format($detexpenses->unitPrice,2) }}</td>
                  <td>$ {{ number_format($detexpenses->tax,2) }}</td>
                  <td>
                    @php
                      $taxesConcept=0;
                    @endphp
                    @foreach($detexpenses->taxes as $tax)
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
                    @foreach($detexpenses->retentions as $ret)
                      @php
                        $retentionConcept+=$ret->amount;
                      @endphp
                    @endforeach
                    $ {{ number_format($retentionConcept,2) }}
                  </td>
                  <td>$ {{ number_format($detexpenses->amount,2) }}</td>
                </tr>
                @php
                  $countConcept++;
                @endphp
              @endforeach
            @break

            @case(9)
              @foreach($detail->requestModel->refunds->first()->refundDetail as $detrefund)
                <tr>
                  <td>{{ $countConcept }}</td>
                  <td>{{ $detail->requestModel->requestkind->kind.' #'.$detail->requestModel->folio }}</td>
                  <td> - </td>
                  <td> - </td>
                  <td>{{ $detrefund->concept }}</td>
                  <td>$ {{ number_format($detrefund->unitPrice,2) }}</td>
                  <td>$ {{ number_format($detrefund->tax,2) }}</td>
                  <td>
                    @php
                      $taxesConcept=0;
                    @endphp
                    @foreach($detrefund->taxes as $tax)
                      @php
                        $taxesConcept+=$tax->amount;
                      @endphp
                    @endforeach
                    $ {{ number_format($taxesConcept,2) }}
                  </td>
                  <td>
                    $0.00
                  </td>
                  <td>$ {{ number_format($detrefund->amount,2) }}</td>
                </tr>
                @php
                  $countConcept++;
                @endphp
              @endforeach
            @break
          @endswitch
        @endforeach
      </tbody>
    </table>
  </div>
  <br>
</div>
<div class="totales2">
  <div class="totales" style="margin-left: 10px;"> 
    <table>
      <tr>
        <td>
          <label class="label-form">Subtotal:</label>
        </td>
        <td>
          <input placeholder="0" readonly class="input-table" type="text" name="subtotal" value="$ {{ number_format($request->adjustment->first()->subtotales,2,".",",") }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">Impuesto Adicional:</label>
        </td>
        <td>
          @foreach($request->adjustment->first()->detailAdjustment as $detail)
            @foreach($detail->taxes as $tax)
              @php 
                $taxes += $tax->amount
              @endphp
            @endforeach
          @endforeach
          <input placeholder="0" readonly class="input-table" type="text" name="amountAA" value="$ {{ number_format($request->adjustment->first()->additionalTax,2) }}" >
        </td>
      </tr>
      <tr>
        <td><label class="label-form">Retenciones:</label></td>
        <td>
          <input placeholder="$0.00" readonly class="input-table" type="text" name="amountR" value="$ {{ number_format($request->adjustment->first()->retention,2) }}" >

        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">IVA: </label>
        </td>
        <td>
          <input placeholder="0" readonly class="input-table" type="text" name="totaliva" value="$ {{ number_format($request->adjustment->first()->tax,2) }}">
        </td>
      </tr>
      <tr>
        <td>
          <label class="label-form">TOTAL:</label>
        </td>
        <td>
          <input id="input-extrasmall" placeholder="0" readonly class="input-table" type="text" name="total" value="$ {{ number_format($request->adjustment->first()->amount,2) }}">
        </td>
      </tr>
    </table>
  </div> 
</div>