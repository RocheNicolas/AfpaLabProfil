/************************************************************/
/*							Nav								*/
/************************************************************/

// Moving the cross
$(function () {
	$("body").on("click touchstart", "#burger__container", function () {
		this.classList.toggle("change");
		$("#nav__div__links").toggle();
	})
});

// Set the mail in the link to the forgotPassword page
$(function () {
	$("body").on("click touchstart", "#link__forgot__password", function (event) {
		event.preventDefault();
		let sMail = $("#login__mail").val();
		if (sMail) {
			document.location.href="route.php?page=forgotPassword&mail=" + sMail;
		} else {
			document.location.href="route.php?page=forgotPassword";
		}
	})
});

/************************************************************/
/*							Modals							*/
/************************************************************/

// Open the login modal
function open__login() {
	$("#modal__login").toggle();
}

// Open the contact modal
function open__contact(user, key_user) {
	$("#contact__recipient").html("Destinataire: " + user);
	$("#contact__key").val(key_user);
	$("#modal__contact").toggle();
}

// Close the modal by clicking on the close btn
$(function () {
	$("body").on("click touchstart", ".close__modal", function () {
		$(".modal").hide();
	})
});

// Close the modal by clicking anywhere
window.onclick = function (ev) {
	close_modal(ev);
};
window.ontouchstart = function (ev) {
	close_modal(ev);
};


function close_modal(ev) {
	let modals = $(".modal");
	let openModal = in_array(ev.target, modals);
	if (openModal) {
		modals.hide();
	}
}

function in_array(val, array) {
	let found = false;
	for (let i = 0; i < array.length; i++) {
		(val === array[i]) ? found = true : "";
	}
	return found;
}

/************************************************************/
/*			         Recherche ressources					*/
/************************************************************/

function supprRessource(ressource) {
	document.getElementById("div_encadre_" + ressource).remove();
	document.getElementById("datalist__select__techno").innerHTML += "<option value=\"" + ressource + "\" id=\"" + ressource + "\">"
}

//button input
$(function () {
	$("body").on("change", "#input__select__techno", function () {
		var divInfo = document.getElementById('add__selected__techno');
		var inputSelect = document.getElementById('input__select__techno');
		if (inputSelect.value !== "") {
			divInfo.style.display = 'block';
		} else {
			divInfo.style.display = 'none';
		}
	})
});


$(function () {
	$("body").on("click", "#add__selected__techno", function () {
		add__selected__techno();
	})
});

$(function () {
	$("body").on("keydown", "#input__select__techno", function (event) {
		if (event.keyCode === 13)
			add__selected__techno();
	})
}); 


function add__selected__techno() {
	var i = 0;
	var bTrouve = 0;
	for (i = 0; i < document.getElementById("datalist__select__techno").options.length; i++) {
		if (document.getElementById("datalist__select__techno").options[i].value == document.getElementById("input__select__techno").value) {
			bTrouve = 1;
		}
	}
	if (bTrouve == 1) {
		document.getElementById("div__selected__techno").innerHTML += "<div class=\"add__list\" id=\"div_encadre_" + document.getElementById("input__select__techno").value + "\"><a>" + document.getElementById("input__select__techno").value + "<i class=\"button__close fas fa-times\" type=\"button\" onClick=\"supprRessource('" + document.getElementById("input__select__techno").value + "')\"></i></a></div>";
		document.getElementById('div__selected__techno').style.display = 'flex';
		document.getElementById(document.getElementById("input__select__techno").value).remove();
		document.getElementById("input__select__techno").value = "";
	}
}

/************************************************************/
/*			         		Login							*/
/************************************************************/

$('#login__btn').on("click touchstart",function(){
	let mail = $("#login__mail").val();
	let password = $("#login__password").val();
	let regexMail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
	let regexPassword = $("#login__password").attr("pattern");
	let remember_me = $("#remember--checkbox").prop("checked");

	let bValidMail = mail.match(regexMail);
	let bValidPassword = password.match(regexPassword);
	let bConnection = false;

	if (bValidMail && bValidPassword) {
		let datas = {
			login_mail: mail,
			login_password: password,
			remember_me: remember_me,
			bJSON: 1,
			page: "connexion"
		};
		$.ajax({
			type: "POST",
			url: "route.php",
			async: false,
			data: datas,
			dataType: "json",
			cache: false,
		})
				.done(function (result) {
					if (result["success"]) {
						bConnection = true;
					} else if (result["unvalid_mail"]) {
						bValidMail = false;
					}
				})
				.fail(function (error) {
				})
	}
	
	if (!bConnection) {	
		("le mail ou le mot de passe ne correspond(ent) pas.");
	}
	if (!bValidMail) {
		("le mail est invalide.");
	}
});
