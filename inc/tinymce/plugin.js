jQuery( document ).ready(function() {



( function() {
	var defarr = ['#ffffff', '#26a69a', '#424242'];

	// console.log(payfacile_langs);
	tinymce.PluginManager.add( 'payfacile', function( editor, url ) {
		editor.addButton( 'payfacile_shortcode', {
			tooltip: 'Payfacile',
			icon: 'payfacile',
			onclick: function() {

				editor.windowManager.open( {
					title: 'Payfacile',
					bodyType: 'tabpanel',
					id:'payfacile-modal',
					buttons: [
						{
							text: payfacile_langs['insert_shortcode'],
							onclick: 'submit',
							classes: 'widget btn primary',
							minWidth: 200
						},
						{
							text: payfacile_langs['cancel'],
							onclick: 'close'
						}
					],
					body: [

						{
							title: payfacile_langs['button'],
							type: 'form',
							items: [
								{
									type: 'textbox',
									name: 'url',
									label: payfacile_langs['product_url'],
									value: '',
									tooltip: payfacile_langs['product_url_label']
								},
								{
				                    type   : 'container',
				                    name   : 'container',
				                    classes: 'fakelabel',
				                    html   : '<p>'+payfacile_langs['product_url_label']+'</p>'
				                },


								{
									type: 'textbox',
									id: 'text_button_check',
									name: 'textforbutton',
									classes: 'text_button_check',
									onKeyPress: function (e){
									  jQuery('.limiter').html( e.target.value.length+'/ 20')
										if(e.target.id =='text_button_check' && (e.target.value).length > 19){
											alert( payfacile_langs['limit_20_chars'] )
											return false;
										}
									},
									onKeyUp: function (e){

										jQuery('.limiter').html( e.target.value.length+'/ 20')
										if(e.target.id =='text_button_check' && (e.target.value).length > 19){
											alert( payfacile_langs['limit_20_chars'] )
											return false;
										}
									},
									label: payfacile_langs['button_text'],
									value: payfacile_langs['button_buy_default'],
									tooltip: payfacile_langs['button_label']

								},
				                {
									id: 'text_button_checkmessage',
				                    type   : 'container',
				                    name   : 'container',
				                    html   : '<span class="limiter"></span><p>&nbsp;</p>'
				                },
				                {
									id: 'color_a',
				                    type   : 'container',
				                    name   : 'containera',
				                    html   : '<p class="asbold">'+payfacile_langs['text_color']+'</p>'
				                },	
								{
                            		type   : 'textbox',
                           		    name   : 'colorpicker_text',
                            		label  : '-',
                            		classes :"color-picker",
                            		tooltip: payfacile_langs['choose_color'],
                            		value: '#ffffff',
                            		


                            		
                        		},
                        		{
									id: 'color_d',
				                    classes : 'asbold',
				                    type   : 'container',
				                    name   : 'contddaierb',
				                    html   : '<p>&nbsp;</p><p class="asbold">'+payfacile_langs['background_color']+'</p>'
				                },	
				          	
                        		{
                            		type   : 'textbox',
                           		    name   : 'colorpicker_bg',
                                    classes :"color-picker",
                                    tooltip: '-',
                            		label  : '-',
                            		value: '#26a69a'
                        		},
                        		{
									id: 'color_e',
				                    type   : 'container',
				                    name   : 'contdfgb',
				                    html   : '<p>&nbsp;</p>'
				                },	
                        		{
									type: 'listbox',
									name: 'target_window',
									label: payfacile_langs['type_of_target_window'],
									tooltip: payfacile_langs['type_of_target_window_label'],
									values : [
										{text: payfacile_langs['type_of_target_window_popup'], value: 'popup', selected: true},
										{text: payfacile_langs['type_of_target_window_new'], value: 'new'},
									]
								}
								
											
							]
						},

						{
							title: 'Widget',
							type: 'form',
							items: [
								{
									type: 'textbox',
									name: 'iframe_url',
									label: payfacile_langs['product_url'],
									value: '',
									tooltip: payfacile_langs['product_url_label']
								},
								{
				                    type   : 'container',
				                    name   : 'containerb',
				                    classes: 'fakelabel',
				                    html   : '<p>'+payfacile_langs['product_url_label']+'</p>'
				                },
								{
									type: 'textbox',
									name: 'iframe_width',
									label: payfacile_langs['iframe_width'],
									value: '100',
									tooltip: payfacile_langs['iframe_width_label']
								},
								{
									type: 'textbox',
									name: 'iframe_height',
									label: payfacile_langs['iframe_height'],
									value: '820',
									tooltip: payfacile_langs['iframe_height_label']
								},
								{
									id: 'color_ddq',
				                    type   : 'container',
				                    name   : 'dfg',
				                    html   : '<p class="asbold">'+payfacile_langs['outline_color']+'</p>'
				                },	
								{
                            		type   : 'textbox',
                           		    name   : 'colorpicker_outline',
                           		    id: 'colorpicker_outline',
                                    classes :"color-picker",
                            		tooltip: payfacile_langs['choose_color'],
                            		label  : '-',
                            		value: '#424242'
                        		},
                        		{
									id: 'color_oo',
				                    classes : 'asbold',
				                    type   : 'container',
				                    name   : 'conierb',
				                    html   : '<p>&nbsp;</p>'
				                },	
                        		{
									type: 'textbox',
									name: 'outline_width',
									label: payfacile_langs['outline_width'],
									value: 0,
									tooltip: payfacile_langs['outline_width_label']
								},
								{
				                    type   : 'container',
				                    name   : 'container',
				                    classes: 'fakelabel',
				                    html   : '<p class="right">'+payfacile_langs['outline_width_label']+'</p>'
				                },
							]
						},
					],
				


					onsubmit: function( e ) {
						

						
						var shortcode = '[payfacile';
						
						console.log(e.data)


						
						if(e.data.colorpicker_outline == ""){
							e.data.colorpicker_outline = defarr[2]
						}






						if(e.data.url !=='' ){
							shortcode += ' type_of=button';

						if(e.data.textforbutton == ""){
							e.data.textforbutton = payfacile_langs['button_buy_default']
						}

						//var replaced = (e.data.textforbutton).split(' ').join('__');

						if(e.data.colorpicker_text == ""){
							e.data.colorpicker_text = defarr[0]
						}
						if(e.data.colorpicker_bg == ""){
							e.data.colorpicker_bg = defarr[1]
						}

							shortcode += ' textbutton=' + e.data.textforbutton.replace(/\s/g, '_') +' ';
							shortcode += ' color_text=' + e.data.colorpicker_text +' ';
							shortcode += ' color_bg=' + e.data.colorpicker_bg +' ';
							if ( e.data.target_window ) shortcode += ' win_target=' + e.data.target_window+' ';


						if ( e.data.url ) shortcode += ' url=' + e.data.url +'';
						}
						if(e.data.iframe_url !== ''){
							shortcode += ' type_of=iframe';
							if ( e.data.iframe_url ) shortcode += ' url=' + e.data.iframe_url +'';
							//if ( e.data. ) shortcode += ' i=' + e.data. +'';
							if ( e.data.outline_width ) shortcode += ' outline_width=' + e.data.outline_width +'';
							if ( e.data.colorpicker_outline ) shortcode += ' outline_color=' + e.data.colorpicker_outline +'';
							if ( e.data.iframe_width ) shortcode += ' iframe_width=' + e.data.iframe_width +'';
							if ( e.data.iframe_height && e.data.iframe_height !=='ff'  ){
								shortcode += ' iframe_height=' + e.data.iframe_height +'';
							}
							else{
								shortcode += ' iframe_height=740 ' ;
							}
						}
						shortcode += ']';
						editor.insertContent( shortcode );
					} // onsubmit 

				});

				// init char counter
				jQuery('.limiter').html(jQuery('.mce-text_button_check').val().length+'/ 20')



				jQuery(".mce-color-picker").wpColorPicker({
					palettes:  ['#000000',
								defarr[0],
								defarr[1],
								defarr[2]
								],

					change:		function( event, ui ) {
						
						var hexcolor = jQuery( this ).wpColorPicker( 'color' );
						console.log(hexcolor)
						jQuery( this ).parent().parent().find('.color_preview').css('background', hexcolor);
							return hexcolor
						}

				 })
				jQuery('.wp-picker-container').each(function(r) { 
					 jQuery(this).append('<span class="color_preview" style="background-color:'+defarr[r]+';"></span>')
				 });

			
				jQuery( ".mce-color-picker" ).change(function() {
				 if(jQuery(this).val() == '' ){
				 	jQuery(this).val('#ffffff')
				 	jQuery( this ).parent().parent().find('.color_preview').css('background', '#fff');
				 }
				});





			} // onclick 



		
		});
	});


	
					

} )();







		

 })