=== CariPropShop Analytics ===
Contributors: CariPropShop
Tags: analytics, property, real estate, tracking, leads
Requires at least: 5.8
Tested up to: 6.4
Stable tag: 1.0.0
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Property analytics and tracking system for CariPropShop - tracks property views, leads, searches, and conversions.

== Description ==

CariPropShop Analytics provides comprehensive analytics for your real estate property website. Track how users interact with your properties, where your leads come from, and which search terms are most popular.

### Features

* Property View Tracking - Automatically tracks when visitors view property pages
* Most Viewed Properties - See which properties are most popular
* Lead Source Tracking - Track where leads come from (direct, organic, UTM parameters)
* Search Query Analytics - Monitor what users are searching for
* Conversion Tracking - Track which leads convert
* Admin Dashboard - Visual analytics within WordPress admin
* CSV Export - Export reports for further analysis

== Installation ==

1. Upload the `cari-prop-shop-analytics` folder to your `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to the Analytics menu item to view your analytics

== Frequently Asked Questions ==

= Does this plugin track property views automatically? =

Yes, property views are tracked automatically when visitors view single property pages.

= How do I track leads manually? =

You can use the REST API endpoint `/wp-json/cps-analytics/v1/track-lead` with property_id and lead_type parameters.

= Can I export my analytics data? =

Yes, go to Analytics > Export to download CSV reports for views, leads, or searches.

== Changelog ==

= 1.0.0 =
* Initial release