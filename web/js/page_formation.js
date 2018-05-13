(function () {
	document.addEventListener('DOMContentLoaded', function () {
		$("#formation__liste").on("change", function () {

			$.post(
					'route.php',
					{
						id_formation: this.value,
						bJSON: 1,
						page: "Formations_get_sessions"
					},
					callback_ajax_sessions,
					'json'
			);


			function callback_ajax_sessions(result) {
				console.log(result);

				$('.owl-carousel').trigger('destroy.owl.carousel');
				$("#container__carousel").html("");

				for (let i = result["liste_session"].length - 1; i >= 0; i--) {
					$('#container__carousel').append(
							'<div class="item" id="formation_item_'+ result["liste_session"][i].id_session +'">' +
							'  <!-- START ITEM -->' +
							'' +
							'    <div class="item__formation">' +
							'    <!-- START ITEM__FORMATION -->' +
							'' +
							'      <!-- ITEM__HEADER -->' +
							'      <div class="item__formation__header">' +
							'        <div class="item__formation__header__bg">' +
							'          <h2>SESSION '+ result['liste_session'][i].titre_session +' '+ (i+1) +'</h2>' +
							'          <div class="formation__header__date">' +
							'            <i class="far fa-calendar-alt fa-2x"></i>&nbsp;' +
							'            <span>réalisée du '+ result['liste_session'][i].date_debut_session +' au '+ result['liste_session'][i].date_fin_session +'</span>' +
							'          </div>' +
							'			  <div>' +
							'				<form method="post" action="route.php?page=stagiaires">' +
							'   				<input type="hidden" name="form_id_session" value="'+ result["liste_session"][i].id_session +'"> ' +
							'   				<input type="hidden" name="form_id_formation" value="'+ result["liste_session"][i].id_formation +'"> ' +
							'					<input type="submit"> ' +
							'				</form>'+
							'			  </div>' +
							'        </div>' +
							'      </div>' +
							'' +
							'      <!-- ITEM__TECHNO -->' +
							'      <div class="item__formation__techno">' +
							'        <div class="item__formation__techno__container" id="display_techno_'+ result["liste_session"][i].id_session +'"></div>' +
							'      </div>' +
							'' +
							'      <!-- ITEM__INSTRUCTOR  -->' +
							'      <div class="item__formation__instructor">' +
							'        <div class="item__formation__instructor__container">' +
							'          <div class="item__formation__instructor__photo">' +
							'            <div class="item__formation__instructor__photo__bg">' +
							'              <img src="img/manager.png" alt="">' +
							'            </div>' +
							'          </div>' +
							'          <div class="item__formation__instructor__section">' +
							'            <p>'+ result['liste_session'][i].prenom_utilisateur +'</p>' +
							'            <p>'+ result['liste_session'][i].nom_utilisateur +'</p>' +
							'            <p><i>Formateur AFPA</i></p>' +
							'          </div>' +
							'          <div class="item__formation__instructor__footer">' +
							'            <button class="btn__generic" onclick="open__contact(\''+ result["liste_session"][i].nom_utilisateur + '\' , \'' + result["liste_session"][i].cle_utilisateur +'\')">Contact</button>' +
							'          </div>' +
							'        </div>' +
							'      </div>' +
							'' +
							'      <!-- ITEM__PROJECT -->' +
							'      <div class="item__formation__project">' +
							'        <div class="item__formation__project__header"><h3>Projets réalisés :</h3></div>' +
							'        <div class="item__formation__project__container" id="display_project_'+ result["liste_session"][i].id_session +'"></div>' +
							'      </div>' +
							'' +
							'    <!-- END ITEM__FORMATION -->' +
							'    </div>' +
							'  <!-- END ITEM -->' +
							'  </div>'
					);

					for (let j= result['liste_techno'].length - 1; j >= 0; j--) {
						if(result["liste_session"][i].id_session === result["liste_techno"][j].id_session) {
							$("#display_techno_"+ result['liste_session'][i].id_session)
									.append("<img class='techno__img' src='"+ result['liste_techno'][j].url_img_technologie +"'>");
						}
					}

					for (let j= result['liste_projet'].length - 1; j >= 0; j--) {
						if(result["liste_session"][i].id_session === result["liste_projet"][j].id_session) {
							$("#display_project_"+ result['liste_session'][i].id_session).append(
							'               <div class="item__formation__projects__entity">' +
							'                    <div class="item__formation__projects__entity__container1">' +
							'                        <span class="item__formation__projects__entity__title">'+ result['liste_projet'][j].titre_ressource +'</span>' +
							'                        <span class="item__formation__projects__entity__info"><input type="submit" class="btn__generic">Plus d\'infos +</button></span>' +
							'                    </div>' +
							'                    <div class="item__formation__projects__entity__container2">'+ result['liste_projet'][j].description_ressource +'</div>' +
							'               </div>'
							);
						}
					}

				}
				$('#select__stagiaires__container').css("padding","10px 0")
				$('#select__stagiaires').css({"height":"17px","background":"none"});
				$('#select__stagiaires select').css("font-size","1em");
				start_carousel();
			}

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
				smartSpeed: 1000
			});
		}
	});
})();


$('.item__formation__project__container :input[type="sumbit"]').click( function (event) {
	console.log('yo');
});