<script>
  var SubTotal = null
  var Total = null
  var Fecha = null
  var conceptops = []
  var realPath = []
  var lotId = null
  var currentArticleNumber = 0

	$(function()
	{
		$('#date_masiva').datepicker({ dateFormat:'dd-mm-yy' });
	})

  $('input[name="xmlfile"]').change(function(e){
    
    SubTotal = null
    Total = null
    Fecha = null
    conceptops = []
    realPath = []
    currentArticleNumber = 0

    var reader = new FileReader();
    reader.onload = function(e) {  
    var xmlDoc = $.parseXML(e.target.result);

    var comprobante = $(xmlDoc).find("cfdi\\:Comprobante");
    SubTotal = comprobante.attr('SubTotal')
    Total = comprobante.attr('Total')
    Fecha = comprobante.attr('Fecha')

    $(xmlDoc).find('cfdi\\:Concepto').each(function()
    {
      var Cantidad = $(this).attr('Cantidad')
      var Descripcion = $(this).attr('Descripcion')
      var ValorUnitario = $(this).attr('ValorUnitario')
      var Importe = Number($(this).attr('Importe'))
      var TotalConcepto = Importe

      $(this).find('cfdi\\:Traslado').each(function(){
        TotalConcepto += Number($(this).attr('Importe'))
      })
      $(this).find('cfdi\\:Retencion').each(function(){
        TotalConcepto -= Number($(this).attr('Importe'))
      })

      conceptops.push({
        Cantidad,
        Descripcion,
        PrecioUnitario: ValorUnitario,
        Importe:TotalConcepto,
      })
    })
    }
    reader.readAsText(e.target.files[0]);  

    

    swal(
    {
      closeOnClickOutside:false,
      closeOnEsc:false,
      icon	: '{{ url('images/load.gif') }}',
      button	: false
    });
    var fileName = e.target.files[0].name;

    formData	= new FormData();
		formData.append('fileName', fileName);
		$.ajax(
		{
			type		: 'post',
			url			: '{{ url("/warehouse/stationery/fileName") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(data)
			{
        
        if(!data.exist){
          swal.close();
          show_form_create_lot()
          updateSelectsAlta()
          new_masiva()
        }
        else{
          if(data.finish){
            reset_form()
            swal('','Los artículos ya han sido dados de alta.','error')
          }else{
            swal.close()
            swal({
              title: "Hay un lote con este nombre de archivo",
              text: "Puede continuar registrando los artículos.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((response) => {
              if (response) {
                lotId = data.lot.idlot
                currentArticleNumber = data.articles_count
                new_masiva()
                show_articles_details_form()
                updateSelectsAlta()
              }else{
                reset_form()
              }
          });
          }
        }
				
			},
			error		: function()
			{
				swal.close();
        swal('', 'Error al guardar la información', 'error')
			}
		});
  });

  function remove_doc()
  {
    $input = $('input[name="xmlfile"]').parent('.uploader-content')
    $('input[name="xmlfile"]').val("")

    $('form_create_lot').slideDown('fast')
    $('articles_count_container').slideDown('fast')
    $('articles_details_form').slideDown('fast')

  }

  $('#help-btn-lote').click( function(){
    swal({
      title: "Ayuda",
      text: "Al enviar los datos de la solicitud podras continuar despues si subes el mismo documento.",
      icon: "info",
      buttons: 
      {
        cancel: false,
        confirm: true,
      },
    })
    
  })

  $('button[name="addDocMasiva"]').click(function()
	{
    newdoc	= $('<div class="docs-p"></div>')
        .append($('<div class="docs-p-l"></div>')
          .append($('<div class="uploader-content"></div>')
            .append($('<input type="file" name="pathMasiva" class="input-text pathActionerMasiva" accept=".pdf,.jpg,.png">'))	
          )
          .append($('<input type="hidden" class="pathMasiva">')
            )
        )
        .append($('<div class="docs-p-r"></div>')
          .append($('<span id="delete-doc-masiva" class="icon-x delete-span"></span>')
          )
        );
    $('#documentsMasiva').append(newdoc);
  })

  $(document).on('click','#delete-doc-masiva',function()
	{
		swal(
		{
      closeOnClickOutside:false,
      closeOnEsc:false,
			icon	: '{{ url('images/load.gif') }}',
			button	: false
		});
		actioner		= $(this);
		uploadedName	= $(this).parent('.docs-p-r').siblings('.docs-p-l').children('.pathMasiva');
		formData		= new FormData();
		formData.append("realPath[]",uploadedName.val());
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

  $(document).on('change','.pathActionerMasiva',function(e)
	{
		filename		= $(this);
		uploadedName 	= $(this).parent('.uploader-content').siblings('.pathMasiva');
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
				return (css.match (/\bimage_\S+/g) || []).join(' ');
			});
			formData	= new FormData();
			formData.append('path', filename.prop("files")[0]);
			formData.append('realPath[]','');
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
						$(e.currentTarget).parent('.uploader-content').siblings('.pathMasiva').val(r.path);
					}
					else
					{
						swal('',r.message, 'error');
						$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
						$(e.currentTarget).val('');
						$(e.currentTarget).parent('.uploader-content').siblings('.pathMasiva').val('');
					}
				},
				error: function()
				{
					swal('', 'Ocurrió un error durante la carga del archivo, intente de nuevo, por favor', 'error');
					$(e.currentTarget).removeAttr('style').parent('.uploader-content').removeClass('loading');
					$(e.currentTarget).val('');
					$(e.currentTarget).parent('.uploader-content').siblings('.pathMasiva').val('');
				}
			})
		}
	})


  function new_masiva()
  {
    hide_concepto_sugerido_container()
    show_concept_container()
    hide_documents_masiva()
    $('#date_masiva').val($.datepicker.formatDate('dd-mm-yy', new Date(Fecha)))
    $('#total_masiva').val(Total)
    $('#sub_total_masiva').val(SubTotal)


    $('.js-measurement_masiva').val(null).trigger('change');
    $('.js-places_masiva').val(null).trigger('change');

    $('#measurement_quantity_masiva').val("")
    $('#concept_name_masiva').val(conceptops[currentArticleNumber].Descripcion)
    $('#short_code_masiva').val("")
    $('#long_code_masiva').val("")
    $('#quantity_masiva').val(conceptops[currentArticleNumber].Cantidad)
    $('#uamount_masiva').val(conceptops[currentArticleNumber].PrecioUnitario)
    $('#amount_masiva').val(conceptops[currentArticleNumber].Importe)
    $('#commentaries_masiva').val("")

    $('#articles_count').html("Artículos: "+ (currentArticleNumber+1)+ "/" +conceptops.length)
    $("#concept_name_masiva_sugerido_check").prop("checked", false);

    search_concept()
  }


  $('#masiva_siguiente').click( function()
  {
    swal(
    {
      closeOnClickOutside:false,
      closeOnEsc:false,
      icon	: '{{ url('images/load.gif') }}',
      button	: false
    });
    var files = $('input[name="xmlfile"]').prop('files');
    if(!files)
    {
      swal.close()
      swal('', 'No se encontro ningun archivo', 'error')
      return
    }
    
    if($('.js-enterprises_masiva').val().length == 0)
    {
      swal('','Debes seleccionar una empresa.','error')
      return
    }
    if($('.js-accounts-masiva').val().length == 0)
    {
      swal('','Debes seleccionar una cuenta.','error')
      return
    }
    $('.pathMasiva').each(function(){
      realPath.push($(this).val())
    })
    if(realPath.length == 0)
    {
      swal({
        title: "Error",
        text: "Debe agregar al menos un ticket de compra.",
        icon: "error",
        buttons: 
        {
          confirm: true,
        },
      });
      return
    }

    formData	= new FormData();
		formData.append('fileName', files[0].name);
		formData.append('sub_total', $('#sub_total_masiva').val());
		formData.append('total', $('#total_masiva').val());
    formData.append('fecha', $('#date_masiva').val());
    formData.append('idEnterprise', $('.js-enterprises_masiva').val());
    formData.append('idAccount', $('.js-accounts-masiva').val());
    $('.pathMasiva').each(function(){
      formData.append('realPath[]', $(this).val());
    })

		$.ajax(
		{
			type		: 'post',
			url			: '{{ url("/warehouse/stationery/create_lot_file") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(data)
			{
        lotId = data.lot.idlot
        hide_form_create_lot()
        show_articles_details_form()
        updateSelectsAlta()
        swal.close();
			},
			error		: function()
			{
				swal.close();
        swal('', 'Error al guardar la información', 'error')
			}
		});
  })

  $('#masiva_send_article').click(function(){

    if($('.js-category_masiva').val().length == 0)
    {
      swal('','Debes seleccionar una categoría.','error')
      return
    }
    if($('.js-measurement_masiva').val().length == 0)
    {
      swal('','Debes seleccionar la unidad de medición.','error')
      return
    }
    if($('.js-places_masiva').val().length == 0)
    {
      swal('','Debes seleccionar la ubicación/sede.','error')
      return
    }

    concept = $('#concept_name_masiva_sugerido_check').is(":checked") ? $('#concept_name_masiva_sugerido').val() : $('#concept_name_masiva').val()
    
    quanty = $('#quantity_masiva').val()
    short_code = $('#short_code_masiva').val()
    long_code = $('#long_code_masiva').val()
    measurement_id = $('.js-measurement_masiva').val()
    place_id = $('.js-places_masiva').val()
    measurement_quantity = $('#measurement_quantity_masiva').val()
    commentaries = $('#commentaries_masiva').val()
    amount = $('#amount_masiva').val()
    idlot = lotId
    category_id = $('.js-category_masiva').val()
    iva_kind = $('input[name="masiva_iva_kind"]:checked').val()
    uamount= $('input[name="uamount_masiva"]').val()

    

    finish = (currentArticleNumber + 1) == conceptops.length ? true : false;

    swal(
    {
      closeOnClickOutside:false,
      closeOnEsc:false,
      icon	: '{{ url('images/load.gif') }}',
      button	: false
    });

    formData	= new FormData();
		formData.append('concept',concept)
		formData.append('quanty',quanty)
    formData.append('short_code',short_code)
    formData.append('long_code',long_code)
		formData.append('measurement_id',measurement_id)
		formData.append('measurement_quantity',measurement_quantity)
		formData.append('place_id',place_id)
    formData.append('commentaries',commentaries)
    formData.append('amount',amount)
    formData.append('idlot',idlot)
    formData.append('category_id',category_id)
    formData.append('finish',finish)
    formData.append('iva_kind',iva_kind)
    formData.append('uamount',uamount)
    


		$.ajax(
		{
			type		: 'post',
			url			: '{{ url("/warehouse/stationery/create_warehouse") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(data)
			{
        if(data.status)
        {
          scrollTop()
          currentArticleNumber +=1;

          if(currentArticleNumber == conceptops.length)
          {
            swal('', 'Registro finalizado exitosamente.', 'success')
            reset_form()
          }else{
            new_masiva()
            swal('', 'Artículo guardado', 'success')
          }
        }
        else
        {
          swal('', 'Error al guardar la información', 'error')
        }
			},
			error		: function()
			{
        swal('', 'Error al guardar la información', 'error')
			}
		});

  })


  function search_concept()
  {
    str = conceptops[currentArticleNumber].Descripcion.toLowerCase().split(" ")
    var array = str.filter( s => {
      if(s.length == 1)
      {
        if((s.match(/[aeiou]/gi)))
          return false
      }
      else if(
        s.match("\\by\\b") ||
        s.match("\\bde\\b") ||
        s.match("\\bdel\\b") ||
        s.match("\\bpara\\b") ||
        s.match("\\bal\\b") ||
        s.match("\\bcon\\b")  ||
        s.match("\\ben\\b") 
        )
        return false
      else
        return true
      
      })
    
    swal(
    {
      closeOnClickOutside:false,
      closeOnEsc:false,
      icon	: '{{ url('images/load.gif') }}',
      button	: false
    });
    
    formData	= new FormData();
    array.forEach(e => {
      formData.append('search[]',e);
    });

    $.ajax(
		{
			type		: 'post',
			url			: '{{ url("/warehouse/stationery/search_concept") }}',
			data		: formData,
			contentType	: false,
			processData	: false,
			success		: function(data)
			{
        if(data.concept)
        {
          $('#concept_name_masiva_sugerido').val(data.concept.description)
          show_concepto_sugerido_container()
        }
        swal.close();
			},
			error		: function()
			{
				swal.close();
        swal('', 'Error al buscar concepto.', 'error')
			}
		});
  }

  $(document).on('change','#concept_name_masiva_sugerido_check',function(){
    if($(this).is(":checked"))
      hide_concept_container()
    else
      show_concept_container()
  })
  $(document).on('click','#clean_masiva',function(){
    reset_form()
  })
  $(document).on('change','#quantity_masiva,#uamount_masiva',function()
		{
			cant	= $('input[name="quantity_masiva"]').val();
			precio	= $('input[name="uamount_masiva"]').val();
			totalImporte    = cant * precio;
			$('input[name="amount_masiva"]').val(totalImporte.toFixed(2));
	})
  .on('change','.js-enterprises_masiva',function(){

		$enterprise = $(this).val();
		search_accounts($enterprise,false,'masiva')
	});

  function reset_form() {
    $input = $('input[name="xmlfile"]').parent('.uploader-content')
    $input.removeClass('image_xls')
    $('input[name="xmlfile"]').val("")
    Total = null
    Fecha = null
    conceptops = []
    realPath = []
    currentArticleNumber = 0
    $('#date_masiva').val("")
    $('#total_masiva').val("")
    $('#concept_name_masiva').val("")
    $('#short_code_masiva').val("")
    $('#long_code_masiva').val("")
    $('#quantity_masiva').val("")
    $('#uamount_masiva').val("")
    $('#amount_masiva').val("")
    $('#commentaries_masiva').val("")
    $('#articles_count').html("Artículos: 1/")
    $("#concept_name_masiva_sugerido_check").prop("checked", false);

    hide_form_create_lot()
    hide_articles_details_form()
    show_documents_masiva()
  }

  function show_documents_masiva()
  {
    $('#documents_masiva').slideDown("fast")
  }
  function hide_documents_masiva()
  {
    $('#documents_masiva').slideUp("fast")
  }

  function show_form_create_lot()
  {
    $('#form_create_lot').slideDown('fast')
  }
  function hide_form_create_lot() {
    $('#form_create_lot').slideUp('fast')
  }
  function show_articles_details_form()
  {
    $('#articles_details_form').slideDown('fast')
  }
  function hide_articles_details_form()
  {
    $('#articles_details_form').slideUp('fast')
  }
  function show_concepto_sugerido_container()
  {
    $('#concepto_sugerido_container').slideDown('fast')
  }
  function hide_concepto_sugerido_container()
  {
    $('#concepto_sugerido_container').slideUp('fast')
  }
  function show_concept_container()
  {
    $('#concept_container').slideDown('fast')
  }
  function hide_concept_container()
  {
    $('#concept_container').slideUp('fast')
  }

  function scrollTop() {
    $('.container-right-content').scrollTop(0);
  }
</script>