(function() {	
	tinymce.create('tinymce.plugins.ya_Shortcodes', {
		init : function(ed, url){
			//do nothing
		},
		createControl : function(btn, e) {
			if ( btn == "ya_shortcodes_button" ) {
				var a = this;	
				var btn = e.createSplitButton('ya_button', {
	                title: "Insert Shortcode",
					image: yaShortcodesVars.url,
					icons: false,
	            });
	            btn.onRenderMenu.add(function (c, b) {
					a.render( b, "Icon", "icon" );
					a.render( b, "Buttons Type", "buttons" );
					a.render( b, "Alert", "alert" );
					a.render( b, "Bloginfo", "bloginfo" );
					a.render( b, "Row", "row" );
					a.render( b, "Column", "col" );
					a.render( b, "Google Map", "googlemap" );
					a.render( b, "Tabs", "tabs" );
					a.render( b, "Collapse", "collapse" );
					a.render( b, "Slideshow", "slideshow" );
					a.render( b, "Breadcrumb", "breadcrumb" );
					a.render( b, "Pricing", "pricing" );
					a.render( b, "Tooltip", "tooltip" );
					a.render( b, "Modal", "modal" );
					a.render( b, "Recent posts", "recent_posts" );
					a.render( b, "Gallery image", "gallery_image" );
					a.render( b, "Show one product", "ya_product" );
					a.render( b, "Show many products", "ya_products" );
				});
	            
	          return btn;
			}
			return null;               
		},
		render : function(ed, title, id) {
			ed.add({
				title: title,
				onclick: function () {
					
					// Icon
					if(id == "icon") {
						tinyMCE.activeEditor.selection.setContent('[icon name="*"]');
					}
					
					// Buttons Type
					if(id == "buttons") {
						tinyMCE.activeEditor.selection.setContent('[button id="" class="btn" type="primary" target="" href="#" tag="span"]link[/button]');
					}
					
					// Alert
					if(id == "alert") {
						tinyMCE.activeEditor.selection.setContent('[alert class="alert" type="success" dismiss="true" tag="div"][/alert]');
					}
					
					// Row
					if(id == "row") {
						tinyMCE.activeEditor.selection.setContent('[row class="" type="fluid" tag="div"][/row]');
					}
					
					// Column
					if(id == "col") {
						tinyMCE.activeEditor.selection.setContent('[col class="" tag="div" span="6"][/col]');
					}
					
					// Site URL
					if(id == "bloginfo") {
						tinyMCE.activeEditor.selection.setContent('[bloginfo show="wpurl" filter="raw"]');
					}
					
					// Google Map
					if(id == "googlemap") {
						tinyMCE.activeEditor.selection.setContent('[googlemaps title="Envato Office" location="Hoan Kiem District, Hanoi, Vietnam" zoom="10" Width="100%" height=250]');
					}
					
					// Tab
					if(id == "tabs") {
						tinyMCE.activeEditor.selection.setContent('[tabs position="top" class="tabs" tag="div"]<br />[tab title="Section 1"]Tab Content 1[/tab]<br />[tab title="Section 2"]Tab Content 2[/tab]<br />[tab title="Section 3"]Tab Content 3[/tab]<br />[/tabs]');
					}
					
					// Collapse
					if(id == "collapse") {
						tinyMCE.activeEditor.selection.setContent('[collapses class="collapses" tag="div"]<br/>[collapse title="Section 1"]Accordion Content 1[/collapse]<br/>[collapse title="Section 2"]Accordion Content 2[/collapse]<br/>[collapse title="Section 3"]Accordion Content 3[/collapse]<br/>[/collapses]');
					}
					
					// Slideshow
					if(id == "slideshow") {
						tinyMCE.activeEditor.selection.setContent('[slideshow ids="" caption="true" size="medium" interval="5000" event="slide" class=""]');
					}
					
					// Breadcrcumb
					if(id == "breadcrumb") {
						tinyMCE.activeEditor.selection.setContent('[breadcrumb class="breadcrumbs" tag="div"]');
					}
					//Pricing
					if(id == "pricing") {
						tinyMCE.activeEditor.selection.setContent('[pricing_table]<br />[pricing size="one-five" featured="no" plan="Basic" cost="$19.99" per="per month" button_url="#" button_text="Sign up now" button_target="self" button_rel="nofollow"]<br /><ul><li>30GB Storage</li><li>512MB Ram</li><li>10 databases</li><li>1,000 Emails</li><li>25GB Bandwidth</li></ul>[/pricing]<br />[/pricing_table]');
					}
					//Tooltip
					if(id == "tooltip") {
						tinyMCE.activeEditor.selection.setContent('[ya_tooltip content="content" orient="top"]Title[/ya_tooltip]');
					}
					//Modal
					if(id == "modal") {
						tinyMCE.activeEditor.selection.setContent('[ya_modal label="title" header="header" close="close" save="save"]Content[/ya_modal]');
					}
					//Recent posts
					if(id == "recent_posts") {
						tinyMCE.activeEditor.selection.setContent('[ya-recent-posts limit="6" title="Recent posts" num_column="3" id="1"]');
					}
					//Gallery images
					if(id == "gallery_image") {
						tinyMCE.activeEditor.selection.setContent('[gallery columns="4" ids="65,62,104,61"]');
					}
					if(id == "ya_product") {
						tinyMCE.activeEditor.selection.setContent('[ya_product id="429" lenght="10"]');
					}
					if(id == "ya_products") {
						tinyMCE.activeEditor.selection.setContent('[ya_products ids="687,689,691" sku=""]');
					}
					return false;
				}
			})
		}
	
	});
	tinymce.PluginManager.add("ya_shortcodes", tinymce.plugins.ya_Shortcodes);
})();  