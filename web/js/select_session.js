$(function () {
	$("#liste__formation").on("change", function selectSession() {
		$("#liste__session").html("<option>Selectionner une session</option>");
		var datas =
				{
					id_formation: this.value,
					bJSON: 1,
					page: "SelectSession"
				};

		$.ajax(
				{
					type: "POST",
					url: "route.php",
					async: false,
					data: datas,
					dataType: "json",
					cache: false,
				})

				.done(function (result) {
					for (var i = result["liste_session"].length - 1; i >= 0; i--) {
						$("#liste__session").append("<option value=\""+result["liste_session"][i].id_session+"\">"+result["liste_session"][i].date_debut_session+ " - " +result["liste_session"][i].titre_session+"</option>");
					}
				})

				.fail(function (result) {
					alert("Echec de la requête !");
				})
	});

	$("#liste__session").on("change", function () {
		var datas =
				{
					id_session: $("#liste__session").val(),
					bJSON: 1,
					page: "SelectStagiaire"
				};

		$.ajax(
				{
					type: "POST",
					url: "route.php",
					async: false,
					data: datas,
					dataType: "json",
					cache: false,
				})

				.done(function (result) {

					$('.owl-carousel').trigger('destroy.owl.carousel');
					$("#container__carousel").html("");
					for (let i = result["liste_stagiaire"].length - 1; i >= 0; i--) {
						$("#container__carousel").append("<div class=\"slide__container\" id=\""+result["liste_stagiaire"][i].cle_utilisateur+"\"><div class=\"slide__header\"><div class=\"options__profil\" href=\"#\" ><a class=\"options__contact\" href=\"#\" ><img src=\"img/icons_social/email.png\" onclick=\"open__contact(' " + result["liste_stagiaire"][i].nom_utilisateur + "'  , ' " + result["liste_stagiaire"][i].cle_utilisateur + " ')\"/></a><a class=\"options__report\" href=\"#\" ><img src=\"img/icons_social/warning.png\"/></a></div><div class=\"pic__container\"><img class=\"pic__img\" src=\"" + result["liste_stagiaire"][i].photo_utilisateur + "\"></div><h1 class=\"student__title\">" + result["liste_stagiaire"][i].nom_utilisateur + " " + result["liste_stagiaire"][i].prenom_utilisateur + "</h1><a class=\"student__website\" href=\"#\">" + result["liste_stagiaire"][i].site_utilisateur + "</a><ul class=\"options__social\"></ul></div><div class=\"slide__aside__left\"><ul class=\"techno__list\"></ul></div><div class=\"slide__main\"><p>" + result["liste_stagiaire"][i].description_utilisateur + "</p></div><div class=\"slide__aside__right\"><ul class=\"doc__list\"></ul></div></div>");

						for(let j = result["liste_techno"].length -1; j >= 0; j--){
							if(result["liste_stagiaire"][i].id_utilisateur === result["liste_techno"][j].id_utilisateur){
								$("#"+result["liste_stagiaire"][i].cle_utilisateur+"  .techno__list").append("<li><img class=\"techno__img\" src=\""+result["liste_techno"][j].url_img_technologie+"\"><br></li>");
							}
						}

						for(let k = result["liste_rs"].length -1; k >= 0; k--){
							if(result["liste_stagiaire"][i].id_utilisateur === result["liste_rs"][k].id_utilisateur){
								$("#"+result["liste_stagiaire"][i].cle_utilisateur+"  .options__social").append("<li><a href=\""+result["liste_rs"][k].url_reseau_social+"\"><img class=\"social__icons\" src=\""+result["liste_rs"][k].url_img_reseau_social+"\"/></a></li>");
							}
						}

						for(let l = result["liste_doc"].length -1; l >= 0; l--){
							if(result["liste_stagiaire"][i].id_utilisateur === result["liste_doc"][l].id_utilisateur){
								$("#"+result["liste_stagiaire"][i].cle_utilisateur+"  .doc__list").append("<li><a href=\""+result["liste_doc"][l].lien_ressource+"\" ><img class=\"doc__img\" src=\"img/icons_social/pdf.png\"/></a><br><h3>"+result["liste_doc"][l].titre_ressource+"</h3></li>");
							}
						}

					}
					$('#select__stagiaires__container').css("padding","10px 0")
					$('#select__stagiaires').css({"height":"17px","background":"none"});
					$('#select__stagiaires select').css("font-size","1em");
					start_carousel();
				})

				.fail(function (result) {
					
				})
	})
});


function start_carousel() {
	$('.owl-carousel').owlCarousel({
		loop: false,
		responsiveClass: true,
		items: 1,
		nav: true,
		rewind: false,
		dots: true,
		pagination: true,
		margin: 30,
		stagePadding: 30,
		smartSpeed: 1000,

		responsive: {
			600: {
				margin: 100,

			},
			800: {
				margin: 250,
				stagePadding: 200,

			}
		},

	});

}

