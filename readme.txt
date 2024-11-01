=== WP iCal Availability ===
Contributors: wpicalavailability
Tags: ical calendar, ical, import bookings, sync calendar, availability calendar
Requires at least: 3.0
Tested up to: 5.7
Stable tag: 1.0.3

This calendar imports an iCal feed from an external website, like Airbnb, and shows the availability based on that feed.

== Description ==

Show the availability of your holiday home by just importing an iCal feed. Is your holiday home listed on Airbnb, any other site or are you using Google Calendar? Use this calendar plugin to show the availability on your WordPress website. Add the iCal feed, sit back and relax!

= Features of the Free version =
* Create one calendar
* Import one iCal feed
* Simple user-friendly interface
* Displays the availability

= Features of the Premium version =
* Create an unlimited number of calendars
* Import multiple iCal feeds into one calendar
* Display multiple months
* Display a legend near the calendar
* Create your own legend (apply your own colors and languages)
* Change the first day of the week
* Change the start month/year
* Hide booking history on front-end
* Show the week's number (from 1 to 52)
* Professional support

= Download =
Download the Premium version at [www.wpicalavailability.com](https://www.wpicalavailability.com) to discover its unlimited advantages.


== Installation ==

1. Upload `wp-ical-availability-free` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the menu entry 'WP iCal Availability'
4. Click on 'Add New' at the top of the page to create a calendar
5. Click 'Save Changes' to save the calendar
6. Embed the calendar on any page or post using a shortcode like **[wpia id="1" title="no" language="auto"]**

A widget of the calendar is also available


== Frequently Asked Questions ==

= How can I embed the booking calendar on a page or post? =

Use the button 'Add Calendar' above your editor. An example of a token: [wpia id="1" title="yes" language="auto"]. If you paste this token in a page it will show your booking calendar with the title of the calendar.

= How can I remove the booking calendar title from displaying? =

Edit the shortcode: title="no".

= I have another question =

Please check [www.wpicalavailability.com](https://www.wpicalavailability.com) for more information.


== Screenshots ==

1. The calendar in a sidebar as a widget

== Changelog ==

= 1.0.3 =
* Fixed: Compatibility issues with WP 5.7 and PHP 8

= 1.0.2 =
* Fixed: Removed overwriting of the default timezone

= 1.0.1 =
* Tweaked "Time exceeded notice"

= 1.0 =
* Fixed URL encoding issue when trying to import a feed.

= 0.8 =
* Some iCal feeds contain descriptions of bookings, for example the name of the guest. These descriptions were also sent to the plugin and loaded in the source code of the web page. We removed this, because it is not used.

= 0.7 =
* Added file_get_contents as the main way to grab feeds, with cURL as a fallback method.

= 0.6 =
* Added follow redirects to curl

= 0.5 =
* Fixed a bug when the timezone is missing in the .ics file.
* Improved compatibility with PHP7.

= 0.4 =
* Fixed a compatibility issue with Google Calendar

= 0.3 =
* Updated ics parser class
* Fixed a compatibility issue with the premium version

= 0.2 =
* Fixed importing URLs with special characters or blank spaces

= 0.1 =
* First release

== Upgrade Notice ==

= 1.0.1 =
* Tweaked "Time exceeded notice"

= 1.0 =
* Fixed URL encoding issue when trying to import a feed.

= 0.8 =
* Some iCal feeds contain descriptions of bookings, for example the name of the guest. These descriptions were also sent to the plugin and loaded in the source code of the web page. We removed this, because it is not used.

= 0.7 =
* Added file_get_contents as the main way to grab feeds, with cURL as a fallback method.

= 0.6 =
* Added follow redirects to curl

= 0.5 =
* Fixed a bug when the timezone is missing in the .ics file.
* Improved compatibility with PHP7.

= 0.4 =
* Fixed a compatibility issue with Google Calendar

= 0.3 =
* Updated ics parser class
* Fixed a compatibility issue with the premium version

= 0.2 =
* Fixed importing URLs with special characters or blank spaces

= 0.1 =
* First release