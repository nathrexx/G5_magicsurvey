CREATE VIEW SurveysWithTenPlusQuestions AS
SELECT s.survey_id, s.code, s.name, s.description, s.start_datetime, s.end_datetime
FROM Surveys s
JOIN Questions q ON s.survey_id = q.survey_id
GROUP BY s.survey_id
HAVING COUNT(q.question_id) > 10;
