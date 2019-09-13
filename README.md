# SOSFrame

THIS PROJECT IS ABANDONED!


The SOSFrame project started off as an architecture experiment.
It combines HTTP (Restful Web Services) with MVC (Model-
View-Controller).

The project is being abandond because the code base is inconsistent.
Not All requests are handled the same way, make the logic difficult
to follow.

Initially it started out with the MVC as a pipeline as follows:

Request -> Controller -> Model -> View -> Response 

This works for some requests but not all. Some request do not
involve the model. Other requests are denied before the model
is invoked. Therefore, some requests involve only the controller and
the view. A better design puts the controller as the "manager" of the
application, like so:

Request -> Controller -> (Model -> Controller) -> View -> Response

The () means invoking the model, then returning to the controller is
optional and not necessary for all requests.

I will be starting a new project based on the improved design. I will
leave this project in place as many of the functions are reusable.





EVERYTHING BELOW IS FROM ORIGINAL README FOR HIS PROJECT!

In traditional MVC design the user creats an event inside
a view. This event is then passed on to the controller. The
controller determines if the event is significant or not.
If the event is significant, the controller updates the model.
The model then notifies all registered views that it has changed
state. The views then query the model to update themselves.

In web development the MVC pattern is still used but the pattern
needs to change because a request can be made before a view has been
presented. Therefore, the controller must come first.

The controller has two jobs - update the model and set the view.
The model fetches data from the database. The view packages the
data from the model into a presentation returned to the user.



I am looking to build a basic bare bones blog/CMS system that can be
easily expanded as necassary. 

## Notes on Design

Some points I'm thinking of for this system
	SEO
	Navigation
	Multiple Users
	Link Validation
	Custom Pages
		Forms
		Tables
		Lists
		Images
		Javascripts
		CSS
		Meta-tags
	Advertisements
	Mobile/Responsive Design
	HTTP Headers
	Social Media
	
	
