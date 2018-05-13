
// LIMIT TECHNO SELECTION
	$('.checkbox__techno :checkbox').change(function () {
	$("#select__techno__error").html("");
    var $counter = $(this).closest('.checkbox__techno').find(':checkbox:checked');
    if ($counter.length >= 7) {
        this.checked = false;
        $("#select__techno__error").html("Impossible de selectionner plus de 6 technologies.");
    }
});




// MISE A JOUR TECHNOLOGIE
	
	$("#up_techno").on("click", function updateTechno(){
		var aTechnoChecked = [];

	// Select all checkbox and verify if it's check.
		for (var i = 0; i < $('.techno__field input').length; i++) {
			if($('#techno__field #'+i+'').prop("checked")){
				aTechnoChecked[i] = [];
				aTechnoChecked[i][0] = $('#techno__field #'+i+'').attr("name"); 
				aTechnoChecked[i][1] = $('#techno__field #'+i+'').attr("id");
			}
		}
		var datas = 
		{
			id_utilisateur: 61,
			bJSON: 1,
			page: "UpdateTechno",
			techno: aTechnoChecked.join("/")
		};

		$.ajax(
				{
					type: "POST",
					url : "route.php",
					async: false,
					data: datas,
					dataType: "json",
					cache: false,
				})

		.done(function(result){
			$("#select__techno__error").html("Profil mis à jour.");
		})

		.fail(function(result){
			$("#select__techno__error").html("Erreur. Le profil n'a pas été mis à jour.");

		})

	})


// MISE A JOUR RESEAU SOCIAL

	$("#up_rs").on("click", function updateRS(){
		var aRSChecked = [];

	// Select all checkbox and verify if it's check.
		for (var i = 1; i < $('.social__field input').length; i++) {
			if($('.social__field #'+i+'').val() != ""){
				aRSChecked[i] = [];
				aRSChecked[i][0] = $('.social__field #'+i+'').attr("id");
				aRSChecked[i][1] = $('.social__field #'+i+'').val();
			}
		}
		var datas = 
		{
			id_utilisateur: 61,
			bJSON: 1,
			page: "UpdateRS",
			rs: aRSChecked.join("/")
		};

		$.ajax(
				{
					type: "POST",
					url : "route.php",
					async: false,
					data: datas,
					dataType: "json",
					cache: false,
				})

		.done(function(result){
			$("#select__social__error").html("Profil mis à jour.");

		})

		.fail(function(result){
			$("#select__social__error").html("Erreur, mise à jour du profil impossible.");
		})
	})


	$("#up_email").on("click", function updateEmail(){

		if($("#new_email").val() === "" || $("#confirm_email").val() === ""){
			$("#email__error").html("Veuillez remplir les deux champs.");
		}else if($("#new_email").val() != $("#confirm_email").val()){
			$("#email__error").html("Erreur, les deux adresses ne correspondent pas.");
		}else{
			var datas = 
			{
				id_utilisateur: 61,
				bJSON: 1,
				page: "UpdateEmail",
				new_email: $("#new_email").val(),
				confirm_email: $("#confirm_email").val()
			};

			$.ajax(
					{
						type: "POST",
						url : "route.php",
						async: false,
						data: datas,
						dataType: "json",
						cache: false,
					})

			.done(function(result){
				$("#email__error").html("Adresse courriel mise à jour");

			})

			.fail(function(result){
				$("#email__error").html("Erreur, mise à jour de l'adresse impossible.");
			})
		}
});
	
	$("#up_info").on("click", function updateInfo(){
		var allowed_visibility;

		// Verify at least one radio button is checked
		if($("#visibility_on").prop("checked") === false && $("#visibility_off").prop("checked") === false ){
			$("#user__error").html("Veuillez renseigner la visibilité du profil");
		
		
		// Check for empty field
		}else if($("#user_last_name").val() === "" || $("#user_first_name").val() === "" || $("#user_site").val() === "" || $("#user_description").val() === ""){
			$("#user__error").html("Veuillez remplir tous les champs.");
		
		}else{
			// Get value of visibility
			($("#visibility_on").prop("checked"))? allowed_visibility = 1 : allowed_visibility = 0;

			// Reset error message
			$("#user__error").html("");

			var datas = 
			{
				id_utilisateur: 61,
				bJSON: 1,
				page: "UpdateInfo",
				visibility: allowed_visibility,
				last_name: $("#user_last_name").val(),
				first_name: $("#user_first_name").val(),
				url_site: $("#user_site").val(),
				description: $("#user_description").val()
			};

			$.ajax(
					{
						type: "POST",
						url : "route.php",
						async: false,
						data: datas,
						dataType: "json",
						cache: false,
					})

			.done(function(result){
				$("#user__error").html("Informations du profil mis à jour");

			})

			.fail(function(result){
				$("#user__error").html("Erreur, mise à jour des informations impossibles");
			})
		}
});
		

