(function() {
    tinymce.PluginManager.add('ya_shortcodes', function( editor, url ) {
        editor.addButton( 'ya_shortcodes', {
            title: 'Ya Shortcode Button',
			type: 'menubutton',
            icon: 'icon ya_shortcode_bt',
            menu: [
            	{
            		text: 'Icon',
            		value: '[icon name="*"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'buttons',
            		value: '[button id="" class="btn" type="primary" target="" href="#" tag="span"]link[/button]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
                {
            		text: 'videos',
            		value: '[videos w="" h="" site="" id=""]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
                {
            		text: 'audios',
            		value: '[soundcloud-audio identifier=""]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'alert',
            		value: '[alert class="alert" type="success" dismiss="true" tag="div"][/alert]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'col',
            		value: '[col class="" tag="div" span="6"][/col]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'bloginfo',
            		value: '[bloginfo show="wpurl" filter="raw"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},	
				{
            		text: 'googlemap',
            		value: '[googlemaps title="Envato Office" location="Hoan Kiem District, Hanoi, Vietnam" zoom="10" Width="100%" height=250]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'tabs',
            		value: '[tabs position="top" class="tabs" tag="div"]<br />[tab title="Section 1"]Tab Content 1[/tab]<br />[tab title="Section 2"]Tab Content 2[/tab]<br />[tab title="Section 3"]Tab Content 3[/tab]<br />[/tabs]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'collapse',
            		value: '[collapses class="collapses" tag="div"]<br/>[collapse title="Section 1"]Accordion Content 1[/collapse]<br/>[collapse title="Section 2"]Accordion Content 2[/collapse]<br/>[collapse title="Section 3"]Accordion Content 3[/collapse]<br/>[/collapses]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'slideshow',
            		value: '[slideshow ids="" caption="true" size="medium" interval="5000" event="slide" class=""]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'breadcrumb',
            		value: '[breadcrumb class="breadcrumbs" tag="div"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'pricing',
            		value: '[pricing_table]<br />[pricing size="one-five" featured="no" plan="Basic" cost="$19.99" per="per month" button_url="#" button_text="Sign up now" button_target="self" button_rel="nofollow"]<br /><ul><li>30GB Storage</li><li>512MB Ram</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li></ul>[/pricing]<br />[/pricing_table]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'tooltip',
            		value: '[ya_tooltip content="content" orient="top"]Title[/ya_tooltip]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'modal',
            		value: '[ya_modal label="title" header="header" close="close" save="save"]Content[/ya_modal]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'recent_posts',
            		value: '[ya-recent-posts limit="6" title="Recent posts" num_column="3" id="1"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'gallery_styles',
            		value: '[gallerys columns="4" ids="65,62,104,61"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		},
				{
            		text: 'gallery_image',
            		value: '[gallery columns="4" ids="65,62,104,61"]',
            		onclick: function() {
            			editor.insertContent(this.value());
            		}
           		}
           ]
        });
    });
})();