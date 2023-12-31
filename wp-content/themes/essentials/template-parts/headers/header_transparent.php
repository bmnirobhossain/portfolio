<?php
if(!empty($header_data->val)):
    if(!empty($header_data->val->header_1)):
        $header_val = $header_data->val;
        $opts = array();
        if(!empty($header_data->opts)){
            foreach ($header_data->opts as $i => $v) {
                $opts[$v->name] = $v->val;
            }
        }
        extract(shortcode_atts(array(
            'background' 		=> 'transparent',
            'custom_background' 		=> '',
            'scroll_background' 		=> 'white',
            'scroll_custom_background' 		=> '#fff',
            'style' 		=> '',
            'line_color' 		=> 'gray-1',
            'custom_line_color' 		            => '',
            'color' 	                   	=> 'dark-opacity-4',
            'custom_color' 	                   	=> '',
            'scroll_color' 	                => '',
        ), $opts));

        $cont_class = 'container-xl';
        if(strcmp($header_style, "transparent-full")==0){
            $cont_class = 'container-fluid';
        }

        $bg = '';
        if(!empty($background)){
            $bg = 'bg-'.$background;
        }
        $custom_bg = '';
        $custom_style = '';
        if(!empty($background&&$background=='custom')){
            if(!empty($custom_background)){
                $custom_bg = $custom_background;
                $custom_style = 'background:'.$custom_background;
            }
        }
        $scroll = '';
        $custom_scroll = '';
        if(!empty($scroll_background)){
            $scroll = 'bg-'.$scroll_background;
            if($scroll_background=='custom'){
                if(!empty($scroll_custom_background)){
                    $custom_scroll = $scroll_custom_background;
                }
            }
        }
        $customStyle = '';
        if(!empty($color)&&$color=='custom'){
            $color = 'pix-main-header-custom';
            $customStyle .= '.text-pix-main-header-custom { color: '.$custom_color.' !important; }';
        }
        if(!empty($line_color)&&$line_color==='custom'){
            $customStyle .= '.pix-main-header-line { background-color: '.$custom_line_color.' !important; }';
        }
        if(!empty($customStyle)){
            wp_register_style( 'pix-custom-header-handle', false );
	    	wp_enqueue_style( 'pix-custom-header-handle' );
	    	wp_add_inline_style( 'pix-custom-header-handle', $customStyle );
        }
        $col_opts = array();
        if(!empty($header_val->header_1->opts)){
            foreach ($header_val->header_1->opts as $i => $v) {
                $col_opts[$v->name] = $v->val;
            }
        }
        extract(shortcode_atts(array(
            'align' 		=> 'text-left'
        ), $col_opts));
        $headerClasses = '';
        if (!empty(get_post_field('pix-enable-sticky', $post))) {
            if (get_post_field('pix-enable-sticky', $post) == 'smart') {
                $headerClasses .= ' is-smart-sticky';
            }
        }

        $opts['is_secondary_font'] = $is_secondary_font;

        ?>
        <header id="masthead" class="pix-header <?php echo esc_attr($headerClasses); ?> pix-header-desktop d-block2 pix-header-normal2 pix-scroll-shadow sticky-top2 position-relative pix-header-container-area pix-header-<?php echo esc_attr( $header_style ); ?> bg-<?php echo esc_attr( $background ); ?>" data-text="<?php echo esc_attr( $color ); ?>" data-text-scroll="<?php echo esc_attr( $scroll_color ); ?>" data-bg-class="<?php echo esc_attr( $bg ); ?>" data-bg-color="<?php echo esc_attr( $custom_bg ); ?>" style="<?php echo esc_attr( $custom_style) ; ?>" data-scroll-class="<?php echo esc_attr( $scroll ); ?>" data-scroll-color="<?php echo esc_attr( $custom_scroll ); ?>" >
            <div class="<?php echo esc_attr( $cont_class ); ?>">
                <nav class="navbar pix-main-menu navbar-hover-drop navbar-expand-lg navbar-light <?php echo esc_attr( $align ); ?>">
                    <?php
                    foreach ($header_val->header_1->val as $key => $value) {
                        pix_get_header_elem('header', $value, $opts);
                    }
                    ?>
                </nav>
                <?php if($style=="border-bottom"): ?>
                    <div class="pix-main-header-line bg-<?php echo esc_attr( $line_color ); ?>" style="width:100%;height:1px;"></div>
                <?php endif; ?>

            </div>
            <?php if($style=="border-bottom-wide"): ?>
                <div class="pix-main-header-line bg-<?php echo esc_attr( $line_color ); ?>" style="width:100%;height:1px;"></div>
            <?php endif; ?>
        </header>


        <?php
    endif; ?>
<?php endif; ?>
