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

The overall project uses Bootstrap v4.1.0.
