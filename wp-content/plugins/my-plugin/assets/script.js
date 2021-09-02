(function($) {

	$('#use_filter').on('click', function() {
		$(this).toggleClass('active')
		$('#my_plugin-filters form').toggle(200)
	})
    
    //добавим нужный метод
    $.fn.serializeObject = function(){
		var o = {}
		var a = this.serializeArray();
		$.each(a, function() {
           	if (o[this.name] !== undefined) {
               	if (!o[this.name].push) o[this.name] = [ o[this.name] ]

               	o[this.name].push(this.value || '')

           	} else o[this.name] = this.value || ''
        })

        return o
    }

	// change
	$('#my_plugin-filters form').submit(function(e){
		e.preventDefault()

		let form = filterState($(this))
		filterAjax(form)
	})


	const filterState = (form, action) => {
		let filter 	  = []
		let $load_more = $('#my_plugin-load_more')

 		if(action != 'load_more')
    		$load_more.attr('data-page', 1)

		$.each(form.serializeObject(), function( key, val ) {
			filter.push({
				val,
				type: 	  form.find(`[name='${key}']`).attr('type'),
				multiple: form.find(`[name='${key}']`).attr('multiple') ?? '',
				key: 	  form.find(`[name='${key}']`).attr('key'),
				name: 	  key
			})
		})

		return {
            action: 'mp_acf_filter',
            data: filter,
            page: $load_more.attr('data-page')
        }
	}

	const filterAjax = (form, action) => {
		let $list = $('#my_plugin-list ul')
		let $load_more = $('#my_plugin-load_more')

		$load_more.hide()
    	if(action != 'load_more') 
    		$list.html('<p style="text-align:center; margin:100px 0">...</p>')

        $.ajax({
            method: "POST",
            url: myajax.url,
            data: form,
            success: res => { 
            	let data = JSON.parse(res)

            	if (!data.list.length) 
            		return $list.html('Empty!')

            	if(action != 'load_more') 
            		$list.html('')

        		data.list.map( i => {
        			$list.append(`  <li class="box_post">
										<div class="box_img">${i.thumbnail}</div>
										<div class="box_content">	
											<a href="${i.link}"><div class="box_title"><h3>${i.title}</h3></div></a>
											<div class="box_text">${i.content}</div>
										</div>
									</li>`)
        			}
        		)

            	if(data.total_posts > $list.children().length) 
            		$load_more.show()
            }
        })
	}


	$('#my_plugin-load_more').on('click', function(){
		let page = $(this).attr('data-page')

		$(this).attr('data-page', Number(page) + 1)

		let form = filterState($('#my_plugin-filters form'), 'load_more')
		filterAjax(form, 'load_more')
	})


	// change
	$('.my_plugin-widget form').submit(function(e){
		e.preventDefault()

		let $list = $('.my_plugin-widget ul')

		$list.html('<p style="text-align:center; margin:50px 0">...</p>')

        $.ajax({
            method: "POST",
            url: myajax.url,
            data: {
                'action': 'mp_acf_widget',
                'data': $(this).find("[type='text']").val()
            },
            success: res => { 
            	let data = JSON.parse(res)
            	
            	if (!data.length) 
            		return $list.html('Empty!')

        		$list.html('')
        		data.map( i => $list.append(`<li><a href="${i.link}">${i.title}</a></li>`) )
            }
        })
	})

})(jQuery);