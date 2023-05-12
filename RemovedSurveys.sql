CREATE VIEW RemovedSurveys AS
SELECT s.survey_id, s.code, s.name, s.description, s.start_datetime, s.end_datetime
FROM Surveys s
WHERE s.is_removed = 1;
