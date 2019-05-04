-- Sample query to prove that our count is right
select Gender, count(Gender) from demographics where Age >16 and Gender='Male' union
select Gender, count(Gender) from demographics where Age <=16 and Gender='Male' union
select Gender, count(Gender) from demographics where Age >16 and Gender='Female' union
select Gender, count(Gender) from demographics where Age <=16 and Gender='Female'