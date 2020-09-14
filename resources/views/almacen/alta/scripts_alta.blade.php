<script>
	$('#total_masiva,#amount_masiva,#uamount_masiva,#quantity_masiva').numeric({ negative : false, altDecimal: ".", decimalPlaces: 2 });
	$(document).ready(function() 
	{
		countbody = $('#body tr').length;
		if (countbody <= 0) 
		{
			$('#table,#table2').hide();
		}
		else
		{
			$('#table,#table2').show();
		}

		$enterprise = $('select[name="enterprise_id"] option:selected').val();
		if($enterprise)
		{
			search_accounts($enterprise,true)
		}
		
		
	});
	$('.quantity').numeric({ negative : false, decimal : false });
	$('.inversion, .amount,.uamount').numeric({ negative : false, altDecimal: ".", decimalPlaces: 2 });
	$(function()
	{
		$('#datepicker').datepicker({ dateFormat:'dd-mm-yy' });
	})
	$(document).on('click','#add',function()
	{


		categoty_id = $('select[name="category_id"] option:selected').val()
		category_name = $('select[name="category_id"] option:selected').text().trim()

		place_id = $('select[name="place_id"] option:selected').val()
		place_name = $('select[name="place_id"] option:selected').text().trim()

		measurement_id = $('select[name="measurement_id"] option:selected').val()
		measurement = $('select[name="measurement_id"] option:selected').text().trim()

		concept = $('input[name="concept_name"]').val()
		concept_id = $('input[name="concept_name_id"]').val()

		short_code = $('input[name="short_code"]').val().trim();
		long_code = $('input[name="long_code"]').val().trim();
		cant		= $('input[name="quantity"]').val().trim();
		uamount 		= $('input[name="uamount"]').val().trim();
		amount 		= $('input[name="amount"]').val().trim();
		comm		= $('textarea[id="commentaries"]').val().trim();

		iva_kind = $('input[name="iva_kind"]:checked').val()


		ivaCalc = 0
		switch(iva_kind)
			{
				case 'no':
					ivaCalc = 0;
					break;
				case 'a':
					ivaCalc = cant*uamount*iva;
					break;
				case 'b':
					ivaCalc = cant*uamount*iva2;
					break;
			}
		sub_total = (Number(uamount) * Number(cant))

		yes		= 0;
		$('#body tr').each(function()
		{
			exist = $(this).find(".tconcept").val();
			if (concept_id == exist) 
			{
				yes++;
			}
		});

		if(!categoty_id)
		{
			swal('', 'Debes seleccionar la categoría.', 'error');
			return
		}
		if(!place_id)
		{
			swal('', 'Debes seleccionar la ubicación/sede.', 'error');
			return
		}
		if(!measurement_id)
		{
			swal('', 'Debes seleccionar la unidad de medición.', 'error');
			return
		}

		if(yes>0)
		{
			swal('', 'Ya agrego un concepto con ese nombre', 'error');
		}
		
		else
		{
			if (comm == "") 
			{
				comm = "Sin comentarios";
			}
			if (category_name == "" || cant == "" || concept == "" || amount == "" || uamount == "")
			{
				if (cant == "") 
				{
					$('input[name="quantity"]').addClass('error');
				} 
				if (amount == "") 
				{
					$('input[name="amount"]').addClass('error');
				} 
				if (uamount == "") 
				{
					$('input[name="uamount"]').addClass('error');
				} 
				swal('', 'Favor de llenar los campos necesarios', 'error');
			}
			else
			{
				
				tr_table	= $('<tr></tr>')
							.append($('<td></td>')
								.append(category_name)
								.append($('<input readonly="true" class="input-table tcategory" type="hidden" name="tcategory_id[]"/>').val(categoty_id))
							)
							.append($('<td></td>')
								.append(concept)
								.append($('<input readonly="true" class="input-table tconcept" type="hidden" name="tconcept_name[]"/>').val(concept))
								.append($('<input readonly="true" class="input-table tconcept_id" type="hidden" name="tconcept_id[]"/>').val(concept_id))
							)
							.append($('<td></td>')
								.append(measurement)
								.append($('<input readonly="true" class="input-table tmeasurement" type="hidden" name="tmeasurement_id[]"/>').val(measurement_id))
							)
							.append($('<td></td>')
								.append(short_code)
								.append($('<input readonly="true" class="input-table short_code" type="hidden" name="tshort_code[]"/>').val(short_code))
							)
							.append($('<td></td>')
								.append(long_code)
								.append($('<input readonly="true" class="input-table long_code" type="hidden" name="tlong_code[]"/>').val(long_code))
							)
							.append($('<td></td>')
								.append(place_name)
								.append($('<input readonly="true" class="input-table place_id" type="hidden" name="tplace_id[]"/>').val(place_id))
							)
							.append($('<td></td>')
								.append(cant)
								.append($('<input readonly="true" class="input-table tquanty" type="hidden" name="tquanty[]"/>').val(cant))
							)
							.append($('<td></td>')
							.append($('<input readonly="true" class="input-table uamount" type="hidden" name="tuamount[]"/>').val(uamount))
								.append('$ '+Number(uamount).toFixed(2))
							)

							.append($('<td></td>')
								.append('$ '+Number(ivaCalc).toFixed(2))
								.append($('<input readonly="true" class="input-table tiva" type="hidden" name="tiva[]"/>').val(Number(ivaCalc).toFixed(2)))
								.append($('<input readonly="true" class="input-table tiva_kind" type="hidden" name="tiva_kind[]"/>').val(iva_kind))
								.append($('<input readonly="true" class="input-table tsub_total" type="hidden" name="tsub_total[]"/>').val(sub_total))
							)


							.append($('<td></td>')
								.append('$ '+Number(amount).toFixed(2))
								.append($('<input readonly="true" class="input-table importe" type="hidden" name="tamount[]"/>').val(amount))
							)
							.append($('<td style="display: inline-table;"></td>')
								.append($('<button id="edit" class="btn btn-blue edit-item" type="button"></button>')
									.append($('<span class="icon-pencil"></span>'))
								)
								.append($('<button class="delete-item"></button>')
									.append($('<span class="icon-x delete-span"></span>'))
								)
							);
				$('#body').append(tr_table);


				
				$('.js-category').val(null).trigger('change');
				$('.js-measurement').val(null).trigger('change');


				$('input[name="concept_name"]').val("");
				$('input[name="concept_name_id"]').val("");
				$('input[name="short_code"]').val("");
				$('input[name="long_code"]').val("");
				$('input[name="quantity"]').val("");
				$('input[name="uamount"]').val("");
				$('input[name="amount"]').val("");
				$('textarea[id="commentaries"]').val("");


				$('input[name="amount"]').removeClass("error");
				$('input[name="quantity"]').removeClass("error");
				remove_required_fields()

				countbody = $('#body tr').length;
				if (countbody <= 0) 
				{
					$('#table,#table2').hide();
				}
				else
				{
					$('#table,#table2').show();
				}

				totalArticles();
			}
		}
	})
	.on('change','.quantity,.uamount,.iva_kind',function()
		{
			cant	= $('input[name="quantity"]').val();
			precio	= $('input[name="uamount"]').val();
			iva		= ({{ App\Parameter::where('parameter_name','IVA')->first()->parameter_value }})/100;
			iva2	= ({{ App\Parameter::where('parameter_name','IVA2')->first()->parameter_value }})/100;
			totalImporte    = cant * precio;

			switch($('input[name="iva_kind"]:checked').val())
			{
				case 'no':
					ivaCalc = 0;
					break;
				case 'a':
					ivaCalc = cant*precio*iva;
					break;
				case 'b':
					ivaCalc = cant*precio*iva2;
					break;
			}
			totalImporte    = ((cant * precio)+ivaCalc);
			$('input[name="amount"]').val(totalImporte.toFixed(2));
	})
	.on('click','.delete-item',function()
	{
		$(this).parents('tr').remove();
		countbody = $('#body tr').length;
		if (countbody <= 0) 
		{
			$('#table,#table2').hide();
		}
		totalArticles();
	})
	.on('click','#addDoc',function()
	{
		newdoc	= $('<div class="docs-p"></div>')
					.append($('<div class="docs-p-l"></div>')
						.append($('<div class="uploader-content"></div>')
							.append($('<input type="file" name="path" class="input-text pathActioner" accept=".pdf,.jpg,.png">'))	
						)
						.append($('<input type="hidden" name="realPath[]" class="path">')
							)
					)
					.append($('<div class="docs-p-r"></div>')
						.append($('<button class="delete-doc" type="button"><span class="icon-x delete-span"></span></button>')
						)
					);
		$('#documents').append(newdoc);
		$(function() 
		{
			$( ".datepicker" ).datepicker({ maxDate: 0, dateFormat: "dd-mm-yy" });
		});
	})
	.on('change','.input-text.pathActioner',function(e)
	{
		filename		= $(this);
		uploadedName 	= $(this).parent('.uploader-content').siblings('input[name="realPath[]"]');
		extention		= /\.jpg|\.png|\.jpeg|\.pdf/i;
		
		if (filename.val().search(extention) == -1)
		{
			swal('', 'El tipo de archivo no es soportado, por favor seleccione una imagen jpg, png o un archivo pdf', 'warning');
			$(this).val('');
		}
		else if (this.files[0].size>315621376)
		{
			swal('', 'El tamaño máximo de su archivo no debe ser mayor a 300Mb', 'warning');
		}
		else
		{
			$(this).css('visibility','hidden').parent('.uploader-content').addClass('loading').removeClass(function (index, css)
			{
				return (css.match (/\bimage_\S+/g) || []).join(' '); // removes anything that starts with "image_"
			});
			formData	= new FormData();
			formData.append(filename.attr('name'), filename.prop("files")[0]);
			formData.append(uploadedName.attr('name'),uploadedName.val());


			$.ajax(
			{
				type		: 'post',
				url			: '{{ url("/warehouse/stationery/upload") }}',
				data		: formData,
				contentType	: false,
				processData	: false,
				success		: function(r)
				{
					if(r.error=='DONE')
					{
						$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading').addClass('image_'+r.extention);
						$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val(r.path);
					}
					else
					{
						swal('',r.message, 'error');
						$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
						$(e.currentTarget).val('');
						$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val('');
					}
				},
				error: function()
				{
					swal('', 'Ocurrió un error durante la carga del archivo, intente de nuevo, por favor', 'error');
					$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
					$(e.currentTarget).val('');
					$(e.currentTarget).parent('.uploader-content').siblings('input[name="realPath[]"]').val('');
				}
			})
		}
	})
	.on('click','.delete-doc',function()
	{
		swal(
		{
			icon	: '{{ url('images/load.gif') }}',
			button	: false
		});
		actioner		= $(this);
		uploadedName	= $(this).parent('.docs-p-r').siblings('.docs-p-l').children('input[name="realPath[]"]');
		formData		= new FormData();
		formData.append(uploadedName.attr('name'),uploadedName.val());
		$.ajax(
		{
			type		: 'post',
			url			: '{{ url("/warehouse/stationery/upload") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(r)
			{
				swal.close();
				actioner.parent('.docs-p-r').parent('.docs-p').remove();
			},
			error		: function()
			{
				swal.close();
				actioner.parent('.docs-p-r').parent('.docs-p').remove();
			}
		});
		$(this).parents('div.docs-p').remove();
	})
	.on('click','.edit-item',function()
	{
		$('input[name="amount"]').removeClass("error");
		$('input[name="quantity"]').removeClass("error");
		

		category_id = $(this).parents('tr').find('.tcategory').val();
		place_id = $(this).parents('tr').find('.place_id').val();
		measurement_id = $(this).parents('tr').find('.tmeasurement').val();
		concept = $(this).parents('tr').find('.tconcept').val();
		concept_name_id = $(this).parents('tr').find('.tconcept_id').val();
		cant = $(this).parents('tr').find('.tquanty').val();
		amount = $(this).parents('tr').find('.uamount').val();
		importe = $(this).parents('tr').find('.importe').val();
		short_code = $(this).parents('tr').find('.short_code').val();
		long_code = $(this).parents('tr').find('.long_code').val();
		comm = $(this).parents('tr').find('.comm').val();

		$('.js-category').val(category_id).trigger('change');
		$('.js-places').val(place_id).trigger('change');
		$('.js-measurement').val(measurement_id).trigger('change');

		$('input[name="concept_name"]').val(concept);
		$('input[name="concept_name_id"]').val(concept_name_id);
		$('input[name="quantity"]').val(cant);
		$('input[name="short_code"]').val(short_code);
		$('input[name="long_code"]').val(long_code);
		$('input[name="uamount"]').val(amount);
		$('input[name="amount"]').val(importe);
		$('textarea[id="commentaries"]').val( comm === "Sin comentarios" ? "" : comm );
		



		$(this).parents('tr').remove();

		
	})
	.on('change keyup paste click','input[name="search"]',function(){
		send_search()
	})
	.on('click', '.edit', function()
	{

		search_measurement_id = $('.search_lot_'+  $(this).val()  ).find('.search_measurement_id').val()
		search_place_id				= $('.search_lot_'+  $(this).val()  ).find('.search_place_id').val()

		search_measurement 		= $('.search_lot_'+  $(this).val()  ).find('.search_measurement').val()
		search_type 					= $('.search_lot_'+  $(this).val()  ).find('.search_type').html()
		search_concept				= $('.search_lot_'+  $(this).val()  ).find('.search_concept').html()
		search_short_code 		= $('.search_lot_'+  $(this).val()  ).find('.search_short_code').val()
		search_long_code 			= $('.search_lot_'+  $(this).val()  ).find('.search_long_code').val()
		search_price 					= $('.search_lot_'+  $(this).val()  ).find('.search_price').val()
		search_warehouseType 	= $('.search_lot_'+  $(this).val()  ).find('.search_warehouseType').val()
		
	
		$('input[name="concept_name_id"]').val($(this).val());
		$('.js-category').val(search_warehouseType).trigger('change');
		$('.js-places').val(search_place_id).trigger('change');
		$('.js-measurement').val(search_measurement_id).trigger('change');
		$('input[name="concept_name"]').val(search_concept);
		
		$('input[name="short_code"]').val(search_short_code === 'Sin SKU' ? "" : search_short_code);
		$('input[name="long_code"]').val(search_long_code);
		$('input[name="quantity"]').val("");
		$('input[name="uamount"]').val(Number(search_price));
		$('input[name="amount"]').val("");
		$('textarea[id="commentaries"]').val("");

		$('input[name="amount"]').removeClass("error");

		add_required_fields()
		show_edit_button()
		$('#table-search-container').slideUp();


	})
	.on('change','.js-enterprises',function(){
		$enterprise = $(this).val();
		search_accounts($enterprise)
	});

	function add_required_fields()
	{
		$('.js-category').select2({
			placeholder: 'Seleccione la categoría',
			language: "es",
			maximumSelectionLength: 1,
			disabled:true
		});
		$('.js-measurement').select2({
			placeholder: 'Seleccione la unidad (Medición)',
			language: "es",
			maximumSelectionLength: 1,
			disabled:true
		});
		$('.js-places').select2({
			placeholder: 'Seleccione la ubicación/sede',
			language: "es",
			maximumSelectionLength: 1,
			disabled:true
		});
		$('input[name="concept_name"]').attr('disabled',true)
		$('input[name="short_code"]').attr('disabled',true)
		$('input[name="long_code"]').attr('disabled',true)
		$('input[name="uamount"]').attr('disabled',true)
	}

	function remove_required_fields()
	{
		$('.js-category').select2({
			placeholder: 'Seleccione la categoría',
			language: "es",
			maximumSelectionLength: 1,
			disabled:false
		});
		$('.js-measurement').select2({
			placeholder: 'Seleccione la unidad (Medición)',
			language: "es",
			maximumSelectionLength: 1,
			disabled:false
		});
		$('.js-places').select2({
			placeholder: 'Seleccione la ubicación/sede',
			language: "es",
			maximumSelectionLength: 1,
			disabled:false
		});
		$('input[name="concept_name"]').attr('disabled',false)
		$('input[name="short_code"]').attr('disabled',false)
		$('input[name="long_code"]').attr('disabled',false)
		$('input[name="uamount"]').attr('disabled',false)
	}

	function send_search(page) {

    concept 		= $('input[name="search"]').val();
		$.ajax(
		{
			type : 'get',
			url  : '{{ url("/warehouse/stationery/search_w") }}',
			data : {
				'concept':concept,
				'page':page,
				'category_id': [
					@foreach ($category_id as $c)
						{{ $c }},
					@endforeach	
				]
				},
			success : function(response)
			{
        if(response.table.data.length === 0){
          $('#table-return').slideDown().html("<div id='not-found' style='display:block;'>Resultado no encontrado</div>");
          $('#pagination').html(response['pagination']);
          return;
        }
        lots = response.table.data;
        table = 	"<div class='table-responsive'>"+
              "<table class='table table-striped' id='table-warehouse'>"+
              "<thead class='thead-dark'>"+
              "<th>Cantidad</th>"+
              "<th>Concepto</th>"+
              "<th>Código corto</th>"+
              "<th>Código largo</th>"+
              "<th>Ubicación/sede</th>"+
              "<th>Categoría</th>"+
              "<th>Acción</th>"+
              "</thead>";
        lots.forEach( lot => {
          table += 	
            "<tr class='search_lot_"+lot['idwarehouse']+"'>"+
              "<td>"+
              "<label>"+ lot['quantity']+"</label>"+
              "</td>"+
              "<td>"+
              "<label class='search_concept'>" + lot['cat_c']['description'] + "</label>" +
              "</td>" +
              "<td>"+
              "<label class='short_code'>" + (lot['short_code'] !== null ? lot['short_code'] : "" ) + "</label>" +
              "</td>" +
              "<td>"+
              "<label class='long_code'>" + (lot['long_code'] !== null ? lot['long_code'] : "" ) + "</label>" +
              "</td>" +
              "<td>"+
              "<label class='long_code'>" + (lot['place_location'] !== null ? lot['location']['place'] : "" ) + "</label>" +
              "</td>" +
							"<td>"+
							"<label class='search_type'>" + lot['ware_house']['description'] + "</label>" +
              "</td>" +
              "<td>" +
								"<button type='button' class='btn btn-green edit' value='"+lot['idwarehouse']+"'>Seleccionar</button>"+
              "</td>";
								table +="<input type='hidden' class='search_warehouseType'  value='"+lot['warehouseType']+"'>";
							if(lot['measurement_d'])
								table +="<input type='hidden' class='search_measurement_id'  value='"+lot['measurement_d']['id']+"'>";
							else
								table +="<input type='hidden' class='search_measurement_id'  value=''>";
							if(lot['measurement_d'])
								table +="<input type='hidden' class='search_measurement'  value='"+lot['measurement_d']['description']+"'>";
							else
								table +="<input type='hidden' class='search_measurement'  value=''>";
							
							if(lot['short_code'])
								table +="<input type='hidden' class='search_short_code'  value='"+lot['short_code']+"'>";
							else
								table +="<input type='hidden' class='search_short_code'  value=''>";
							if(lot['long_code'])
								table +="<input type='hidden' class='search_long_code'  value='"+lot['long_code']+"'>";
							else
								table +="<input type='hidden' class='search_long_code'  value=''>";
							table +="<input type='hidden' class='search_place_id'  value='"+(lot['place_location'] !== null ? lot['place_location'] : "" )+"'>";

							table +="<input type='hidden' class='search_price'  value='"+(Number(lot['amount'])/Number(lot['quantityReal']))+"'>"+
            "</tr>";
        })
        table += 	"</table>"+
              "</div>"+
              "<div id='detail'></div>"+
              "<br>";
        $('#pagination').html(response['pagination']);
        
				$('#table-return').html(table);
        
        
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
            send_search(page)
        });
				$('#table-search-container').slideDown();
      },
		})
	}

	function search_accounts($enterprise,first = false,type='normal')
	{
		idAccAcc = Number($('#current_account_id').val());
		if(!first)
		{
			if(type=='normal')
				$('.js-accounts').empty();
			else
				$('.js-accounts-masiva').empty();
		}
		$.ajax(
		{
			type 	: 'get',
			url 	: '{{ url("/warehouse/stationery/accounts") }}',
			data 	: {'enterpriseid':$enterprise},
			success : function(data)
			{

				$.each(data,function(i, d) {
					if(idAccAcc !== d.idAccAcc)
						option = '<option value='+d.idAccAcc+'>'+d.account+' - '+d.description+' ('+d.content+')</option>';

						if(type=='normal')
							$('.js-accounts').append(option);
						else
							$('.js-accounts-masiva').append(option);
					
				});
			}
		})
	}

	function show_edit_button()
	{
		$('#edit_button').show();
	}
	function hidde_clean_button()
	{
		$('#clean_button').attr('hidden',true)
	}
	function hidde_edit_button()
	{
		$('#edit_button').hide()
	}

	function edit_material_button()
	{
		swal({
			title: "¿Editar artículo?",
			text: "Si el concepto es modificado se agregará un artículo nuevo.",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: ["Cancelar", "Aceptar"],
		})
		.then((edit) => {
		if (edit) {
			hidde_edit_button()
			remove_required_fields()
			$('input[name="concept_name_id"]').val("");
		}
	});
		
	}

	function clean_button()
	{
		hidde_edit_button()
		$('.js-category').val(null).trigger('change');
		$('.js-measurement').val(null).trigger('change');
		$('.js-places').val(null).trigger('change');
		$('input[name="concept_name"]').val("");
		$('input[name="concept_name_id"]').val("");
		$('input[name="short_code"]').val("");
		$('input[name="long_code"]').val("");
		$('input[name="quantity"]').val("");
		$('input[name="uamount"]').val("");
		$('input[name="amount"]').val("");
		$('textarea[id="commentaries"]').val("");
		remove_required_fields()
		$('input[name="amount"]').removeClass("error");
		$('input[name="quantity"]').removeClass("error");
		hidde_edit_button();
	}

	function totalArticles()
	{
		var sumatotal = 0;
		var sub_total_articles = 0;
		var iva_articles = 0;
		
		$('#body').find('tr').each (function() {
			valor = Number($(this).find('.importe').val());
			sumatotal = sumatotal + valor ;

			iva = Number($(this).find('.tiva').val());
			iva_articles = iva_articles + iva ;

			sub_total_articles = sub_total_articles + ( Number($(this).find('.tquanty').val()) * Number($(this).find('.uamount').val())) 
		});

		$('input[name="total_articles"]').val(Number(sumatotal).toFixed(2));
		$('input[name="iva_articles"]').val(Number(iva_articles).toFixed(2));
		$('input[name="sub_total_articles"]').val(Number(sub_total_articles).toFixed(2));
	}
  function updateSelectsAlta()
  {
    $('.js-enterprises').select2({
			placeholder: 'Seleccione la Empresa',
			language: "es",
			maximumSelectionLength: 1
		});
    $('.js-enterprises_masiva').select2({
			placeholder: 'Seleccione la Empresa',
			language: "es",
			maximumSelectionLength: 1
		});
		$('.js-concept').select2({
			placeholder: 'Seleccione el Artículo',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-places').select2({
			placeholder: 'Seleccione la ubicación/sede',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-places_masiva').select2({
			placeholder: 'Seleccione la ubicación/sede',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-category').select2({
			placeholder: 'Seleccione la categoría',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-category_masiva').select2({
			placeholder: 'Seleccione la categoría',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-measurement').select2({
			placeholder: 'Seleccione la unidad de medición',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-measurement_masiva').select2({
			placeholder: 'Seleccione la unidad de medición',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-accounts').select2({
			placeholder: 'Seleccione la cuenta',
			language: "es",
			maximumSelectionLength: 1,
		});
		$('.js-accounts-masiva').select2({
			placeholder: 'Seleccione la cuenta',
			language: "es",
			maximumSelectionLength: 1,
		});
  }
</script>