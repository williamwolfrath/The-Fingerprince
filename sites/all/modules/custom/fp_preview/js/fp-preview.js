$(document).ready(function(){
	
	var top = 0;
	var positionStr = '';
	
	
	$('#fp-preview-non-audio-back').click(function() {
		if ( top == 0 ) {
			return false;
		}
		top = top + 550;
		positionStr = top + 'px';
		$('#fp-preview-current-page').animate(
			{ top: positionStr }, 1000
		);
		return false;
	});
	
	$('#fp-preview-non-audio-forward').click(function() {
		if ( top == -4950 ) {
			return false;
		}
		top = top - 550;
		positionStr = top + 'px';
		$('#fp-preview-current-page').animate(
			{ top: positionStr }, 1000
		);
		return false;
	});
	
	
});