SELECT * FROM session__utilisateur
LEFT JOIN utilisateur ON utilisateur.id_utilisateur = session__utilisateur.id_utilisateur
WHERE id_session = @id_session and id_niveau = 3 and active_utilisateur = 1
GROUP BY nom_utilisateur