function get_email_data(){
	var datas = 
	{
		name: $("#contact__name").val(),
		email_sender: $("#contact__mail").val(),
		subject: $("#contact__subject").val(),
		content: $("#contact__message").val(),
		cle_utilisateur: $("#contact__key").val(),
		bJSON: 1,
		page: "mailManager"
	}

	$.ajax(
	{
		type: "POST",
		url: "route.php",
		async: false,
		data: datas,
		dataType: "json",
		cache: false,
	})

	.done(function(result) 
	{
		if (result.error = 1) {
			$("#contact__feedback").html(result.texte);
			$("#contact__feedback").addClass("contact__feedback--return");
		}else{
			$("#contact__feedback").html(result.texte);
			$("#contact__feedback").addClass("contact__feedback--return");
		}

		
	})

	.fail(function(result)
	{
	// 	PROBLEME AFFICHAGE MESSAGE ERREUR
		$("#contact__feedback").html(result.texte);
		$("#contact__feedback").addClass("contact__feedback--return");
		
	});
}
