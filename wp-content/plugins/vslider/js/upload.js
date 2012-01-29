var current_image = '';

function send_to_editor(html) {
	var source = html.match(/src=\".*\" alt/);
	source = source[0].replace(/^src=\"/, "").replace(/" alt$/, "");

	if (current_image == 'slide1') {
		document.getElementById('slide1').value = source;
	}
	if (current_image == 'slide2') {
		document.getElementById('slide2').value = source;
	}
	if (current_image == 'slide3') {
		document.getElementById('slide3').value = source;
	}
	if (current_image == 'slide4') {
		document.getElementById('slide4').value = source;
	}
	if (current_image == 'slide5') {
		document.getElementById('slide5').value = source;
	}
	if (current_image == 'slide6') {
		document.getElementById('slide6').value = source;
	}
	if (current_image == 'slide7') {
		document.getElementById('slide7').value = source;
	}
	if (current_image == 'slide8') {
		document.getElementById('slide8').value = source;
	}
	if (current_image == 'slide9') {
		document.getElementById('slide9').value = source;
	}
	if (current_image == 'slide10') {
		document.getElementById('slide10').value = source;
	}
	if (current_image == 'slide11') {
		document.getElementById('slide11').value = source;
	}
	if (current_image == 'slide12') {
		document.getElementById('slide12').value = source;
	}
	if (current_image == 'slide13') {
		document.getElementById('slide13').value = source;
	}
	if (current_image == 'slide14') {
		document.getElementById('slide14').value = source;
	}
	if (current_image == 'slide15') {
		document.getElementById('slide15').value = source;
	}
	if (current_image == 'slide16') {
		document.getElementById('slide16').value = source;
	}
	if (current_image == 'slide17') {
		document.getElementById('slide17').value = source;
	}
	if (current_image == 'slide18') {
		document.getElementById('slide18').value = source;
	}
	if (current_image == 'slide19') {
		document.getElementById('slide19').value = source;
	}
	if (current_image == 'slide20') {
		document.getElementById('slide20').value = source;
	}

	tb_remove();
}