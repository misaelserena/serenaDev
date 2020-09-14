<center>
  <div id="documents_masiva">
    <div class="docs-p">
      <div class="docs-p-l">
        <div class="uploader-content ">
          <input type="file" name="xmlfile" accept=".xml">
        </div>
      </div>
      <div class="docs-p-r">
        <span onclick="remove_doc()" class="icon-x delete-span"></span>
      </div>
    </div>
  </div>
</center>




<div id="concepts_masiva">


  <div id="form_create_lot" style="display: none;">
    <center>
      <strong>DETALLES DE LOTE</strong>
      <span class="help-btn" id="help-btn-lote"></span>
    </center>
    <div class="divisor">
      <div class="gray-divisor"></div>
      <div class="orange-divisor"></div>
      <div class="gray-divisor"></div>
    </div>
    <div class="container-blocks" id="container-data_masiva">
      <div class="search-table-center">
        <div class="search-table-center-row">
          <p>
            <select class="js-enterprises_masiva removeselect" name="enterprise_id_masiva" multiple="multiple" style="width: 84%; border: 0px;" data-validation="required">
              @foreach(App\Enterprise::where('status','ACTIVE')->whereIn('id',Auth::user()->inChargeEnt( $option_id	)->pluck('enterprise_id'))->orderBy('name','asc')->get() as $enterprise)
                <option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
              @endforeach
            </select><br>
          </p>
        </div>
        <div class="search-table-center-row">
          <p>
            <select class="js-accounts-masiva removeselect" name="account_id_masiva" multiple="multiple" style="width: 84%; border: 0px;" data-validation="required">
            </select><br>
          </p>
        </div>
        <div class="search-table-center">
          <label class="label-form">Fecha</label>
          <input type="text" id="date_masiva" name="date_masiva" placeholder="Fecha" class="input-text" data-validation="required" readonly="true">
        </div>
        <div class="search-table-center">
          <br><label class="label-form">Sub Total de Factura/Ticket</label>
          <input type="text" id="sub_total_masiva" name="sub_total_masiva" class="input-text remove inversion" data-validation="required" placeholder="$0.00">
        </div>
        <div class="search-table-center">
          <br><label class="label-form">Total de Factura/Ticket</label>
          <input type="text" id="total_masiva" name="total_masiva" class="input-text remove inversion" data-validation="required" placeholder="$0.00">
        </div>
      </div>
    </div>

    <center>
      <div id="documentsMasiva"></div>
      <p>
        <button type="button" name="addDocMasiva" id="addDoc"><div class="btn_plus">+</div> Agregar documento</button>
      </p>
    </center>

    <br>
    
    <center>
      <p>
        <button class="btn btn-delete-form" type="button" id="clean_masiva">Cancelar</button>
        <input class="btn btn-red enviar" id="masiva_siguiente" type="button"  name="enviar" value="SIGUIENTE"> 
      </p>
    </center>
  </div>


  
  <div id="articles_details_form" style="display: none;">
    <div id="articles_count_container">
      <center>
        <div class="search-table-center">
          <div class="search-table-center">
            <center>
              <strong id="articles_count">Artículos: 1/100</strong>
            </center>
          </div>
        </div>
      </center> 
      <br>
    </div>

    <center>
      <strong>DETALLES DE ARTÍCULO</strong>
    </center>
    <div class="divisor">
      <div class="gray-divisor"></div>
      <div class="orange-divisor"></div>
      <div class="gray-divisor"></div>
    </div>
  
    <div class="container-blocks" id="container-data">
      <div class="search-table-center">
          <div @if ( count($category_id) == 1 ) hidden  @endif class="search-table-center-row">
            <p style="padding-left: 15px;">
              <select class="js-category_masiva removeselect" name="category_id_masiva" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
                @foreach (App\CatWarehouseType::whereIn('id',$category_id)->get() as $w)
                  @if ( count($category_id) == 1 ) 
                    <option selected value="{{ $w->id }}">{{ $w->description }}</option>
                  @else
                    <option value="{{ $w->id }}">{{ $w->description }}</option>
                  @endif
                @endforeach
              </select>
            </p>
          </div>

        
      <div class="search-table-center-row">
        <p style="padding-left: 15px;">
          
          <select class="js-places_masiva removeselect" name="place_id_masiva" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
            @foreach(App\Place::where('status',1)->get() as $place)
              <option value="{{ $place->id }}">{{ $place->place }}</option>			
            @endforeach
          </select>
        </p>
      </div>
      <div class="search-table-center-row">
        <p style="padding-left: 15px;">
          <select class="js-measurement_masiva removeselect" name="measurement_id_masiva" multiple="multiple" style="width: 84%; border: 0px; padding-left: 10px">
            @foreach(App\CatMeasurementTypes::whereNotNull('type')->get() as $m_types)
              @foreach ($m_types->childrens()->orderBy('child_order','asc')->get() as $child)
                <option value="{{ $child->id }}">{{ $child->description }}</option>			
              @endforeach
            @endforeach
          </select>
        </p>
      </div>
        <div class="search-table-center">
          <div class="search-table-center-row">
            <div id="concepto_sugerido_container" style="display: none;">
              <div class="left">
                <input type="checkbox" style="display: none;" id="concept_name_masiva_sugerido_check">
                <label class="switch" for="concept_name_masiva_sugerido_check">
                <span class="slider round"></span>Concepto sugerido</label>
              </div>
              <div class="right">
                <input type="text" id="concept_name_masiva_sugerido" name="concept_name_masiva_sugerido" class="input-text input-text remove" placeholder="Concepto" disabled readonly>
              </div>
              <br>
            </div>
            <div id="concept_container">
              <div class="left">
                <label class="label-form">Concepto</label>
              </div>
              <div class="right">
                <input type="text" id="concept_name_masiva" name="concept_name_masiva" class="input-text input-text remove" placeholder="Concepto">
              </div>
              <br>
            </div>
            <div class="left">
              <label class="label-form">Código corto (Opcional)</label>
            </div>
            <div class="right">
              <input type="text" id="short_code_masiva" name="short_code_masiva" class="input-text input-text remove disabled" placeholder="Ingrese el código corto">
            </div>
            <br>
            <div class="left">
              <label class="label-form">Código largo (Opcional)</label>
            </div>
            <div class="right">
              <input type="text" id="long_code_masiva" name="long_code_masiva" class="input-text input-text remove disabled" placeholder="Ingrese el código largo">
            </div>
            <br>
            <div class="left">
              <label class="label-form">Cantidad</label>
            </div>
            <div class="right">
              <input type="text" id="quantity_masiva" name="quantity_masiva" class="input-text input-text remove disabled" placeholder="0">
            </div>
            <br>
            <div class="left">
              <br><label class="label-form">Precio unitario</label>
            </div>
            <div class="right">
              <input type="text" id="uamount_masiva" name="uamount_masiva" class="input-text remove disabled" placeholder="$0.00">
            </div>
            <br>
            <div class="left">
              <b>Tipo de IVA:</b>
            </div>
            <div class="right">
              <input type="radio" name="masiva_iva_kind" class="masiva_iva_kind" id="masiva_iva_no" value="no" checked=""><label for="masiva_iva_no" title="No IVA" style="display: inline-block;margin: 5px 0 5px 5px;">No</label>
              <input type="radio" name="masiva_iva_kind" class="masiva_iva_kind" id="masiva_iva_a" value="a"><label for="masiva_iva_a" masiva_title="{{App\Parameter::where('parameter_name','IVA')->first()->parameter_value}}%" style="display: inline-block;">A</label>
              <input type="radio" name="masiva_iva_kind" class="masiva_iva_kind" id="masiva_iva_b" value="b"><label for="masiva_iva_b" title="{{App\Parameter::where('parameter_name','IVA2')->first()->parameter_value}}%" style="display: inline-block;">B</label>
            </div>
            <br>
            <div class="left">
              <br><label class="label-form">Importe</label>
            </div>
            <div class="right">
              <input readonly disabled type="text" id="amount_masiva" name="amount_masiva" class="input-text remove amount disabled" placeholder="$0.00">
            </div>
            <br>
            <div class="left">
              <br><label class="label-form">Comentario (Opcional)</label>
            </div>
            <div class="right">
              <textarea id="commentaries_masiva" name="commentaries_masiva" cols="20" rows="4" placeholder="Ingrese el comentario" class="input-text"></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <center>
      <p>
        <button class="btn btn-delete-form" type="button" id="clean_masiva">Cancelar</button>
        <button class="btn btn-red enviar" id="masiva_send_article"  name="enviar"> ENVIAR </button>
      </p>
    </center>
  </div>


</div>

