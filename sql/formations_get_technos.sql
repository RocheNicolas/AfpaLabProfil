SELECT  session__technologie.id_session,
        session__technologie.id_technologie,
        t.nom_technologie,
        t.url_img_technologie,
        t.active_technologie

FROM session__technologie
        INNER JOIN session s ON session__technologie.id_session = s.id_session
        INNER JOIN technologie t ON session__technologie.id_technologie = t.id_technologie
WHERE id_formation = @id_formation
AND session__technologie.id_session IN (

        SELECT session.id_session
        FROM session
        WHERE session.id_formation = @id_formation
);