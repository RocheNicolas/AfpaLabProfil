SELECT * 
FROM utilisateur__reseau_social
LEFT JOIN reseau_social ON reseau_social.id_reseau_social = utilisateur__reseau_social.id_reseau_social
WHERE id_utilisateur = 61