<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Laravel Relationship

Database tables are often related to one another. For example, a blog post may have many comments or an order could be related to the user who placed it. Eloquent makes managing and working with these relationships easy, and supports a variety of common relationships:

## Defining Relationships -

Eloquent relationships are defined as methods on your Eloquent model classes. Since relationships also serve as powerful query builders, defining relationships as methods provides powerful method chaining and querying capabilities.

### One To One -
  इसका उपयोग दो मॉडल्स को आपस में जोड़ने के लिए करते है | इस प्रकार के रिलेशनशिप में एक टेबल का प्राइमरी की दूसरे टेबल में foregn की यूज़ होता है | 

  Tables : users, contacts

  => user has one contact
  => contact belongs to user 
