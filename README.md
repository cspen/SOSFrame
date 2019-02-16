# SOSFrame

This is an experimental implementation of the MVC. 

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
	
	
