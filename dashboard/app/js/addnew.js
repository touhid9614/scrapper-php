function validateForm() {
	var domain_name = $("#domain_name").val();

	if ((domain_name.match(/^https?:\/\/www./i))) {
		var domain = domain_name.split(".")[1];
		domain = domain.replace(/-/g, '_');
		$("#hostname").val(domain);
		return true;
	} else if (domain_name.match(/^https?:\/\/[0-9a-zA-Z-]+./i)) {
		var domain = domain_name.split(".")[0];
		domain = domain.split("//")[1];
		domain = domain.replace(/-/g, '_');

		$("#hostname").val(domain);

		return true;
	} else if (domain_name.match(/^www.[0-9a-zA-Z-]+./i)) {
		var domain = domain_name.split(".")[1];
		domain = domain.replace(/-/g, '_');

		$("#hostname").val(domain);

		return true;
	} else if (domain_name.match(/^[0-9a-zA-Z-]+.[com|ca|net|info]/i)) {
		var domain = domain_name.split(".")[0];
		domain = domain.replace(/-/g, '_');

		$("#hostname").val(domain);

		return true;
	} else {
		$('#domain_name').css('border-color', 'red');

		return false;
	}
}

// Maintain Scroll Position
if (typeof localStorage !== 'undefined') {
	if (localStorage.getItem('sidebar-left-position') !== null) {
		var initialPosition = localStorage.getItem('sidebar-left-position');
		var sidebarLeft = document.querySelector('#sidebar-left .nano-content');
		sidebarLeft.scrollTop = initialPosition;
	}
}

function groupNameShowHide(selectElement) {
	if (selectElement.value == 'Dealership') {
		document.getElementById('hidden_group').classList.remove('hideMe');
	} else {
		if (!(document.getElementById('hidden_group').className.includes('hideMe'))) {
			document.getElementById('hidden_group').classList.add('hideMe');
		}
	}
}

function customDealerShowHide(selectElement) {
	if (selectElement.value == 'YES') {
		document.getElementById('hidden_custom_dealer').classList.remove('hideMe');
	} else {
		if (!(document.getElementById('hidden_custom_dealer').className.includes('hideMe'))) {
			document.getElementById('hidden_custom_dealer').classList.add('hideMe');
		}
	}
}