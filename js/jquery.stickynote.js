(function($) {
	$.fn.stickynote = function(options) {
		var opts = $.extend({}, $.fn.stickynote.defaults, options);
		return this.each(function() {
			$this = $(this);
			$.fn.stickynote.createNote($.meta ? $.extend({}, opts, $this.data()) : opts);
		});
	};
	$.fn.stickynote.defaults = {
		size: 'large',
		color: '#000000',
		time: new Date(),
		author: 'nobody'
	};
	$.fn.stickynote.createNote = function(o) {
		var content = $(document.createElement('textarea'));
		var note = $(document.createElement('div')).addClass('jStickyNote').css('cursor','move');
		if(!o.text){
			note.append(content);
			var create_note = $(document.createElement('div')).addClass('jSticky-create').attr('title','Create Sticky Note').css('margin-top','-85%');  
			var create_no = $(document.createElement('input')).addClass('btn btn-success save').attr('title','Create Sticky Note').attr('value','save').attr('type','BUTTON').css('float','right');
			create_no.click(function(){
				alert("Sticky Note Created");
				var message = $(this).parent().find('textarea').val();
				$.get('notes.php', {
					author: o.author,
					message: message,
				       	time: $.format.date(new Date(), 'yyyy-MM-dd HH:mm:ss'),
					type: 'create'

				}, function(data){

					var note_textarea = $(document.createElement('p')).css('color',o.color).html(message);
					create_no.parent().find('textarea').before(note_textarea).remove(); 
					create_no.parent().data('id', data.id);
					console.info($.format.date(new Date(), 'yyyy-MM-dd HH:mm:ss'));
					note_textarea.before($(document.createElement('p')).addClass('title').html(o.author + '<br> (' + $.format.date(new Date(), 'yyyy-MM-dd HH:mm:ss') + ')'));
					create_no.remove();	

				}, 'json')
			})
		}	
		else {
			note.append($(document.createElement('p')).addClass('title').html(' (' + o.time + ')'));
			note.append($(document.createElement('textarea')).css({color: o.color}).text(o.text));
			//note.append($(document.createElement('input')).addClass('btn btn-success').attr('title','Update Sticky Note').attr('value','Update Sticky Note').attr('type','BUTTON').css('float','left').css('width','100%'));
			// note.append($(document.createElement('p')).css({color: o.color}).text(o.text));					
		

		var update_no = $(document.createElement('input')).addClass('btn btn-success save').attr('title','Update Sticky Note').attr('value','Update').attr('type','BUTTON');
        // var update_no = $(document.createElement('div')).addClass('jSticky-updates').attr('title','Update Sticky Note').attr('value','Update Sticky Note').css('width','100%').html('<img src="https://smartdentalcompliance.com/new/webImages/pin.png?magic=01">')
			
			update_no.click(function(e){
				var message = $(this).parent().find('textarea').val();
				var id = $(this).parent().data('id');
				var author = $(this).parent().data('author');
				var time = $(this).parent().data('time');
				var user = $(this).parent().data('user');
				console.log(message);
				console.log(id);
				console.log(author);
				console.log(user);
				$.get('notes.php', {
					id: o.id, 
                     message:message,
                     author: o.author,
                     time:o.time,
                     user:o.user,
					type: 'update'

				}, function(){
				       alert("Sticky Note Update");					
				})
			
		})
			note.append(update_no);


}

		var delete_note = $(document.createElement('div')).addClass('jSticky-delete');
		
		delete_note.click(function(e){
			var id = $(this).parent().data('id');
			if(!$.fn.stickynote.beforeDelete || $.fn.stickynote.beforeDelete(id)) {
				$.get('notes.php', {
					id: id, 
					type: 'delete'
				}, function(){
					delete_note.parent().remove();
				})
			}
		})
		
		var note_wrap = $(document.createElement('div')).css({'position':'absolute','top':'0','left':'0'})
			.append(note).append(delete_note).append(create_no);	

		switch(o.size){
			case 'large':
				note_wrap.addClass('jSticky-large');
				break;
			case 'small':
				note_wrap.addClass('jSticky-medium');
				break;
		}		
		if(o.containment){
			note_wrap.draggable({ containment: '#'+o.containment, scroll: false ,start: function(event, ui) {
				if(o.ontop)
					$(this).parent().append($(this));
			}});	
		}	
		else{
			var left = Math.random(1)*$(window).width() - 245;
			var top = Math.random(1) * $(window).height() - 248;
			if(!o.text) {
				left = ($(window).width() - 225) / 2;
				top = ($(window).height() - 228) / 2;
			}
			note_wrap.draggable({ scroll: false ,start: function(event, ui) {
				if(o.ontop)
					$(this).parent().append($(this));
			}}).css('left', left < 0? 20 : left).css('top', top < 0? 20 : top);
		}
		note_wrap.data('id', o.id);
		$('#contentSticky').append(note_wrap);
		if(!o.text)
			note_wrap.find('textarea').focus();
	};
})(jQuery);
