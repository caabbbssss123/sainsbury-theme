(function () {
	
	tinymce.PluginManager.add('wdm_mce_dropbutton', function (editor, url) {
		
		var menu_array = [];
		
		/*
		 * To add shortcodes based on post_type use
		 * if (typenow == 'page') {};
		 */
		
		menu_array.push({
			text: 'Blockquote',
			onclick: function () {
				editor.windowManager.open({
					title: 'Blockquote',
					body: [{
							type: 'textbox',
							name: 'quote',
							label: 'Quote'
						},
						{
							type: 'textbox',
							name: 'author',
							label: 'Author'
						}
					],
					onsubmit: function (e) {
						editor.insertContent('[blockquote quote="' + e.data.quote + '" author="' + e.data.author + '"]');
					}
				});
			}
		});
		
		menu_array.push({
			text: 'Boxed Content',
			onclick: function () {

				var values = [];

				shortcode_options.forEach(function (item, index) {

					if (item.shortcode_background == true) {
						values.push({text: item.label, value: item.value})
					}

				});

				editor.windowManager.open({
					title: 'Boxed Content',
					body: [{
						type: 'listbox',
						name: 'background_colour',
						label: 'Background Colour',
						values: values
					}],
					onsubmit: function (e) {
						editor.insertContent('[boxed_content background_colour="' + e.data.background_colour + '"]<p></p>[/boxed_content]');
					}
				});
			}
		});
		
		menu_array.push({
			text: 'Content Popup',
			onclick: function () {

				var values = [];

				shortcode_options.forEach(function (item, index) {

					if (item.shortcode_button == true) {
						values.push({text: item.label, value: item.value})
					}

				});

				editor.windowManager.open({
					title: 'Content Popup',
					body: [{
							type: 'textbox',
							name: 'button_title',
							label: 'Button Title'
						},
						{
							type: 'listbox',
							name: 'button_colour',
							label: 'Button Colour',
							values: values
						}
					],
					onsubmit: function (e) {
						editor.insertContent('[content_popup_button button_title="' + e.data.button_title + '" button_colour="' + e.data.button_colour + '"]<p></p>[/content_popup_button]');
					}
				});
			}
		});
		
		editor.addButton('wdm_mce_dropbutton', {
			text: 'Shortcodes',
			icon: false,
			type: 'menubutton',
			menu: menu_array
		});


	});
})();
