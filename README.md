# Problem:
Most universities in the country hosts events around campus and off campus. These events are organized by college students in most of the cases.  Students are clustered (RSOs) by different organizations, clubs, fraternities around campus. These events are of different types: social, fundraising, tech talks, etc.  At the moment, each university has a website where they post their events for the upcoming weeks.   One needs to check the website in order to add each event to his/her calendar.   These events are just official events and not all events around the university are included. Another limitation is that one has no way to track weekly events. 
 
# Project Description: 
You are asked to implement a web application that solves the aforementioned problems.   Any student may register with this application to obtain a user ID and a password. There are three user levels: super admin who creates a profile for a university (name, location, description, number of students, pictures, etc.), admin who owns an RSO and may host events, and student who uses the application to look up information about the various events. 
 
Admin can create events with name, event category, description, time, date, location, contact phone, and contact email address.  A location should be set from a map (Bing, Google, open street map) with name, latitude, longitude, etc. In order to populate the database, one can use feeds (e.g., RSS, XML) from events.ucf.edu.  Each admin is affiliated with one university, and one or more RSOs. A student user can request to create a new RSO or to join an existent one.  A new RSO can be created with at least 5 other students with the same email domain, e.g. @knights.ucf.edu; and one of them should be assigned as an administrator. 
 
Student can view events in their university by location, or by selecting the University they want to see the events from. They can retrieve events according to their level of access or scope. A student should be able to see all the events around its location or from RSOs they are following. 
 
There are different types of events (social, fundraising, tech talks, etc.). Each event can be public, private, or an RSO event. Public events can be seen by everyone; private events can be seen by the students of the host university; and an RSO events can only be seen by members of the RSO. In addition, events can be created without an RSO.  Such events must be approved by the super admin.  After an event has been published, users can add, remove, and edit comments on the event, as well as rating the event with up to 5 stars. The application should offer some social network integration, e.g. posting from the application to Facebook or Google. 

# Technical Requirements: 
1.   The software must include at least 5 relational tables. 
2.   The software must include at least 10 SQL queries. 
3.   The website and database must support multiple concurrent users. 
4.   The application must have a browser-based interface and can be deployed on Internet. 
5.   The capabilities mentioned in the project description are worth 80 points (out of 100 points). Each team can design and implement additional features for the remaining 20 points.  Extra credits will be given to outstanding user interface and special features. 
6. Programming languages that can be used for the project: HTML, Javascript, PHP, Java, CSS, and stored procedures.  DBMS’s: Oracle, SQL Server, and MySQL. Other languages and DBMSs: check with the instructor. 
