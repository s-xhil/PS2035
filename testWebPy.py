!c:/Python27/python.exe
#The above will need to change to wherever python is installed on the webserver
 
import numpy as np
import cgi

#Field Storage is how Python retreives GET and POST variables.
fieldStorage = cgi.FieldStorage()

#Going to be printing some HTML. This will probably need to change when you get up to returning values.
#You'll likely be reloading a new page, passing the redshift(?) as a get/post variable. Maybe. 
print ("Content-type: text/html\n")

#Field Storage sucks and python doesn't auto cast to numeric fields. 
tempArr = []

print("<p>Using Parameters:</p>")
print("<ul>")
for key in fieldStorage.keys():
    # Print out the keys that have been sent to the webserver. Hopefully it makes sense. 
    print("<li>",key,"</li>")
    # Append the individual value to the temp array, after it has been cast as a float. Hopefully it is a float. 
    if key != "ID":
        tempArr.append(float(fieldStorage[key].value))
print("</ul>")

#Currently just printing out the mean of the array.
print("<p>Redshift = ",np.mean(np.array(tempArr)),"</p>")

