<?php


?>

create or replace view
monthlyreport as
select
section.sectionid AS sectionid,
section.sectionname AS sectionname,
section.departmentid AS departmentid,
yearmonth.yearmonthid AS yearmonthid,
yearmonth.yearid AS yearid,
yearmonth.monthid AS monthid,
yearmonth.workinghours AS workinghours,
yearmonth.status AS status,
employee.employeeid AS id,
employee.employeename AS employeename,
employee.employeedesignation AS employeedesignation,
employeeduty.monthid AS month,
keywords.keywordsvalue AS keywordsvalue
from
((((employeeduty join employee on(employee.employeeid = employeeduty.employeeid)) join section on(section.sectionid = employee.sectionid)) join keywords on(employeeduty.keywordsid = keywords.keywordsid)) join yearmonth on(yearmonth.yearmonthid = employeeduty.monthid))
where id= and month=


