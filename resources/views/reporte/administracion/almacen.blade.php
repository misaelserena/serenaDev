@extends('layouts.child_module')
@section('data')

<div id="container-cambio" class="div-search">
	<center>
		<p>
			<strong>BUSCAR</strong>
			<div class="divisor">
				<div class="gray-divisor"></div>
				<div class="orange-divisor"></div>
				<div class="gray-divisor"></div>
			</div>
		</p>
  </center>
  

  <div >
		<center>
			<div class="search-table-center">
				<div class="search-table-center-row">
						<select title="Categoría" name="cat" class="js-cat" multiple="multiple" style="width: 98%; max-width: 150px;">
              <option value="computo">Equipo de cómputo</option>
              @foreach (App\CatWarehouseType::all() as $w)
                <option value="{{ $w->id }}">{{ $w->description }}</option>
              @endforeach
						</select>
        </div>
        <br>

        <div class="search-table-center-row">
          <select class="js-places removeselect" name="place_id" multiple="multiple" style="width: 98%; max-width: 150px;">
            @foreach(App\Place::where('status',1)->get() as $place)
              <option value="{{ $place->id }}">{{ $place->place }}</option>			
            @endforeach
          </select>
        </div>
        <br>

        <div class="search-table-center-row">
            <select title="Empresa" name="idEnterprise" class="js-enterprises"multiple="multiple" style="width: 98%; max-width: 150px;">
              @foreach(App\Enterprise::orderName()->get() as $enterprise)
              <option value="{{ $enterprise->id }}">{{ strlen($enterprise->name) >= 35 ? substr(strip_tags($enterprise->name),0,35).'...' : $enterprise->name }}</option>
              @endforeach
              <option value="todas">Todas</option>
            </select>
        </div>
        <br>
        
        <div class="search-table-center-row">
          <select class="js-accounts removeselect" name="account_id" multiple="multiple" id="multiple-accounts select2-selection--multiple" style="width: 98%; max-width: 150px;">
          </select>
        </div>
        <br>

        
        <div class="search-table-center-row">
          <input placeholder="Concepto" class="input-all"  name="concept" style="width: 98%;">
        </div>
        <br>
        <div class="search-table-center-row">
          <div class="left">
            <label class="label-form">Rango de fechas:</label>
          </div>
          <div class="right-date">
            <p><input autocomplete="off" title="Desde" type="text" name="mindate" step="1" class="input-text-date datepicker" placeholder="Desde" id="mindate"> - <input title="Hasta" type="text" name="maxdate" step="1" class="input-text-date datepicker" placeholder="Hasta" id="maxdate" autocomplete="off"></p>
          </div>
        </div>
        
        
			</div>
		</center>
		<center>
			<button class="btn 	btn-search send-search" type="button" title="Buscar"><span class="icon-search"></span> Buscar</button>
		</center>
		<br><br>
	</div>


</div>
<br>
<div id="table-return"></div>
<div id="pagination"></div>
<div id="myModal" class="modal"></div>


