######
DELIVERABLE 4 SUMMARY
######


Amanda Capobianco:

As my previous deliverable involved creating a blueprint for the registration system, figuring out it's basic flow and functionality, and setting up the necessary files - my tasks for this week consisted of the full and complete implementation of the registration system and making sure it functioned efficiently. For the patient_registration and therapist_registration view files, I implemented the input forms required for registration, where the values were then submitted to corresponding functions in the User_Management controller for creating a new patient and creating a new therapist. For security purposes, I utilized the bcrypt hashing algorithm when setting a new user’s password. I implemented the necessary models for creating a patient and a a therapist so that the new information could be saved and properly added into our database. When a new patient/therapist is successfully added into the database without any errors, the user is brought to the success page. My final commits included some modifications to the UI's and implementing form validation to make sure all required fields were inputted properly before being stored in our database tables.

Peter Tadrous:

For deliverable four, I created the visualization of a patient’s progress for the therapist to view, as well as the backend database tables for storing the metrics of a patient’s activity attempt. In the database, I created a table called ActivityMetrics,which stored important information and metrics. This table can also hold an additional field for specific metrics particular to that activity. I created the model in the file ActivityMetricsModel.php to get the information from the database based on a patient ID. For the controller, I worked in UserManagement.php to create a function to communicate with the patient_progress.php view to display the page where a therapist can search a patient. Once a patient is selected, the controller sends the patient ID to the model, which gets the important metrics to be displayed. I created charts in the controller, for which I used the Chart JS library, that showed how many activities were completed by that patient, how long it took to do each activity, how accurate they were, and all the attempts made per activity.

Stephen Nolan:

My last deliverable was starting the process of allowing an administrator to select a patient and download his info for offline use. I created the file for creating a PDF with a simple table visual that was colored and easy to digest. This week I integrated it into our application. I created the UI frontend for the admin which was the same twitter bootstrap typeahead function used in our therapist dashboard and adjusted it to work with the download file. It allows the admin to easily find a patient and view basic information before choosing to download the file. The download file then finds the data in our database for the selected patient and displays it in the pdf downloaded. It was my first time working on the whole use case on my own so it took a lot of time to learn the exactly how codeigniter worked and jquery requests. The exact files I worked on were the Administrator_Dashboard.php, AdministratorModel.php, UserManagement.php, Patient_view.php, Pdf.php, and Download.php
   
Treasure Muchenagumbo:

For deliverable 4, I implemented an entire activity from front to back. In particular, I worked on the Related Memory Activity. I created the necessary models and controllers needed to make this possible. I also refactored any existing code to suit the implementation of an actual game. I extended the database in order to store imperative information about the session, activity, and activity levels. I created the entire game using Vanilla Javascript. To be precise, I created an algorithm that autonomously renders the Related Memory Activity based on the given information from the database such as the level and its characteristics. The activity has both the pre-alphabetical and alphabetical versions. Each level has a timer of sixty seconds, and the patient can fail an attempt by either matching the wrong items, stopping the activity abruptly, or running out of time. If a patient fails a single activity thrice, the activity is then locked and the next activity is loaded. Furthermore, I also added a “help” button which the patient could interact with to receive instructions about the game in textual form. I also styled the game using custom CSS styling. Finally, I added some finishing touches to each dashboard UI.
 

######
DELIVERABLE 3 SUMMARY
######


Peter Tadrous:

For deliverable three, I was tasked with creating the model, view, and controller for viewing patient progress, as well as the backend for storing the patient’s activity metrics. This week, I spent time learning about models and controllers to more effectively plan out deliverable three’s tasks. I created an outline for the files I would have to make and the functions I’d have to use. I also began creating the model and view. I created two files: ActivityMetricsModel.php for the model and PatientProgress.php for the view. For the controller, I planned to work in UserManagement.php. Additionally, I modelled the ActivityMetrics  database table that stores the metrics for the activities played such as mouse clicks, mouse movements, keyboard typing speed, trail-to-trial timing, overall speed and accuracy, intervention navigation, task order, among others.

Amanda Capobianco:

For deliverable three, my tasks include implementing the entire registration system from front-end to back-end. This includes creating the registration UI for patients, creating the registration UI for therapists, and creating the appropriate models and controllers needed for the functionality of the registration system. This week I began creating a blueprint for planning all the necessary components of my use case and established a thorough understanding of how everything will ultimately work together. The basic flow and functionality of the registration system suggests that once a therapist successfully logs in, they are brought to their own specific dashboard which includes the option to “register a new patient”, and once clicked, they will be brought to the patient registration page. As for the administrator, once they successfully log in and are brought to their dashboard, they will have the option to “register a new therapist,” which when clicked will bring them to the therapist registration page. I have started working on the front-end of the registration system by creating a patient_registration.php and therapist_registration.php view, as well as implementing a load_registration_page() function within the System.php controller which loads the registration views depending on what type of user is signed in. My task for next week is to successfully complete the registration system.

Treasure Muchenagumbo:

For this deliverable, I was responsible for the entire login system. That is, giving admins, patients, and therapists the ability to log in and out of the system. First, I extended the tables in our database to add new columns for the users’ passwords and added sample passwords for testing purposes since the registration system wasn’t implemented as yet. These sample passwords were hashed with the one-way bcrypt hashing algorithm. Second,I implemented the necessary views, controllers, and models needed to make the login system possible. Finally, I isolated everything from the developer dashboard into their own views that can only be viewed by authorized individuals. That is, locking endpoints from unauthorized users. The most recent and stable release of our software, with the login system, is available on BitBucket tagged as Deliverable 3.








