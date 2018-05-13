SELECT  session.id_formation,
		session.id_session,
        DATE_FORMAT(date_debut_session, '%d/%m/%Y') AS date_debut_session,
        DATE_FORMAT(date_fin_session, '%d/%m/%Y') AS date_fin_session,
        session.titre_session,
        session.description_session,
        utilisateur.id_utilisateur,
		utilisateur.cle_utilisateur,
        utilisateur.nom_utilisateur,
        utilisateur.prenom_utilisateur,
        utilisateur.courriel_utilisateur,
        utilisateur.photo_utilisateur

FROM session
        INNER JOIN session__utilisateur s_u ON session.id_session = s_u.id_session
        INNER JOIN utilisateur ON s_u.id_utilisateur = utilisateur.id_utilisateur
WHERE session.id_formation = @id_formation AND utilisateur.id_niveau < 3
ORDER BY session.id_session;