@endsection
@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script type="text/javascript">
  current_selection = 1;
	$(document).ready(function()
	{
		$('.js-cat').select2(
		{
			placeholder : 'Selecciona la categoría',
			language 	: 'es',
			maximumSelectionLength : 1,
		});
    $('.js-enterprise').select2(
    {
      placeholder : 'Seleccione la empresa',
      language 	: 'es',
      maximumSelectionLength : 1,
    });
    $('.js-places').select2(
    {
      placeholder : 'Seleccione la ubicación/sede',
      language 	: 'es',
      maximumSelectionLength : 1,
    });
    
    $('.js-category').select2({
      placeholder: 'Seleccione la categoría',
      language: "es",
      maximumSelectionLength: 1,
      tags: true
    });
    $('.js-enterprises').select2({
      placeholder: 'Seleccione la Empresa',
      language: "es",
      maximumSelectionLength: 1
    });
    $('.js-accounts').select2({
      placeholder: 'Seleccione la cuenta',
      language: "es",
      maximumSelectionLength: 1,
      tags: true
    });
		
    
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	});
	$(document)
  .on('change','select[name="cat"]',function()
	{
    cat	= $('select[name="cat"] option:selected').val();
    if(cat){ 
      if(current_selection !== cat)
        $('#table-return').stop(true,true).fadeOut();
      
      current_selection = cat
    }

    switch (cat) {
      @foreach (App\CatWarehouseType::all() as $w)
        case "{{ $w->id }}":
      @endforeach
        $('#options_computer').stop(true,true).fadeOut();
        $('#options_p').stop(true,true).fadeIn();

        send_stationery();
        break;
      case "computo":
        $('#options_computer').stop(true,true).fadeIn();
        $('#options_p').stop(true,true).fadeOut();
        $('.js-type').select2(
        {
          placeholder : 'Seleccione el tipo',
          language 	: 'es',
          maximumSelectionLength : 1,
        });
        $('.js-accounts-c').select2({
          placeholder: 'Seleccione la cuenta',
          language: "es",
          maximumSelectionLength: 1,
          tags: true
        });
        $('.js-enterprises-c').select2({
          placeholder: 'Seleccione la Empresa',
          language: "es",
          maximumSelectionLength: 1
        });
        $('.js-places-c').select2(
        {
          placeholder : 'Seleccione la ubicación/sede',
          language 	: 'es',
          maximumSelectionLength : 1,
        });
        send_computer();
        break;
        
      default:
        break;
    }
  })
  .on('click','.send-search', function() {
    cat	= $('select[name="cat"] option:selected').val();
    switch (cat) {
      @foreach (App\CatWarehouseType::all() as $w)
        case "{{ $w->id }}":
      @endforeach
        send_stationery();
        break;
      case "computo":
        send_computer();
        break;
      default:
      swal({
					text: "Debe seleccionar una categoría.",
					icon: "info",
					buttons: 
					{
						confirm: true,
					},
				});
        break;
    }
  })
	.on('click','.detail-stationery', function()
	{
		concept = $(this).parents('tr').find('.concept').val();
		place_location = $(this).parents('tr').find('.place_location').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/warehouse/detail") }}',
			data : {
        'concept':concept,
        'place_location':place_location,
        'edit':false
      },
			success : function(data)
			{
				$('#myModal').show().html(data);
				$('.detail').attr('disabled','disabled');
			}
		})
	})
	.on('click','.exit-stationery',function()
	{
		$('#detail').slideUp();
		$('.detail').removeAttr('disabled');
		$('#myModal').hide();
	})
	.on('click','.detail-computer', function()
	{
		$id = $(this).parents('tr').find('.id').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/report/administration/computer/detail") }}',
			data : {'id':$id},
			success : function(data)
			{
				$('#myModal').show().html(data);
				$('.detail-computer').attr('disabled','disabled');
			}
		})
	})
	.on('click','.exit-computer',function()
	{
		$('#detail').slideUp();
		$('.detail-computer').removeAttr('disabled');
		$('#myModal').hide();
  })
  .on('change','.js-enterprises,.js-enterprises-c',function(){
		$enterprise = $(this).val();
    if($(this).hasClass('js-enterprises'))
      $('.js-accounts').empty();
    else
      $('.js-accounts-c').empty();
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ url("/warehouse/stationery/accounts") }}',
			data 	: {'enterpriseid':$enterprise},
			success : function(data)
			{

				$.each(data,function(i, d) {
					option = '<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+' ('+d.content+')</option>';
          if($(this).hasClass('js-enterprises'))
            $('.js-accounts').append(option);
          else
            $('.js-accounts-c').append(option);
					
				});
			}
		})
	});

  function send_stationery(page) {

    swal({
      icon: '{{ url('images/load.gif') }}',
      button: false,
    });

    category      = $('select[name="cat"] option:selected').val();
    place_id      = $('select[name="place_id"] option:selected').val();
    idEnterprise	= $('select[name="idEnterprise"] option:selected').val();
    account_id	= $('select[name="account_id"] option:selected').val();
		concept 		  = $('input[name="concept"]').val();
		mindate			  = $('input[name="mindate"]').val();
    maxdate 		  = $('input[name="maxdate"]').val();

		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/warehouse/stationery/table") }}',
			data : {
          'idEnterprise':idEnterprise,
          'account_id':account_id,
          'place_id':place_id,
          'category': category,
					'concept':concept,
					'mindate':mindate,
          'maxdate':maxdate,
          'page':page,
      },
			success : function(response)
			{
        if(response.table.data.length === 0){
          $('#table-return').slideDown().html("<div id='not-found' style='display:block;'>Resultado no encontrado</div>");
          $('#pagination').html(response['pagination']);
          swal.close()
          return;
        }
        lots = response.table.data;
        table = 	"<form method='get' action='{{ route('warehouse.stationery.excel') }}' accept-charset='UTF-8' id='formsearch'>";
        if(idEnterprise)
          table +=	"<input type='hidden' name='enterprise_export' value='"+idEnterprise+"'>";
        if(account_id)
          table +=	"<input type='hidden' name='account_id_export' value='"+account_id+"'>";
        if(mindate)
          table +=	"<input type='hidden' name='min_export' value='"+mindate+"'>";
        if(concept)
          table += 	"<input type='hidden' name='concept_export' value='"+concept+"'>";
        if(maxdate)
          table +=	"<input type='hidden' name='max_export' value='"+maxdate+"'>";
        if(category)
          table += 	"<input type='hidden' name='category_export' value='"+category+"'>";
        if(place_id)
          table += 	"<input type='hidden' name='place_id_export' value='"+place_id+"'>";
        table += 	"<div style='float: right'><label class='label-form'>Exportar a Excel: </label><button class='btn btn-green export' type='submit'><span class='icon-file-excel'></span></button></div></form>";
        table += 	"<div class='table-responsive'>"+
              "<table class='table table-striped' id='table-warehouse'>"+
              "<thead class='thead-dark'>"+
              "<th>Cantidad</th>"+
              "<th>Concepto</th>"+
              "<th>Ubicación/sede</th>"+
              "<th>Acción</th>"+
              "</thead>";
        lots.forEach( lot => {
          table += 	
            "<tr>"+
              "<td>"+
              ""+ lot['quantity']+""+
              "</td>"+
              "<td>"+
              "" + lot['cat_c']['description'] + "" +
              "<input type='hidden' class='concept' value='" + lot['concept'] + "'>"+
              "</td>" +
              "<td>"+
                "" + (lot['place_location'] !== null ? lot['location']['place'] : "" ) + "" +
                "<input type='hidden' class='place_location' value='" + (lot['place_location'] !== null ? lot['place_location'] : "" ) + "'>"+
              "</td>"+
              "<td>" +
              "<button type='button' class='btn follow-btn detail-stationery' title='Detalles'>"+
              "<span class='icon-search'></span>"+
              "</button>"+
              "</td>"+
            "</tr>";
        })
        table += 	"</table>"+
              "</div>"+
              "<div id='detail'></div>"+
              "<br>";
        $('#pagination').html(response['pagination']);
        
        
        $('#table-return').slideDown().html(table);
        
        $('.page-link').on('click', function(e){
            e.preventDefault();

            page = $(this).text();
            if($(this).text() === "›"){

              if(response.table.current_page + 1 > response.table.last_page)
                return;
              page = response.table.current_page + 1
            }
            if($(this).text() === "‹"){
              if(response.table.current_page - 1 <= 0)
                return;
              page = response.table.current_page - 1
            }
            send_stationery(page)
        });
        swal.close()
        
      },
      error: function(error)
      {
        swal.close()
      }
		})
  }



  function send_computer() {

    swal({
      icon: '{{ url('images/load.gif') }}',
      button: false,
    });

		concept 		    = $('input[name="concept"]').val();
    type 		        = $('select[name="type"] option:selected').val();
    place_id 		    = $('select[name="place_id"] option:selected').val();
    account_id	    = $('select[name="account_id"] option:selected').val();
    enterprise_id   = $('select[name="idEnterprise"] option:selected').val();
    mindate			    = $('input[name="mindate"]').val();
    maxdate 		    = $('input[name="maxdate"]').val();

		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/warehouse/computer/table") }}',
			data : {
        'concept':concept,
        'type':type,
        'place_id':place_id,
        'account_id':account_id,
        'enterprise_id':enterprise_id,
        'mindate':mindate,
        'maxdate':maxdate,
        },
			success : function(response)
			{
				if(response.table.data.length === 0){
          $('#table-return').slideDown().html("<div id='not-found' style='display:block;'>Resultado no encontrado</div>");
          $('#pagination').html(response['pagination']);
          swal.close()
          return;
        }
        equipments = response.table.data;
        table = 	"<form method='get' action='{{ route('warehouse.computer.excel') }}' accept-charset='UTF-8' id='formsearch'>";
        if(concept)
          table +=	"<input type='hidden' name='concept_export' value='"+concept+"'>";
        if(type)
          table +=	"<input type='hidden' name='type_export' value='"+type+"'>";
        if(account_id)
          table +=	"<input type='hidden' name='account_export' value='"+account_id+"'>";
        if(enterprise_id)
          table +=	"<input type='hidden' name='enterprise_export' value='"+enterprise_id+"'>";
        if(mindate)
          table +=	"<input type='hidden' name='mindate_export' value='"+mindate+"'>";
        if(maxdate)
          table +=	"<input type='hidden' name='maxdate_export' value='"+maxdate+"'>";
        table += 	"<div style='float: right'><label class='label-form'>Exportar a Excel: </label><button class='btn btn-green export' type='submit'><span class='icon-file-excel'></span></button></div></form>";
        table += 	"<div class='table-responsive'>"+
              "<table class='table table-striped' id='table-computer'>"+
              "<thead class='thead-dark'>"+
              "<th>Cantidad</th>"+
              "<th>Producto/Material</th>"+
              "<th>Marca</th>"+
              "<th>Empresa</th>"+
              "<th>Cuenta</th>"+
              "<th>Ubicación/sede</th>"+
              "<th>Acción</th>"+
              "</thead>";
        route_edit = "{{ route("warehouse.computer.edit",["id"=>0]) }}"
        equipments.forEach( equipment =>{
          link = route_edit.slice(0, -1) + equipment['id']
          equip = "Smartphone";
          switch (equipment['type']) 
          {
            case "1":
              equip = "Smartphone";
              break;
  
            case "2":
              equip = "Tablet";
              break;
  
            case "3":
              equip = "Laptop";
              break;
  
            case "4":
              equip = "Desktop";
              break;
            
            default:
              break;
          }
          table += 	"<tr>"+
                "<td>"+
                ""+ equipment['quantity']+""+
                "</td>"+
                "<td>"+
                ""+ equip +""+
                "<input type='hidden' class='equip' value='"+ equip +"'>"+
                "</td>"+
                "<td>"+
                ""+ equipment['brand'] +""+
                "<input type='hidden' class='id' value='"+ equipment['id'] +"'>"+
                "</td>"+

                "<td>"+
                ""+ (equipment['idEnterprise'] ? equipment['enterprise']['name'] : "" ) +""+
                "</td>"+
                
                "<td>"+
                ""+ (equipment['account'] ? equipment['accounts']['account'] + ' '+ equipment['accounts']['description'] + ' ('+equipment['accounts']['content']+')' : "" ) +""+
                "</td>"+
                
                "<td>"+
                ""+ (equipment['place_location'] ? equipment['location']['place'] : "" ) +""+
                "</td>"+

                "<td>"+
                "<button type='button' class='btn follow-btn detail-computer' title='Detalles'>"+
                "<span class='icon-search'></span>"+
                "</button>"+
                "</td>"+

                "</tr>";
        })
						
						
        table += 	"</table>"+
              "</div>"+
              "<div id='detail'></div>"+
              "<br>";
        $('#pagination').html(response['pagination']);
        
        
        $('#table-return').slideDown().html(table);
        
        $('.page-link').on('click', function(e){
            e.preventDefault();

            page = $(this).text();
            if($(this).text() === "›"){

              if(response.table.current_page + 1 > response.table.last_page)
                return;
              page = response.table.current_page + 1
            }
            if($(this).text() === "‹"){
              if(response.table.current_page - 1 <= 0)
                return;
              page = response.table.current_page - 1
            }
            send_stationery(page)
        });
        swal.close()
      },
      error: function(error)
      {
        swal({
          title:'Error',
          text: "Ocurrió un problema, por favor verifique su red e intente nuevamente.",
          icon:'error',
        })
      }
		})
  }
  
</script>

@endsection