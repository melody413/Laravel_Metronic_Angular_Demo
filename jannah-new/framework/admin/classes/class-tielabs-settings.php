<?php
/**
 * Build the theme settings
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_SETTINGS' ) ) {

	class TIELABS_SETTINGS {

		public $item_id;
		public $item_id_attr;
		public $item_id_wrap;
		public $name_attr;
		public $placeholder_attr;
		public $custom_class;
		public $current_value;
		public $option_type;
		public $settings;

		/**
		 * __construct
		 */
		function __construct( $settings, $option_name, $data ) {

			$this->prepare_data( $settings, $option_name, $data );

			if( empty( $this->option_type ) ){
				return;
			}

			// Options Without Labels
			$with_label = false;

			switch ( $this->option_type ) {
				case 'tab-title':
					$this->tab_title();
					break;

				case 'header':
						$this->section_head();
						break;

				case 'message':
				case 'success':
				case 'error':
						$this->notice_message();
						break;

				case 'hidden':
						$this->hidden();
						break;

				case 'html':
						$this->html();
						break;

				default:
					$with_label = true;
					break;
			}


			// Options With Label
			if( $with_label ){

				/** Option Start */
				$this->option_head();

				/** The Option */
				switch ( $this->option_type ) {
					case 'text':
						$this->text();
						break;

					case 'arrayText':
						$this->text_array();
						break;

					case 'number':
						$this->number();
						break;

					case 'radio':
						$this->radio();
						break;

					case 'checkbox':
						$this->checkbox();
						break;

					case 'select-multiple':
						$this->multiple_select();
						break;

					case 'textarea':
						$this->textarea();
						break;

					case 'color':
						$this->color();
						break;

					case 'editor':
						$this->editor();
						break;

					case 'fonts':
						$this->fonts();
						break;

					case 'upload':
						$this->upload();
						break;

					case 'upload-font':
						$this->upload_font();
						break;

					case 'typography':
						$this->typography();
						break;

					case 'background':
						$this->background();
						break;

					case 'select':
						$this->select();
						break;

					case 'visual':
						$this->visual();
						break;

					case 'gallery':
						$this->gallery();
						break;

					case 'icon':
						$this->icon();
						break;

					case 'select_image':
						$this->select_image();
						break;

					default:
						break;
				}


				/** Option END */
				if( $this->option_type != 'upload' ){
					$this->hint();
				}

				echo '</div>';
				/**/

			}
		}


		/**
		 * HTML code
		 */
		private function html(){

			if( ! empty( $this->settings['content'] ) ){
				echo $this->settings['content'];
			}
		}


		/**
		 * Setting Description
		 */
		private function hint(){

			if( ! empty( $this->settings['hint'] ) ){
				?>
				<span class="extra-text">
					<?php echo $this->settings['hint'] ?>
				</span>
				<?php
			}
		}


		/**
		 * Upload
		 */
		private function upload(){

			$upload_button = ! empty( $this->settings['custom_text'] ) ? $this->settings['custom_text'] : esc_html__( 'Upload', TIELABS_TEXTDOMAIN );
			$image_preview = ! empty( $this->current_value ) ? $this->current_value : TIELABS_TEMPLATE_URL.'/framework/admin/assets/images/empty.png';
			$hide_preview  = ! empty( $this->current_value ) ? '' : 'style="display:none"';
			?>

			<div class="image-preview-wrapper">
				<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> class="tie-img-path" type="text" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?>>
				<input id="<?php echo 'upload_'. $this->item_id .'_button' ?>" type="button" class="tie-upload-img button" value="<?php echo $upload_button ?>">

				<?php $this->hint(); ?>
			</div>

			<div id="<?php echo $this->item_id . '-preview' ?>" class="img-preview" <?php echo $hide_preview ?>>
				<img loading="lazy" src="<?php echo $image_preview ?>" alt="">
				<a class="del-img"></a>
			</div>
			<div class="clear"></div>
			<?php
		}


		/**
		 * Upload Font
		 */
		private function upload_font(){

			$upload_button = ! empty( $this->settings['custom_text'] ) ? $this->settings['custom_text'] : esc_html__( 'Upload', TIELABS_TEXTDOMAIN );
			?>

			<div class="image-preview-wrapper">
				<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> class="tie-font-path" type="text" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?>>
				<input id="<?php echo 'upload_'. $this->item_id .'_button' ?>" type="button" class="tie-upload-font button" value="<?php echo $upload_button ?>">

				<?php $this->hint(); ?>
			</div>
			<?php
		}


		/**
		 * Text
		 */
		private function text(){
			?>
				<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> type="text" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?>>
			<?php
		}


		/**
		 * Text Array
		 */
		private function text_array(){

			$key = $this->settings['key'];
			$single_name = $this->option_name . '['. $key .']';
			$current_value = ! empty( $this->current_value[ $key ] ) ? $this->current_value[ $key ] : '';

			?>
				<input name="<?php echo $single_name ?>" type="text" value="<?php echo $current_value ?>" <?php echo $this->placeholder_attr ?>>
			<?php
		}


		/**
		 * Checkbox
		 */
		private function checkbox(){

			$checked = checked( $this->current_value, 'true', false );

			$toggle_data  = ! empty( $this->settings['toggle'] ) ? 'data-tie-toggle="'. $this->settings['toggle'] .'"' : '';
			$toggle_class = ! empty( $this->settings['toggle'] ) ? 'tie-toggle-option' : '';

			//echo '<input type="hidden"'. $this->name_attr .' value="-tie-101" />';

			?>
				<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> class="tie-js-switch <?php echo $toggle_class ?>" <?php echo $toggle_data ?> type="checkbox" value="true" <?php echo $checked ?>>
			<?php
		}


		/**
		 * Radio
		 */
		private function radio(){

			?>
			<div class="option-contents">
				<?php
					$i = 0;
					foreach ( $this->settings['options'] as $option_key => $option ){
						$i++;

						$checked = '';
						if ( ( ! empty( $this->current_value ) && $this->current_value == $option_key ) || ( empty( $this->current_value ) && $i==1 ) ){
							$checked = 'checked="checked"';
						}

						?>
							<label>
								<input <?php echo $this->name_attr ?> <?php echo $checked ?> type="radio" value="<?php echo $option_key ?>"> <?php echo $option ?>
							</label>
						<?php
					}

				?>
			</div>
			<div class="clear"></div>

			<?php
				if( empty( $this->settings['toggle'] ) ){
					return;
				}
			?>

			<script>
				jQuery(document).ready(function(){
					jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).hide();
					<?php
						if( isset( $this->settings['toggle'][ $this->current_value ] ) ){ // For the option that doesn't have sub option such as the Logo > Title option
							if( ! empty( $this->settings['toggle'][ $this->current_value ] ) ){ ?>
							jQuery( '<?php echo esc_js( $this->settings['toggle'][ $this->current_value ] ) ?>' ).show();
							<?php
							}
						}
						elseif( is_array( $this->settings['toggle'] ) ){
							$first_elem = reset( $this->settings['toggle'] ) ?>
							jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
							<?php
						}
					?>

					jQuery("input[name='<?php echo esc_js( $this->option_name ) ?>']").change(function(){
						selected_val = jQuery( this ).val();
						jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).slideUp('fast');
						<?php
							foreach( $this->settings['toggle'] as $tg_item_name => $tg_item_id ){
								if( ! empty( $tg_item_id ) ){ ?>

									if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
										jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');
									}
								<?php
								}
							}
						?>
					 });
				});
			</script>
			<?php
		}


		/**
		 * Multiple Select
		 */
		private function multiple_select(){
			?>
			<select name="<?php echo $this->option_name.'[]' ?>" <?php echo $this->item_id_attr ?> multiple="multiple">

				<?php

					$data = maybe_unserialize( $this->current_value );

					$i = 0;
					foreach ( $this->settings['options'] as $option_key => $option ){
						$selected = '';
						if ( ( ! empty( $data ) && !is_array( $data ) && $data == $option_key ) || ( ! empty( $data) && is_array($data) && in_array( $option_key , $data ) ) || ( empty( $data ) && $i==1 ) ){
							$selected = 'selected="selected"';
						}

						?>
							<option value="<?php echo $option_key ?>" <?php echo $selected ?>><?php echo $option ?></option>
						<?php
					}
				?>
			</select>
			<?php
		}


		/**
		 * Textarea
		 */
		private function textarea(){
			?>
				<textarea <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> rows="3"><?php echo esc_textarea( $this->current_value ) ?></textarea>
			<?php
		}


		/**
		 * Color
		 */
		private function color(){

			$custom_class = ! empty( $this->settings['color_class'] ) ? $this->settings['color_class'] : 'tieColorSelector';
			$theme_color  = tie_get_option( 'global_color', '#000000' );
			?>

				<div class="tie-custom-color-picker">
					<input class="<?php echo $custom_class ?>" <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> type="text" value="<?php echo $this->current_value ?>" data-palette="<?php echo $theme_color ?>, #9b59b6, #3498db, #2ecc71, #f1c40f, #34495e, #e74c3c" style="width:80px;">
				</div>
			<?php
		}


		/**
		 * Editor
		 */
		private function editor(){

			// Settings
			$settings = ! empty( $this->settings['editor'] ) ? $this->settings['editor'] : array( 'editor_height' => '400px', 'media_buttons' => false );
			$settings['textarea_name'] = $this->option_name;

			$this->current_value = ! empty( $this->settings['kses'] ) ? wp_kses_stripslashes( stripslashes( $this->current_value ) ) : $this->current_value;

			wp_editor(
				$this->current_value,
				$this->item_id,
				$settings
			);

		}


		/**
		 * Fonts
		 */
		private function fonts(){
			?>
    		<input <?php echo $this->name_attr ?> <?php echo $this->item_id_attr ?> class="tie-select-font" type="text" value="<?php echo esc_attr( $this->current_value ) ?>">
    	<?php
		}


		/**
		 * Tab Title
		 */
		private function tab_title(){
			?>
			<div class="tie-tab-head">
				<h2>
					<?php

						echo $this->settings['title'];

						if( ! empty( $this->settings['id'] ) ){
							do_action( 'TieLabs/admin_after_tab_title', $this->settings['id'] );
						}
					?>
				</h2>

				<?php do_action( 'TieLabs/save_button' ); ?>

				<div class="clear"></div>
			</div>
			<?php
		}


		/**
		 * Notice Message
		 */
		private function notice_message(){

			$this->custom_class .= ' tie-message-hint';

			if( $this->option_type == 'error' ){
				$this->custom_class .= ' tie-message-error';
			}
			elseif( $this->option_type == 'success' ){
				$this->custom_class .= ' tie-message-success';
			}

			?>
				<div <?php echo $this->item_id_wrap ?> class="<?php echo $this->custom_class ?>"><?php echo $this->settings['text'] ?></div>
			<?php
		}


		/**
		 * Hidden
		 */
		private function hidden(){
			?>
				<input <?php echo $this->name_attr ?> type="hidden" value="<?php echo esc_attr( $this->current_value ) ?>">
			<?php
		}


		/**
		 * Number
		 */
		private function number(){
			?>
			<input style="width:60px" min="-1000" <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> type="number" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?>>
			<?php
		}


		/**
		 * Section Head
		 */
		private function section_head(){
			?>

			<h3 <?php echo $this->item_id_attr ?> class="tie-section-title <?php echo $this->custom_class ?>">
				<?php

					echo $this->settings['title'];

					if( ! empty( $this->settings['id'] ) ){
						do_action( 'TieLabs/admin_after_head_title', $this->settings['id'] );
					}
				?>
			</h3>

			<?php
		}


		/**
		 * Option Head
		 */
		private function option_head(){
			?>

			<div <?php echo $this->item_id_wrap ?> class="option-item <?php echo $this->custom_class ?>">

			<?php

			if( ! empty( $this->settings['pre_text'] ) ){
				?>
					<div class="tie-option-pre-label"><?php echo $this->settings['pre_text'] ?></div>
					<div class="clear"></div>
				<?php
			}

			if( ! empty( $this->settings['name'] ) ){
				?>
				<span class="tie-label"><?php echo $this->settings['name']; ?></span>
				<?php
			}
		}


		/**
		 * Visual
		 */
		private function visual(){
			?>
			<ul id="tie_<?php echo $this->item_id ?>" class="tie-options">

				<?php

				$i = 0;

				$images_path = ! isset( $this->settings['external_images'] ) ? TIELABS_TEMPLATE_URL .'/framework/admin/assets/images/' : '';

				foreach ( $this->settings['options'] as $option_key => $option ){
					$i++;

					$checked = '';
					if( ( ! empty( $this->current_value ) && $this->current_value == $option_key ) || ( empty( $this->current_value ) && $i==1 ) ){
						$checked = 'checked="checked"';
					}

					?>
						<li class="visual-option-<?php echo $option_key ?>">
							<label class="checkbox-select">
								<input <?php echo $this->name_attr ?> type="radio" value="<?php echo $option_key ?>" <?php echo $checked ?>>
								<?php
									do_action( 'TieLabs/Settings/Visual/'.$this->item_id, $option_key, $option  );

									if( is_array( $option ) ){
										foreach ( $option as $description => $img_data ){

											if( is_array( $img_data ) ){

												$img_value = reset( $img_data );
												$key = key($img_data);
												unset( $img_data[ $key ] );

												$data_attr = '';
												if( !empty( $img_data ) && is_array( $img_data ) ){
													foreach ($img_data as $data_name => $data_value) {
														$data_attr = ' data-'. $data_name .'="'. $data_value .'"';
													}
												}
												?>
													<img loading="lazy" class="<?php echo $key ?>" <?php echo $data_attr ?> src="<?php echo $images_path.$img_value ?>" alt="">
												<?php
											}
											else{
												?>
													<img loading="lazy" src="<?php echo $images_path.$img_data ?>" alt="">
												<?php
											}

											if( ! empty( $description ) ){
												?>
													<span><?php echo $description ?></span>
												<?php
											}
										}
									}
									else{
										?>
											<img loading="lazy" src="<?php echo $images_path.$option ?>" alt="">
										<?php
									}
								?>
							</label>
						</li>
					<?php
				}

			echo"</ul>";

			if( empty( $this->settings['toggle'] ) ){
				return;
			}
			?>

			<script>
				jQuery(document).ready(function(){
					jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).hide();
					<?php
					if( ! empty( $this->settings['toggle'][ $this->current_value ] ) ) { ?>
						jQuery( '<?php echo esc_js( $this->settings['toggle'][ $this->current_value ] ) ?>' ).show();
					<?php
					}elseif( is_array( $this->settings['toggle'] ) ){
						$first_elem = reset( $this->settings['toggle'] ) ?>
						jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
					<?php
					}
					?>

				jQuery(document).on( 'click', '#tie_<?php echo esc_js( $this->item_id ) ?> label', function(){
					selected_val = jQuery( this ).parent().find( 'input' ).val();
					jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).hide();
					<?php
						foreach( $this->settings['toggle'] as $tg_item_name => $tg_item_id ){
							if( ! empty( $tg_item_id ) ){ ?>
								if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
									jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');

									// CodeMirror
									jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).find('.CodeMirror').each(function(i, el){
								    el.CodeMirror.refresh();
									});
								}
							<?php
							}
						}
					?>
				 });
				});
			</script>
			<?php
		}


		/**
		 * Gallery
		 */
		private function gallery(){
			?>

			<input id="<?php echo esc_attr( $this->item_id ) ?>-upload" type="button" class="tie-upload-image tie-primary-button button button-primary button-large" value="<?php esc_html_e( 'Add Image', TIELABS_TEXTDOMAIN ) ?>">

			<ul id="<?php echo esc_attr( $this->item_id ) ?>-gallery-items" class="tie-gallery-items">
				<?php

					$counter = 0;

					if( $this->current_value ){

						$gallery = maybe_unserialize( $this->current_value );

						if( is_array( $gallery ) ){
							foreach( $gallery as $slide ){

								$counter++; ?>

								<li id="listItem_<?php echo esc_attr( $counter ) ?>"  class="ui-state-default">
									<div class="gallery-img img-preview"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?>
										<input id="tie_post_gallery[<?php echo esc_attr( $counter ) ?>][id]" name="tie_post_gallery[<?php echo esc_attr( $counter ) ?>][id]" value="<?php echo esc_attr( $slide['id'] ) ?>" type="hidden" />
										<a class="del-img-all"></a>
									</div>
								</li>

								<?php
							}
						}
					}
				?>
			</ul>
			<script>
				var nextImgCell = <?php echo esc_js( $counter+1 ) ?>;

				jQuery(document).ready(function(){
					jQuery(function(){
						jQuery( "#<?php echo esc_attr( $this->item_id ) ?>-gallery-items" ).sortable({placeholder: "tie-state-highlight"});
					});

					// Uploading files
					var tie_slider_uploader;

					jQuery(document).on('click', '#<?php echo esc_attr( $this->item_id ) ?>-upload' , function( event ){
						event.preventDefault();
						tie_slider_uploader = wp.media.frames.tie_slider_uploader = wp.media({
							title: '<?php esc_html_e( 'Add Image', TIELABS_TEXTDOMAIN ) ?>',
							library: {type: 'image'},
							button: {text: '<?php esc_html_e( 'Select', TIELABS_TEXTDOMAIN ) ?>'},
							multiple: true,
						});

						tie_slider_uploader.on( 'select', function(){
							var selection = tie_slider_uploader.state().get('selection');
							selection.map( function( attachment ){
								attachment = attachment.toJSON();
								jQuery('#<?php echo esc_attr( $this->item_id ) ?>-gallery-items').append('\
									<li id="listItem_'+ nextImgCell +'" class="ui-state-default">\
										<div class="gallery-img img-preview">\
											<img src="'+attachment.url+'" alt=""><input id="tie_post_gallery['+ nextImgCell +'][id]" name="tie_post_gallery['+ nextImgCell +'][id]" value="'+attachment.id+'" type="hidden">\
											<a class="del-img-all"></a>\
										</div>\
									</li>\
								');

								nextImgCell ++;
							});
						});

						tie_slider_uploader.open();
					});
				});
			</script>
			<?php
		}


		/**
		 * Select Image ID
		 */
		private function select_image(){

			$upload_button = ! empty( $this->settings['custom_text'] ) ? $this->settings['custom_text'] : esc_html__( 'Select Image', TIELABS_TEXTDOMAIN );

			$hide_preview  = 'style="display:none"';
			$image_preview = TIELABS_TEMPLATE_URL.'/framework/admin/assets/images/empty.png';

			if( ! empty( $this->current_value ) ){
				$get_the_image = wp_get_attachment_image_src( $this->current_value, 'thumbnail' );
				if( ! empty( $get_the_image['0'] ) ){
					$image_preview = $get_the_image['0'];
					$hide_preview = '';
					$upload_button = esc_html__( 'Select another image', TIELABS_TEXTDOMAIN );
				}
			}

			?>

			<div class="image-preview-wrapper tie-select-image">
				<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> type="hidden" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?>>
				<input id="<?php echo esc_attr( $this->item_id ) ?>-upload" type="button" class="button" value="<?php echo $upload_button ?>">

				<?php $this->hint(); ?>
			</div>

			<div id="<?php echo $this->item_id . '-preview' ?>" class="img-preview" <?php echo $hide_preview ?>>
				<img loading="lazy" src="<?php echo $image_preview ?>" alt="">
				<a class="del-img"></a>
			</div>
			<div class="clear"></div>

			<script>

				jQuery(document).ready(function(){

					// Uploading files
					var tie_slider_uploader;

					jQuery(document).on('click', '#<?php echo esc_attr( $this->item_id ) ?>-upload' , function( event ){
						event.preventDefault();
						tie_slider_uploader = wp.media.frames.tie_slider_uploader = wp.media({
							title: '<?php esc_html_e( 'Select Image', TIELABS_TEXTDOMAIN ) ?>',
							library: {type: 'image'},
							button: {text: '<?php esc_html_e( 'Select', TIELABS_TEXTDOMAIN ) ?>'},
							multiple: true,
						});

						tie_slider_uploader.on( 'select', function(){
							var selection = tie_slider_uploader.state().get('selection');
							selection.map( function( attachment ){
								attachment = attachment.toJSON();
								jQuery('#<?php echo $this->item_id; ?>').val( attachment.id );
								jQuery('#<?php echo $this->item_id; ?>-preview').show();
								jQuery('#<?php echo $this->item_id; ?>-preview img').attr('src', attachment.url );
							});
						});

						tie_slider_uploader.open();
					});
				});
			</script>
			<?php
		}


		/**
		 * Icon
		 */
		private function icon(){
			?>
			<div class="icon-picker-wrapper">
				<div id="preview-edit-icon-<?php echo esc_attr( $this->item_id ) ?>" data-target="#<?php echo esc_attr( $this->item_id ) ?>" class="button icon-picker <?php echo esc_attr( $this->current_value ) ?>"></div>
			</div>
			<input <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?> type="text" value="<?php echo esc_attr( $this->current_value ) ?>" <?php echo $this->placeholder_attr ?> style="width: 130px;">
			<?php
		}


		/**
		 * Select
		 */
		private function select(){
			?>
			<div class="tie-custom-select">
				<select <?php echo $this->item_id_attr ?> <?php echo $this->name_attr ?>>
					<?php
						$i = 0;
						if( ! empty( $this->settings['options'] ) && is_array( $this->settings['options'] ) ){
							foreach ( $this->settings['options'] as $option_key => $option ){
								$i++;

								$selected = '';
								if ( ( ! empty( $this->current_value ) && $this->current_value == $option_key ) || ( empty( $this->current_value ) && $i==1 ) ){
									$selected = 'selected="selected"';
								}
								?>

								<option value="<?php echo $option_key ?>" <?php echo $selected ?>><?php echo $option ?></option>

								<?php
							}
						}
					?>
				</select>
			</div>

			<?php

				if( ! empty( $this->settings['toggle'] ) ){ ?>
				<script>
					jQuery(document).ready(function(){
						jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).hide();

						<?php
						if( ! empty( $this->settings['toggle'][ $this->current_value ] ) ) { ?>
							jQuery( '<?php echo esc_js( $this->settings['toggle'][ $this->current_value ] ) ?>' ).show();
						<?php
						}elseif( is_array( $this->settings['toggle'] ) ){
							$first_elem = reset( $this->settings['toggle'] ) ?>
							jQuery( '<?php echo esc_js( $first_elem ) ?>' ).show();
						<?php
						}
						?>

						jQuery("select[name='<?php echo esc_js( $this->option_name ) ?>']").change(function(){
							selected_val = jQuery( this ).val();
							jQuery( '.<?php echo esc_js( $this->item_id ) ?>-options' ).slideUp('fast');

							<?php
							foreach( $this->settings['toggle'] as $tg_item_name => $tg_item_id ){
								if( ! empty( $tg_item_id ) ){ ?>
									if ( selected_val == '<?php echo esc_js( $tg_item_name ) ?>'){
										jQuery( '<?php echo esc_js( $tg_item_id ) ?>' ).slideDown('fast');
									}
								<?php
								}
							}

							?>
						 });
					});
				</script>
				<?php
			}
		}


		/**
		 * Background
		 */
		private function background(){

			$current_value = maybe_unserialize( $this->current_value );
			?>

			<input id="<?php echo esc_attr( $this->item_id ) ?>-img" class="tie-img-path tie-background-path" type="text" size="56" name="<?php echo esc_attr( $this->option_name ) ?>[img]" value="<?php if( ! empty( $current_value['img'] )) echo esc_attr( $current_value['img'] ) ?>">
			<input id="upload_<?php echo esc_attr( $this->item_id ) ?>_button" type="button" class="button" value="<?php esc_html_e( 'Upload', TIELABS_TEXTDOMAIN )  ?>">

			<div class="tie-background-options">

				<select name="<?php echo esc_attr( $this->option_name ) ?>[repeat]" id="<?php echo esc_attr( $this->item_id ) ?>[repeat]">
					<option value=""></option>
					<option value="no-repeat" <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'no-repeat' ) ?>><?php esc_html_e( 'no-repeat', TIELABS_TEXTDOMAIN )         ?></option>
					<option value="repeat"    <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat'    ) ?>><?php esc_html_e( 'Tile', TIELABS_TEXTDOMAIN )              ?></option>
					<option value="repeat-x"  <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat-x'  ) ?>><?php esc_html_e( 'Tile Horizontally', TIELABS_TEXTDOMAIN ) ?></option>
					<option value="repeat-y"  <?php if( ! empty($current_value['repeat'])) selected( $current_value['repeat'], 'repeat-y'  ) ?>><?php esc_html_e( 'Tile Vertically', TIELABS_TEXTDOMAIN )   ?></option>
				</select>

				<select name="<?php echo esc_attr( $this->option_name ) ?>[attachment]" id="<?php echo esc_attr( $this->item_id ) ?>[attachment]">
					<option value=""></option>
					<option value="fixed"  <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'fixed'  ) ?>><?php esc_html_e( 'Fixed',  TIELABS_TEXTDOMAIN ) ?></option>
					<option value="scroll" <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'scroll' ) ?>><?php esc_html_e( 'Scroll', TIELABS_TEXTDOMAIN ) ?></option>
					<option value="cover"  <?php if( ! empty($current_value['attachment'])) selected( $current_value['attachment'], 'cover'  ) ?>><?php esc_html_e( 'Cover',  TIELABS_TEXTDOMAIN ) ?></option>
				</select>

				<select name="<?php echo esc_attr( $this->option_name ) ?>[hor]" id="<?php echo esc_attr( $this->item_id ) ?>[hor]">
					<option value=""></option>
					<option value="left"   <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'left'   ) ?>><?php esc_html_e( 'Left',   TIELABS_TEXTDOMAIN ) ?></option>
					<option value="right"  <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'right'  ) ?>><?php esc_html_e( 'Right',  TIELABS_TEXTDOMAIN ) ?></option>
					<option value="center" <?php if( ! empty($current_value['hor'])) selected( $current_value['hor'], 'center' ) ?>><?php esc_html_e( 'Center', TIELABS_TEXTDOMAIN ) ?></option>
				</select>

				<select name="<?php echo esc_attr( $this->option_name ) ?>[ver]" id="<?php echo esc_attr( $this->item_id ) ?>[ver]">
					<option value=""></option>
					<option value="top"    <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'top'    ) ?>><?php esc_html_e( 'Top',    TIELABS_TEXTDOMAIN ) ?></option>
					<option value="bottom" <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'bottom' ) ?>><?php esc_html_e( 'Bottom', TIELABS_TEXTDOMAIN ) ?></option>
					<option value="center" <?php if( ! empty($current_value['ver'])) selected( $current_value['ver'], 'center' ) ?>><?php esc_html_e( 'Center', TIELABS_TEXTDOMAIN ) ?></option>
				</select>
			</div>

			<div id="<?php echo esc_attr( $this->item_id ) ?>-preview" class="img-preview" <?php if( empty( $current_value['img'] )) echo 'style="display:none;"' ?>>
				<img loading="lazy" src="<?php if( ! empty($current_value['img'] )) echo esc_attr( $current_value['img'] ) ; else echo TIELABS_TEMPLATE_URL.'/framework/admin/assets/images/empty.png'; ?>" alt="">
				<a class="del-img" title="<?php esc_html_e( 'Remove', TIELABS_TEXTDOMAIN ) ?>"></a>
			</div>

			<?php
		}


		/**
		 * Typography
		 */
		private function typography(){

			$current_value = wp_parse_args( $this->current_value, array(
				'size'           => '',
				'line_height'    => '',
				'weight'         => '',
				'letter_spacing' => '',
				'transform' 	   => '',
			));

			?>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $this->option_name ) ?>[size]" id="<?php echo esc_attr( $this->settings['id'] ) ?>[size]">

					<option <?php selected( $current_value['size'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Font Size in Pixels', TIELABS_TEXTDOMAIN ); ?></option>
					<option value=""><?php esc_html_e( 'Default', TIELABS_TEXTDOMAIN ); ?></option>
					<?php for( $i=8 ; $i<61 ; $i+=1){ ?>
						<option value="<?php echo ( $i ) ?>" <?php selected( $current_value['size'], $i ); ?>><?php echo ( $i ) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $this->option_name ) ?>[line_height]" id="<?php echo esc_attr( $this->settings['id'] ) ?>[line_height]">

					<option <?php selected( $current_value['line_height'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Line Height', TIELABS_TEXTDOMAIN ); ?></option>
					<option value=""><?php esc_html_e( 'Default', TIELABS_TEXTDOMAIN ); ?></option>

					<?php for( $i=10 ; $i<=60 ; $i+=2.5 ){
						$line_height = $i/10;
						?>
						<option value="<?php echo ( $line_height ) ?>" <?php selected( $current_value['line_height'], $line_height ); ?>><?php echo ( number_format( $line_height, 2 ) ) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $this->option_name ) ?>[weight]" id="<?php echo esc_attr( $this->settings['id'] ) ?>[weight]">
					<option <?php selected( $current_value['weight'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Font Weight', TIELABS_TEXTDOMAIN ); ?></option>
					<option value=""><?php esc_html_e( 'Default', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="100" <?php selected( $current_value['weight'], 100 ); ?>><?php esc_html_e( 'Thin 100',        TIELABS_TEXTDOMAIN ); ?></option>
					<option value="200" <?php selected( $current_value['weight'], 200 ); ?>><?php esc_html_e( 'Extra 200 Light', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="300" <?php selected( $current_value['weight'], 300 ); ?>><?php esc_html_e( 'Light 300',       TIELABS_TEXTDOMAIN ); ?></option>
					<option value="400" <?php selected( $current_value['weight'], 400 ); ?>><?php esc_html_e( 'Regular 400',     TIELABS_TEXTDOMAIN ); ?></option>
					<option value="500" <?php selected( $current_value['weight'], 500 ); ?>><?php esc_html_e( 'Medium 500',      TIELABS_TEXTDOMAIN ); ?></option>
					<option value="600" <?php selected( $current_value['weight'], 600 ); ?>><?php esc_html_e( 'Semi 600 Bold',   TIELABS_TEXTDOMAIN ); ?></option>
					<option value="700" <?php selected( $current_value['weight'], 700 ); ?>><?php esc_html_e( 'Bold 700',        TIELABS_TEXTDOMAIN ); ?></option>
					<option value="800" <?php selected( $current_value['weight'], 800 ); ?>><?php esc_html_e( 'Extra 800 Bold',  TIELABS_TEXTDOMAIN ); ?></option>
					<option value="900" <?php selected( $current_value['weight'], 900 ); ?>><?php esc_html_e( 'Black 900',       TIELABS_TEXTDOMAIN ); ?></option>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $this->option_name ) ?>[letter_spacing]" id="<?php echo esc_attr( $this->settings['id'] ) ?>[letter_spacing]">

					<option <?php selected( $current_value['letter_spacing'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Letter Spacing', TIELABS_TEXTDOMAIN ); ?></option>
					<option value=""><?php esc_html_e( 'Default', TIELABS_TEXTDOMAIN ); ?></option>
					<?php for( $i=-5 ; $i<200 ; $i+=1){
							$letter_spacing = $i/10;

							if( $i == 0 ){
								continue;
							}
						?>
						<option value="<?php echo ( $letter_spacing ) ?>" <?php selected( $current_value['letter_spacing'], $letter_spacing ); ?>><?php echo ( number_format( $letter_spacing, 1 ) ) ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="tie-custom-select typography-custom-slelect">
				<select name="<?php echo esc_attr( $this->option_name ) ?>[transform]" id="<?php echo esc_attr( $this->settings['id'] ) ?>[transform]">

					<option <?php selected( $current_value['transform'], '' ); ?> <?php disabled(1,1); ?>><?php esc_html_e( 'Capitalization', TIELABS_TEXTDOMAIN ); ?></option>
					<option value=""><?php esc_html_e( 'Default', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="uppercase"  <?php selected( $current_value['transform'], 'uppercase' ); ?>><?php esc_html_e( 'UPPERCASE',  TIELABS_TEXTDOMAIN ); ?></option>
					<option value="capitalize" <?php selected( $current_value['transform'], 'capitalize' );?>><?php esc_html_e( 'Capitalize', TIELABS_TEXTDOMAIN ); ?></option>
					<option value="lowercase"  <?php selected( $current_value['transform'], 'lowercase' ); ?>><?php esc_html_e( 'lowercase',  TIELABS_TEXTDOMAIN ); ?></option>
				</select>
			</div>
			<?php
		}


		/**
		 * Prepare Data
		 */
		private function prepare_data( $settings, $option_name, $data ){

			// Default Settings
			$settings = wp_parse_args( $settings, array(
				'id'    => '',
				'class' => '',
			));

			$this->settings = $settings;
			$this->option_name = $option_name;

			extract( $settings );

			$this->option_type = ! empty( $type ) ? $type : false;

			// ID
			$this->item_id .= ! empty( $prefix ) ? $prefix.'-' : '';
			$this->item_id .= ! empty( $id )     ? $id         : '';

			if( ! empty( $this->item_id ) && $this->item_id != ' ' ){

				$this->item_id = ( $type == 'arrayText' ) ? $this->item_id . '-'. $key : $this->item_id;

				$this->item_id_attr = 'id="'. $this->item_id .'"';
				$this->item_id_wrap = 'id="'. $this->item_id .'-item"';
			}

			// Class
			$this->custom_class = ! empty( $class ) ?  ' '. $class .'-options' : '';

			// Name
			$this->name_attr = 'name="'. $option_name .'"';

			// Placeholder
			$this->placeholder_attr = isset( $placeholder ) ? 'placeholder="'. $placeholder .'"' : '';

			// Get the option stored data
			if( ! empty( $data ) ){
				$this->current_value = $data;
			}
			elseif( ! empty( $default ) ){
				$this->current_value = $default;
			}
		}

	}
}


/**
 * Build The options
 */
function tie_build_option( $value, $option_name, $data ){
	new TIELABS_SETTINGS( $value, $option_name, $data );
}
