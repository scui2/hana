/**
 * Customizwer Scripts
 * 
 * @package	hana
 * @since   1.0
 * @author  RewindCreation
 * @license GPL v3 or later
 * @link    http://rewindcreation.com/
 */
jQuery(document).ready(function($){
	// Diable fonts that are not selectable.
	$('#accordion-section-hana_typo select option')
		.filter(function(index) {
			var val = $(this).val();
			return !isNaN(parseFloat(+val)) && isFinite(val);
		}).attr('disabled', 'disabled');
	
});
