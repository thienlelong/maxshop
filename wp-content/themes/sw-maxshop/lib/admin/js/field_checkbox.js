$(function(){
	$(document).on('click', '.cpanel-checkbox', function(e){
		e.preventDefault();
		
		var $this = $(this), data = $this.data(), checkbox = $('input[type="checkbox"]', $this)[0];
		$('input[type="checkbox"]', $this).each( function(i, el){
			if ( !i ){
				$('.active', $this).removeClass('active');
				if ( el.checked = !el.checked ) {
					$this.addClass('on');
					$('.btn-on', $this).addClass('active');
				} else {
					$this.removeClass('on');
					$('.btn-off', $this).addClass('active');
				}
			}
		});
		
	})
	
	
});