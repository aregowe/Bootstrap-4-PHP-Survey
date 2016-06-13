This is a project I recently worked on.

Basically, I found myself creating php survey after survey, creating new tables all over the place just for surveys.

I had this thought, let's have just a few tables for all surveys. Keep them all in 1 large repository.

The table structure breaks down like this:
-ZSURVEY : ZSURVEY is where you'll have your header data
-ZSURVEYQ : ZSURVEYQ is where you'll have your questions. These are what the survey-creators will provide.
-ZSURVEYA : ZSURVEYA is where you'll have your answers. These are what the survey-taker will provide.
-ZSURVEYE : ZSURVEYE is where you'll have your options. These are dropdown options, and radio button options.

That's it for table structure! Pretty simplistic.

survey.php is where the main magic happens. 

dbcon.php is where you'll place your connection information for connecting to DB, and server.

Submit.php is where your insert statement is located, as well as redirect after the survey has been taken.

The overall project uses Bootstrap v3, seeing as it was released recently I decided to give it a try. Didn't have very many problems with it at all.

If you have any questions, don't hesitate to e-mail me: admin@ravingtechguy.com