######
DELIVERABLE 2 SUMMARY
######


Amanda Capobianco:

For this week’s tasks I was responsible for implementing the front end of this deliverable, which involved creating a dynamic user interface for a therapist assigning an intervention session to a patient, as well as creating a dynamic confirmation page for the successful assignment of an intervention session. As part of my tasks, I first created the Assign Intervention button to be displayed on the view of the dashboard. My next task involved creating the session_assign.php file and created the view whereby a therapist would have the ability to type in a patient’s name and search for them, select the appropriate patient, and assign them an intervention session. The second part of this view exists in the UserManagement file of the controllers, within the function that generates the patient’s information. Here I implemented the jumbotron which would display the selected patient’s information with data from our database. My final task for this week was to create the session_assigned.php file in order to create a dynamic confirmation page, which displays when a patient is successfully assigned to a session by their specified therapist.


Stephen Nolan: 

For this week’s task I was responsible for implementing the back end of this deliverable. The models were responsible for connecting to the database and pulling information to the user or inserting information into the database. Updated interventionSessionModel to add method for creating intervention session, also added method for getting count of all incomplete sessions from database. Created PatientModel and made method for getting patient information and method for getting patient first and last name. Created therapistModel and method for getting therapist information.


Peter Tadrous:

For deliverable two, my responsibility was to implement the functionality for several buttons on different pages of our program, as well as search bar functionality for searching patients. First, I created a click event listener for the button on the home page that takes you to the page where a therapist can assign an intervention session. Then, using the session_assign.php and session_assigned.php files that Amanda created, I created another click event listener for the button that assigns the intervention session, and one more click event listener for the home button. For the final part of my task, I implemented the functionality of the search bar that autocompletes as a therapist enters a patient’s name. This involved creating two new event listeners; the first to detect each time something was entered into the search bar and update the search suggestions, and the second to get the selected patient’s information. The onChange event listener utilized twitter’s typeahead library to suggest patients based on what was typed, and did this by making a post request to the endpoint index.php/UserManagement/get_patient_fname_lname each time another letter was entered. The onEnter event listener makes a post request to the endpoint index.php/UserManagement/generate_patient_information with the pId of the selected patient. After getting the response, it appended it to the page.


Treasure Muchenagumbo:

For this deliverable, I worked on the backend. Particularly, I was responsible for the controllers. I created controllers that were RESTful APIs such as get_patient_information() and get_patient_fname_lname(). I also created controllers that rendered static and dynamic views such as pull_assign_page() and create_intervention_session() which creates a new session and loads the confirmation page with necessary summary data.
Furthermore, I was also tasked with connecting the several parts of the software, testing the entire system, and fixing any bugs that existed.
Smaller miscellaneous tasks include:
1. Extending tables in the database.
2. Assisting group members with any difficulties they might have experienced.

Note:
The deliverable 2 release has been tagged. So, each teammates' contributions can be viewed from the commits of that tag.




######
DELIVERABLE 1 SUMMARY
######


Amanda Capobianco:

For deliverable one, my responsibility was to create requests to the backend for the purpose of retrieving data so that it could be displayed on the front end. The first step necessary for completing my task was researching information and watching tutorials on how to efficiently use jQuery post and get methods in order to establish a communication between the front and back end. I implemented three post requests, one to the API get_intervention_sessions, the second to start_intervention, and the third to stop_intervention. I made it so that the specific post requests would occur when the corresponding buttons are clicked. Within each post request, the data of either the patient's ID or the Intervention Session's ID was sent along with the request, which allows the data specific to that ID to be retrieved. Upon the completion of my task, I was able to receive and display the acquired data, appending it from the server to the page through the use of other JQuery functions, and successfully establish a communication between the front end and back end API.


Peter Tadrous:

For deliverable one, my responsibility was to implement the HTML frontend for the summary page of the method stop_intervention(). For styling, I used bootstrap. I was initially unfamiliar with HTML and bootstrap, but after learning them through completing this use case I feel comfortable working on the front end. I tentatively used mock data for the summary page since there is no data to report without the games to play, however later versions will use information from the patient’s session to provide summary data. The summary page also allows the patient to return to the home page.


Stephen Nolan:

For deliverable one, my responsibility was to to implement the HTML frontend for the summary page of the method get_intervention_sessions. Watched a lot of tutorials recommended by treasure and others I found as I was completely new to HTML, Bootstrap, and PHP. The summary page shows the intervention progress and the therapists who assigned them. It allows the user to start the intervention of his choosing as well. The variables for the therapist and activity names are generated dynamically from the database.


Treasure Muchenagumbo:

For this deliverable, I was in charge of the backend. My duties included modeling and creating the database and its tables, creating and inserting the sample data into the database, creating the PHP Models, and creating the PHP Controllers. Since I have the most web development experience in this group, I also tried my best to guide my teammates as they worked on their portions. I tried to be as clear as possible as to what they have to implement, and supplied them with the necessary tutorials in order to do so.


Note:
The deliverable 1 release has been tagged. So, each teammates' contributions can be viewed from the commits of that tag.
