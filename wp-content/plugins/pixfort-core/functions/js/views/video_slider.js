(function ( $ ) {
	'use strict';
	if(window.InlineShortcodeView){
	    // This name is defined automatically (InlineShortcodeView_you, for Frontend editor only
	    window.InlineShortcodeView_pix_video_slider = window.InlineShortcodeView.extend({
	    	// Render called every time when some of attributes changed.
	    	render: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.render.call(this); // it is recommended to call parent method to avoid new versions problems.
	            this.pix_update();
	    		return this;
	    	},
	    	pix_update: function () {
	            var that = this;
				setTimeout(function(){
					window.vc.frame_window.pix_main_slider(this.$el);
				}, 500);
				setTimeout(function(){
					vc.frame_window.pix_cb_fn(function(){
						var effects	=	[
				            'fade-in-Img',
				            'fade-in-down',
				            'fade-in-left',
				            'fade-in-up',
				            'fade-in-up-big',
				            'fade-in-right-big',
				            'fade-in-left-big',
				            'slide-in-up',
							'pix-3d-right-in-big',
							'pix-3d-left-in-big',
							'pix-3d-up-in-big',
							'pix-3d-down-in-big'
				        ];
						that.$el.find('.animate-in:not(.animating)').each(function(i, elem){

				            var	type = $(elem).attr('data-anim-type'),
				            delay = $(elem).attr('data-anim-delay');
				            $(elem).addClass('pix-waiting');

							// Animate
							setTimeout(function() {
								$(elem).addClass('animating pix-animate').addClass(type).removeClass('animate-in');
							}, delay);

							// On animation end
							$(elem).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend transitionend webkitTransitionEnd oTransitionEnd', function() {
								// Clear animation
								$(elem).removeClass('animating animating-init').removeClass(effects.join(' ')).addClass('animated');
							});

				        });
					});
					if(that.$el.hasClass('flickity-enabled')){
						that.$el.find('.pix-main-slider').flickity('resize');
					}
				}, 500);
	    	},
	    	updated: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.updated.call(this);
	            this.pix_update();
	            return this;
	    	},
	    	parentChanged: function () {
	    		window.InlineShortcodeView_pix_video_slider.__super__.parentChanged.call(this);
	    	}

	    });
	}

})( window.jQuery );
