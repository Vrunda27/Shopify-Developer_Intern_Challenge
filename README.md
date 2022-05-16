# **Shopify - Developer Intern Challenge** #

&nbsp; 
## By: **Vrunda Patel** ##

&nbsp; 
## **IMPLEMENTATION AND SECURITY ANALYSIS** ##

* Designed a secure web application for logistics inventory where the user can register with basic details

* Logged in users can:
	- Add and view the inventories
	- Also Edit and Delete the inventories
	- Delete inventory button gives a pop-up asking for the comment for deletion and confirmation before deleting the comment  
	- Change their own password for the system

* To achieve defense-in-depth, I included input validation at all layers i.e. User Interface, Database and at server-side.

* Considered security measures at every stage of development life cycle in order to accomplish defense in breadth principle.

* Used new database user which has limited access to only application's database i.e. shopify. Saved hash value for sensitive data such as password.

* Prevented session-hijacking by using 
	- HTTPS setup for web application
	- session_set_cookie_params($lifetime, $path, $domain, $secure, $http-only)
	where $secure => TRUE, transfer cookie value via HTTPS to prevent man-in-middle attack
	$http-only => TRUE, JavaScript can not read/write this cookie value to prevent XSS 
	- checking one more parameter ['HTTP_USER_AGENT'] to confirm the identity of the browser 
 
* Avoided Cross Site Scripting(XSS) attack by filtering input using htmlspecialchars() and sanitized output using htmlentities() 

* Used prepare statement for SQL database modification queries in order to prevent SQL injection attack

* Cross Site Request Forgery(CSRF) attack is prevented with secure session token in all forms except register and login