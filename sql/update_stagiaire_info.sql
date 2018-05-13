UPDATE utilisateur 
SET active_utilisateur = @active_utilisateur,
nom_utilisateur = "@nom_utilisateur",
prenom_utilisateur = "@prenom_utilisateur",
site_utilisateur = "@site_utilisateur",
description_utilisateur = "@description_utilisateur"
WHERE id_utilisateur = @id_utilisateur