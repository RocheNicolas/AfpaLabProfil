SELECT * 
FROM utilisateur__technologie
LEFT JOIN technologie ON technologie.id_technologie = utilisateur__technologie.id_technologie
WHERE id_utilisateur =61