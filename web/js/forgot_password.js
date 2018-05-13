$(function () {
	$("#btn__change__password").on("click touchstart", function (event) {
		event.preventDefault();
		$("#success__message").html("");
		$("#error__message").html("");
		let sErrorMessage = [], i = 0;

		let sNewPassword = $("#new__password").val();
		let sConfirmPassword = $("#confirm__password").val();
		let regex = $("#new__password").attr("pattern");

		let bPasswordMatchConfirm = sNewPassword === sConfirmPassword;
		let bPasswordMatchRegex = sNewPassword.match(regex);
		let bValidPassword = (bPasswordMatchConfirm && bPasswordMatchRegex);
		let bValidRequest = false;

		if (bValidPassword) {
			let datas = {
				mdp_utilisateur: sNewPassword,
				mdp_confirm: sConfirmPassword,
				cle_mdp_oublie: $("#cle__mail").val(),
				bJSON: 1,
				page: "forgotPasswordChange"
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
							bValidRequest = true;
							$("#success__message").html("Mot de passe changé avec succès, vous pouvez vous connecter.");
						} else {
							if (result["not_match_passwords"]) {
								bPasswordMatchConfirm = false;
							}
							if (result["unvalid_password"]) {
								bPasswordMatchRegex = false;
							}
							if (result["unvalid_request"]) {
								bValidRequest = false;
							}
						}
					})
					.fail(function (error) {
					})
		}

		if (!bPasswordMatchConfirm) {
			sErrorMessage[i++] = "Les mots de passes ne corespondent pas.";
		}
		if (!bPasswordMatchRegex) {
			sErrorMessage[i] = "Le mot de passe doit faire au moins 8 caractères comprenant au moins une majuscule, une minuscule, un chiffre et un caractère spécial.";
		}
		if (!bValidRequest) {
			sErrorMessage = ["Demande de changement de mot de passe inexistante."];
		}
		$("#error__message").html(sErrorMessage.join("<br>"));

	})
});

$(function () {
	$("#btn__send__mail").on("click touchstart", function (event) {
		event.preventDefault();
		$("#success__message").html("");
		$("#error__message").html("");
		let sMail = $("#mail").val();

		let datas = {
			courriel_utilisateur: sMail,
			bJSON: 1,
			page: "forgotPasswordSendMail"
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
						$("#success__message").html("E-mail envoyé, veuillez suivre ses instructions.");
					} else {
						if (result["unknow_mail"]) {
							$("#error__message").html("Adresse mail inconnue.");
						} else if (result["previous_request"]) {
							$("#error__message").html("Une demande est déjà en cours");
						}
					}
				})
				.fail(function (error) {

				})
	})
});
