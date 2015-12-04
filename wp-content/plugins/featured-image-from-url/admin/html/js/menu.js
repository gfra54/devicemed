function invert() {
	if (jQuery("#fifu_toggle").attr("class") == "toggleon") {
		jQuery("#fifu_toggle").attr("class", "toggleoff");
		jQuery("#fifu_input_backlink").val(0);
	}
	else {
		jQuery("#fifu_toggle").attr("class", "toggleon");
		jQuery("#fifu_input_backlink").val(1);
	}
}

jQuery(function () {
	var url = window.location.href;

	jQuery("#fifu_form").submit(function () {

		var frm = jQuery("#fifu_form");

		jQuery.ajax({
			type: frm.attr('method'),
			url: url,
			data: frm.serialize(),
			success: function (data) {
				//alert('saved');
			}
		});
	});
});
