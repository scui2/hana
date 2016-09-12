jQuery(document).ready(function($){

	hanaTemplate( $( "#page_template" ).val() );
    
	$( "#page_template" ).change(function(){
		hanaTemplate( $(this).val() );
	});

	function hanaTemplate( template ){
		$( "#hana-page-meta" ).hide();

		if ( 'pages/portfolio.php' == template ) {
			$( "#p_hana_category" ).show();
			$( "#p_hana_postperpage" ).show();
			$( "#p_hana_sidebar" ).show();
			$( "#p_hana_column" ).show();
			$( "#p_hana_intro" ).show();
			$( "#p_hana_disp_meta" ).show();
			$( "#hana-page-meta" ).show();
		}
	}

});
