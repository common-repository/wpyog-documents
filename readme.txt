=== WPYog Documents ===

Contributors: wpyog
Donate link: http://wpyog.com/
Tags: Document Management, Document, Simple Documents , Topics, PDF document upload, Word document upload
Requires at least: 4.0
Tested up to: 6.4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



== Description ==
WPYog Documents is a free, versatile WordPress document listing and management plugin that helps you showcase your documents cleanly. Designed and Developed by Team that has a combined experience of more than 15yrs on Wordpress Development and lets you use it to display all kinds of documents like Word, Excel, PowerPoint, PDF and absolutely every other type that you can upload to WordPress.

With this Plugin you need no programming knowledge and can be used by advanced developers as well.

Organize Documents into Categories: You can create categories that lets you organize your documents.
Show only selected Documents: Choose documents selectively by ID and list them into pages, posts or any other post types.

* NEW IN VERSION 1.3.3
	* Category Filters allows you to sort your documents easily.
	* Support for post order type, which allows you to custom sort your documents.


* SUPPORTED FILE TYPES
	* Microsoft Word  (DOC, DOCX, DOCM, DOTM, DOTX)
	* Microsoft Excel (XLS, XLSX, XLSB, XLSM)
	* Microsoft PowerPoint (PPT, PPTX, PPSX, PPS, PPTM, POTM, PPAM, POTX, PPSM)
	* Adobe Portable Document Format (PDF)

* SHORTCODE AND ATTRIBUTES
	Once you have installed the WPYog Documents plugin, you can add the shortcode [wpyog-document] to any post or page on your site to list documents.
	Some attributes for the [wpyog-document] shortcode that can be used to filter or sort your document list.
	* Category
		* This attribute filters the shortcode view to only show documents that are in the specified category.
	* Only accepts category ID.
		* Examples: [wpyog-document-list category=”7”]
	* Desc
		This attribute turns on or off the display of description of the document in the document list. 
		Only accepts “0” or “1”. 1 is to display and 0 is to hide.
		Examples: [wpyog-document-list desc=”0”]
	* Date
		* This attribute turns on or off the display of document uploaded date in the document list. 
		* Only accepts “0” or “1”. 1 is to display and 0 is to hide.
		* Examples: [wpyog-document-list date=”0”]
	* Order By
		* This attribute tells which field to use to order the document list. 
		* Only accepts “date” to order documents by date.
		* Examples: [wpyog-document-list orderby=”date”]
	* Order
		* This attribute decides the order of the document list. By default documents are listed by Descending date.
		* Only accepts “desc” or “asc”. Desc  is to display in descending order  and ASC is to display in Ascending order. This is used together with OrderBy Attribute
		* Examples: [wpyog-document-list order=”desc”]
	* Download
		* This attribute turns on or off the display of the download option in the document list. 
		* Only accepts “0” or “1”. 1 is to display and 0 is to hide.
		* Examples: [wpyog-document-list download=”0”]
	* Limit
		* This attribute limits the number of records/documents to list. By default it lists all documents.
		* Accepts numeric values like “3” or “4”. 3 is to limit 3 documents.
		* Examples: [wpyog-document-list limit=”3”]
	* ID
		* This attribute is used to display individual documents.
		* Accepts numeric values like “3” or “4”. 3 is the ID of the document that you wish to display.
		* Examples: [wpyog-document-list id=”4”]
* This is a VARSHYL TECH Project.
* SUMMARY
	Easily list and manage your PDF, Word, Excel and PowerPoint documents on your Wordpress website with any programming knowledge.

== Installation ==

1. Download the plugin, and unzip it.
2. Place the wpyog-document folder in your wp-content/plugins folder.
3. Activate the plugin from the plugins tab of your Wordpress admin.
4. Upload documents to "WPYog Document".
5. Place shortcodes [wpyog-document-list] or single document shortcode [wpyog-document id=16]id=“16” is the id of the document, replace with your own document id or copy from “WPYog Document” section.

== Frequently Asked Questions ==

= Can I request a feature to be added on the plugin? =
Certainly and would love to hear about it. 

#### Plugin features:
* Upload any documents like pdf, word etc.
* Display full list of document or single document
* Add / edit listing


== Screenshots ==

1. The WPYog Documents menu.