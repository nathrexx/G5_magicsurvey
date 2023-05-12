CREATE VIEW UsersWithTenPlusSurveys AS
SELECT u.first_name, u.last_name, u.email, u.phone_number
FROM Users u
JOIN Surveys s ON u.user_id = s.user_id
GROUP BY u.user_id
HAVING COUNT(s.survey_id) > 10;
