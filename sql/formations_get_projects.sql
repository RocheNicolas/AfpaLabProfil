SELECT  ressource.id_ressource,
        sr.id_session,
        ressource.titre_ressource,
        ressource.description_ressource,
        ressource.lien_ressource

FROM ressource
INNER JOIN session__ressource sr ON  sr.id_ressource = ressource.id_ressource
INNER JOIN session ON session.id_session = sr.id_session

WHERE session.id_formation = @id_formation;
