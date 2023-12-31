# Change Log
## 2.4.33
*(2022-12-08)*

#### Fixed
* Fixed the issue with importing redirects

---


## 2.4.32
*(2022-11-29)*

#### Fixed
* Fixed the issue with error 'Deprecated Functionality: addslashes(): Passing null to parameter #1 of type string is deprecated'

---


## 2.4.31
*(2022-11-28)*

#### Fixed
* Fixed the issue with duplicating CrossLinks on import

---


## 2.4.30
*(2022-11-02)*

#### Fixed
* Fixed the issue with grid in audit job details page

---


## 2.4.29
*(2022-11-01)*

#### Fixed
* Fixed the issue with error while creating new SEO Template (Magento EE)
* Fixed the issue with error 'trim() expects parameter 1 to be string, null given'

---


## 2.4.28
*(2022-10-28)*

#### Fixed
* Fixed the issue with Sitemap items from Amasty Blog

---


## 2.4.27
*(2022-10-27)*

#### Fixed
* Fixed the issue with Category duplicate urls grid

---


## 2.4.26
*(2022-10-21)*

#### Fixed
* Fixed the issue with jquery/jquery.cookie (Magento 2.4.5)
* Conflict with Amasty_Stockstatus

---


## 2.4.25
*(2022-10-19)*

#### Fixed
* Fixed the issue with the error 'Uncaught TypeError: explode() expects parameter 2 to be string, null given'
* Fixed the issue with breadcrumbs rich snippet in multistore

---


## 2.4.24
*(2022-10-14)*

#### Improvements
* Added blog categories to Sitemap (Mirasvit_BlogMx)
* Sitemap compatibility with Amasty_Blog

#### Fixed
* Fixed the issue with the error 'Warning: preg_match(): Empty regular expression'
* Disable trailing slash feature on checkout
* Issue with brands sitemap URLs

---


## 2.4.23
*(2022-10-03)*

#### Fixed
* Compatibility with Aheadworks Blog > 2.13.* (Sitemap)

---


## 2.4.22
*(2022-09-23)*

#### Fixed
* Fixed the issue with error 'Return value of Mirasvit\Seo\Service\TemplateEngine\Data\CategoryData::getValue() must be of the type string or null, int returned'

---


## 2.4.21
*(2022-09-22)*

#### Fixed
* Fixed the issue with canonical URL not matching extension's settings (some cases)

---


## 2.4.20
*(2022-09-05)*

#### Improvements
* Add product availability in Open Graph markup

---


## 2.4.19
*(2022-09-01)*

#### Fixed
* Fixed the issue with Open Graph URL on homepage
* Fixed the issue with variable not saved in templates if the form submited right after the variable is inserted
* PHP8.1 compatibility issue

---


## 2.4.18
*(2022-08-12)*

#### Fixed
* Fixed the issue with special chars not replaced in the Open Graph metadata

---


## 2.4.17
*(2022-08-03)*

#### Fixed
* Error in some custom CMS page editors
* Console commands return value

---


## 2.4.16
*(2022-07-21)*

#### Improvements
* Automatically submit sitemap to Google ping service

#### Fixed
* PHP8.1 compatibility

---


## 2.4.15
*(2022-07-15)*

#### Fixed
* Fixed the issue with incorrect redirects when store changed

---


## 2.4.14
*(2022-07-07)*

#### Fixed
* Fixed the error during the 'setup:upgrade' execution after upgrading the module (Duplicate key name)
* Fixed the issue with duplicated store codes and custom store routes from stores' base URLs on redirect

---


## 2.4.13
*(2022-06-27)*

#### Fixed
* Fixed the issue with duplicated store code on redirects (trailing slash)

---


## 2.4.12
*(2022-06-27)*

#### Improvements
* Brand Page products Rich Snippet

---


## 2.4.11
*(2022-06-22)*

#### Fixed
* Fixed the issue with image friendly URLs (PHP8.1)
* Conflict with Magento ChartJs lib version

---


## 2.4.10
*(2022-06-20)*

#### Improvements
* remove db_schema_whitelist.json

---


## 2.4.9
*(2022-06-09)*

#### Fixed
* PHP8 compatibility
* Fixed the issue with the error 'Class Mirasvit\Brand\Registry does not exist' on brand pages in some themes

#### Improvements
* Code refactoring

---


## 2.4.8
*(2022-06-07)*

#### Fixed
* Fixed the issue with error 'Deprecated Functionality: preg_quote(): Passing null to parameter #1 of type string is deprecated'

---


## 2.4.7
*(2022-06-06)*

#### Fixed
* Fixed the issue with non-page links detected as pages in SEO Audit
* Fixed the issue with errors during the generation of the sitemap (PHP8 compatibility)

---


## 2.4.6
*(2022-06-01)*

#### Fixed
* Composer dependencies

---


## 2.4.5
*(2022-05-27)*

#### Fixed
* Fixed the issue with crosslinks not added to product/category content modified by templates
* Fixed the issue with not replaced placeholders

---


## 2.4.4
*(2022-05-20)*

#### Fixed
* PHP8.1 compatibility

---


## 2.4.3
*(2022-05-18)*

#### Fixed
* Fixed the issue with variables sidebar (Magento 2.4.4)

---


## 2.4.2
*(2022-05-17)*

#### Fixed
* remove MST_SEO_REDIRECT_URL_TO index

---


## 2.4.1
*(2022-05-12)*

#### Improvements
* Switch to declarative DB schema

#### Fixed
* Fixed the issue with Rich Snippet offers data (PHP8.1)

---


## 2.3.11
*(2022-04-04)*

#### Fixed
* Fixed the issue with pager visible on frontend sitemap when 'Show Products' set to 'No'
* Fixed the issue with errors during creating configurable/bundle products in some custom backend themes

---


## 2.3.10
*(2022-02-11)*

#### Fixed
* Minor fixes

---


## 2.3.9
*(2022-02-08)*

#### Fixed
* Fixed the issue with product variables (types)
* Fixed the issue with swatch images when SEO-friendly URLs for Product Images enabled

---


## 2.3.8
*(2022-02-04)*

#### Fixed
* Fixed the conflict with Magezon_PageBuilder
* Small fixes

---


## 2.3.7
*(2022-02-04)*

#### Fixed
* Fixed the issue with data types errors

---


## 2.3.6
*(2022-02-02)*

#### Fixed
* Small fixes

---


## 2.3.5
*(2022-02-02)*

#### Fixed
* PHP 8.1 compatibility

---


## 2.3.4
*(2022-01-21)*

#### Fixed
* Show only published posts in the sitemap (Mirasvit_BlogMx)

---


## 2.3.3
*(2022-01-13)*

#### Fixed
* Fixed the issue with blog posts from Mirasvit_BlogMx module not appeared in the sitemap
* Templates data (variables)

---


## 2.3.2
*(2022-01-12)*

#### Fixed
* Fixed the issue with customer account link when custom meta robots applied to the page
* Fixed the issue with attribute values in SEO-friendly URLs for Product Images
* Fixed the issue with errors in GraphQL requests

---


## 2.3.1
*(2022-01-05)*

#### Improvements
* Insert variables by doubleclick in variables popup
* Typeahead for variables

#### Fixed
* Fixed the issue with product URL missed (Opengraph)
* product_parent_... variables

---


## 2.3.0
*(2021-12-15)*

#### Features
* SEO Templates preview

#### Improvements
* Minor improvements

---

## 2.2.24
*(2021-12-10)*

#### Improvements
* Ability to disable SEO Audit in the admin panel
* SEO configurations restructured
* Server load threshold for SEO Audit
* Use meta tags from CMS pages if they are not empty

#### Fixed
* Fixed the issue with error while saving configurations in the scope of a store

---


## 2.2.23
*(2021-12-06)*

#### Improvements
* DB memory usage by SeoAudit module reduced

#### Fixed
* Fixed the issue with passing suspicious emails to the email subscription (SeoContent, reCaptcha)

---


## 2.2.22
*(2021-12-02)*

#### Fixed
* Small fixes

---


## 2.2.21
*(2021-11-29)*

#### Fixed
* Incorrect Rich Snippets price format

---


## 2.2.20
*(2021-11-22)*

#### Improvements
* Rating value for individual review RS

---


## 2.2.19
*(2021-11-19)*

#### Fixed
* Store filter for products rating and review (RS)

---


## 2.2.18
*(2021-11-18)*

#### Fixed
* Fixed the issue with checks details (Warning: Invalid argument supplied for foreach())
* Fixed the issue with the error while parsing robots.txt (TypeError: preg_match_all() expects parameter 2 to be string, null given)

---


## 2.2.17
*(2021-11-15)*

#### Improvements
* Small charts improvement (SEO Audit)

---


## 2.2.16
*(2021-11-10)*

#### Improvements
* additional DB indexes

---


## 2.2.15
*(2021-11-09)*

#### Fixed
* Organization Rich Snippet only on homepage.
* Possible sitemap issue (multistore).

---


## 2.2.14
*(2021-11-02)*

#### Fixed
* Fixed the issue with saving new product when 'Apply URL Key for new products' enabled (some cases, TypeError: strrev() expects parameter 1 to be string, int given)

---


## 2.2.13
*(2021-10-29)*

#### Fixed
* Fixed the issue with not able to export redirects (Cannot read properties of undefined)

---


## 2.2.12
*(2021-10-26)*

#### Fixed
* Fixed the issue with swatches product images (SEO-friendly URLs for Product Images)
* Issue with query parameters in canonical URL for category pages (some cases)
* Few issues in SeoAudit module.

---


## 2.2.11
*(2021-10-13)*

#### Fixed
* Issue with incorrect value of some product attributes in rich snippets for category pages when product offers enabled for current page
* Check children URLs only crawled in last job (Seo Audit)
* Rich snippet brand format

---


## 2.2.10
*(2021-10-08)*

#### Fixed
* Issue with page template variables in SEO Image Settings fields

---


## 2.2.9
*(2021-10-05)*

#### Fixed
* Jobs statuses (Seo Audit)
* Issue with generating sitemap when Add SiteMap to Robots enabled (some cases)

---


## 2.2.8
*(2021-09-27)*

#### Fixed
* Fixed the issue with "Apply URL Key for new products" (multistore)

---


## 2.2.7
*(2021-09-24)*

#### Improvements
* Ability to apply product URL templates for a particular product (CLI, --product-id)
* Ability to apply product URL templates for a particular store (CLI, --store-id)

---


## 2.2.6
*(2021-09-21)*

#### Fixed
* DOMDocument::loadHTML() expects parameter 1 to be string, null given

---


## 2.2.5
*(2021-09-16)*

#### Fixed
* Check whole URL for robots

---


## 2.2.4
*(2021-09-13)*

#### Fixed
* issue with adding autolinks inside autolinks in some cases
* issue with generating base pool (unsecure URLs)
* friendly image alt and urls issue

---


## 2.2.3
*(2021-09-07)*

#### Fixed
* Seo Audit grid errors

---


## 2.2.2
*(2021-09-06)*

#### Fixed
* URL details loading issue

---


## 2.2.1
*(2021-09-03)*

#### Fixed
* Seo Audit permissions

---


## 2.2.0
*(2021-09-03)*

#### Features
* Seo Audit submodule added

#### Fixed
* autolink umlauts
* issue with the small OG product image

#### Improvements
* Magento versions support - 2.3, 2.4

---


## 2.1.17
*(2021-08-31)*

#### Fixed
* Money format for [product_price] variable in the SEO Templates
* Images not shows after enabling SEO Friendly URLs for Images

---

## 2.1.16
*(2021-08-30)*

#### Fixed
* After excluding by pattern link of excluded category still persist in page source but without category name
* Redirects loop issue

---

## 2.1.15
*(2021-08-13)*

#### Fixed
* incorrect markdown

---

## 2.1.14
*(2021-08-10)*

##### Fixed
* Ignoring product limits with Porto Theme with category Rich Snippets enabled
* Rich Snippets on the Brand Pages provided by Mirasvit Layered Navigation

---

## 2.1.13
*(2021-07-20)*

#### Fixed
* Missing images with friendly urls in Magento 2.4

---

## 2.1.12
*(2021-05-19)*
#### Improvements
* Abbility to define custom MPN attribute for Product Rs

#### Fixed
* Redirect from cyrrilic URLs
* Autolinks ignored tags

---

## 2.1.11
*(2021-04-26)*

#### Fixed
* Wrong price in the Rich Snippets
* Applying URL Keys from the template for updated products

---

## 2.1.10
*(2021-04-19)*

#### Improvements
* Added ability to select page type for feature "Redirect to lowercase"
* Open Graph (description) on the product page

#### Fixed
* conflicts with PlazaThemes BannerSlide module

---


## 2.1.9
*(2021-04-13)*

#### Fixed
* Unique url key - Product duplicate issue
* Conflicts with Advanced SEO Suite with the sitemap generation
* Checklist ALC
* Redirect if URL "From" matches URL "To"

---


## 2.1.8
*(2021-03-31)*

#### Fixed
* Apply custom url-key if url-key is empty

---


## 2.1.7
*(2021-03-24)*

#### Improvements
* Added Robots to Rewrite

---


## 2.1.6
*(2021-03-24)*

#### Improvements
* Seo Filters 1.1

#### Fixed
* Brands alternate link
* Additional links not showed if exporting of CMS PAGES disabled on the html sitemap page
* empty url (previously product collection factory returns only store_id, without any additional data)
* regenerate thrown exception when url already exists

---



## 2.1.5
*(2021-02-19)*


#### Fixed
* Friendly image urls from custom attribute
* Unavailable checkout with applied robots meta headers
* Conflict with rma attachment download

---

## 2.1.4
*(2021-02-15)*


#### Fixed
* Trailing slash redirects
* Usage [filter_named_selected_options]  in the SEO Templates with applied filter by price

---

## 2.1.3
*(2021-02-03)*

#### Improvement
* Added SEO checklist tool

#### Fixed
* Issue with failing applying of url key templates

---


## 2.1.2
*(2021-01-28)*

#### Fixed
* usage of actions for seo rewrites
* incorrect count of headers
* incorrect count of headers
* not excluded canonical by action
* was added GTIN and SKU attributes to the AggregateOffersData
* excluding canonicals by action

---


## 2.1.1
*(2021-01-06)*

#### Improvement
* Added attribute codes to the attribute labels on the SEO Template conditions tab

#### Fixed
* Autolinks: changed exclude link pattern
* Missing categories on frontend sitemap
* Excluding HTML sitemap categories by pattern
* Zeroes with string type in the templates
* Trailing slash endless redirects issue

---

## 2.1.0
*(2020-12-22)*

#### Fixed
* Compatibility with new core

---


## 2.0.192
*(2020-12-10)*

#### Fixed
* applying template
* variable names comes only from default store when URL-key template applied through CLI

---


## 2.0.191
*(2020-11-26)*

#### Fixed
* visible disabled products on HTML Sitemap

---


## 2.0.190
*(2020-11-19)*

#### Fixed
* apply product template data to additional products block

---


## 2.0.189
*(2020-11-06)*

#### Fixed
* Duplicated category names in the HTML Sitemap

---

## 2.0.188
*(2020-10-28)*

#### Fixed
* Reduce number of SQL queries on the category page (with enabled offer rich snippet)
* Canonical Rewrite for home page

---

## 2.0.186
*(2020-10-21)*

#### Feature
* Disabling categories on pages of HTML Sitemap

#### Fixed
* Trailing slash call Unique constraint violation

---

## 2.0.185
*(2020-10-15)*

#### Fixed
* Creating rewrites with trailing slashes when such option disabled.

---

## 2.0.184
*(2020-10-08)*

#### Fixed
* Trailing slash apply issue
* Append toolbar to 3rd party layered navigation issue
* Adding trailing slashes after prefixes such as html, htm, txt etc.
* Process sitemap category load exceptions
* Fixed issue with incorrect alt attribute value
* Sitemap contains categories and products from another storeview

---

## 2.0.183
*(2020-09-10)*

#### Improvements
* Added search for frontend sitemap

#### Fixed
* Error on Mirasvit Blog Post page when Post assigned to all the storeviews

---

## 2.0.182
*(2020-08-28)*

#### Fixed
* Non applied SEO Friendly Image URLs and ALT Tags templates
* Invalid header value detected with Magesolution Pagebuilder

---

## 2.0.181
*(2020-08-18)*

#### Fixed
* Hide service pages from the frontend sitemap
* Critical error in LoginAsCustomer module caused by CheckUrlObserver
* Access to robots.txt with seo toolbar enabled
* Seo toolbar breaks Codazon MegaMenu binding

#### Improvements
* Improve clickable rows for SEO Templates and SEO Rewrites 

---

## 2.0.180
*(2020-08-11)*

#### Improvements
* Support of GraphQL

## 2.0.179
*(2020-08-04)*

#### Improvements
* Compatibility with Magento 2.4

---

### 2.0.177
*(2020-07-20)*

#### Improvement
* Possibility to define separate usernames in the TwitterCard depended on storeview.
* New frontend sitemap

#### Fixed
* Issue with H1 tags when it defined also in Magento Native SEO
* Set store specific noindex option
* Not exported availability with all out of stock childs
* Empty noindex pages issue
* Empty offers issue for configurable products when all child products are out of stock or disabled
* Ignore CMS Pages option missing pages
* Navigation template was applied everywhere if filter by product
* Issue with adding SeoToolbar to the download actions
* Issue with missed attributes in category RS
* Apply URL key template at the product creation moment
* Permanent export image friendly URL from the main store when sitemap generates through CLI
* Duplicating of Product & Category providers on frontend sitemap
* Issue with unworkable Image SEO Friendly URLs with product flat
* Added protocol to the og:url attribute
* Changed parse_url to the strtok for building url of the twitter card
* Navigation template was applied everywhere if filter by product attribute was applied
* uasort() expects parameter 1 to be array string given during execution bin/magento app:config:import
* Show KB articles in sitemap

---

### 2.0.176
*(2020-05-14)* 

#### Fixed
* Escape alternate tags

---

## 2.0.175
*(2020-04-17)*

#### Fixed
* Sitemap issue on multistores when sitemap generates trough cli with argument --all

---

## 2.0.174
*(2020-03-30)*

#### Fixed
* Visible placeholder when excluded tags defined
* Fixed issue with importing posts URL to the Advanced SEO Sitemap

---

## 2.0.173
*(2020-03-18)*

#### Fixed
* Product description from seo template wasn't export into rich snippets
* Duplicated baseUrls in the sitemap item links

---

## 2.0.172
*(2020-03-04)*

#### Fixed
* Limits for frontend sitemap
* Invalid argument supplied for foreach() on Blog Pages with single store installation
* Performance issue on category pages with enabled Rich Snippet's product offers
* Category description block wasn't shown in SEO templates

---

## 2.0.171
*(2020-02-11)*

#### Fixed
* Missing redirect type
* Unable to apply images friendly URLs after Template for URL key of Product Images change
* Use default canonical for navigation pages

---

## 2.0.170
*(2020-02-04)*

#### Improvement
* Export of Mirasvit Brand pages into sitemap

#### Fixed
* Issue when custom seo template field was empty
* Module brand alternate URLs when brand was disabled in the one of the storeviews
* Incorrect URLs of posts from Magefan Blog extension

---

## 2.0.169
*(2020-01-21)*

#### Improvement
* Searchbox in Rich Snippets

#### Fixed
* Issue with SEO templates conditions
* Issue with alternate tags when category disabled for one of storeviews

---

## 2.0.168
*(2020-01-02)*

#### Fixed
* Sitemap path
* Invalid argument supplied for foreach()

---



## 2.0.167
*(2019-12-25)*

#### Improvements
* Sitemap compatibility with Magefan Blog

#### Fixed
* Possible XSS from the backend

---

## 2.0.166
*(2019-12-23)*

#### Fixed:
* Unable to apply conditions for SEO templates
* Don't add links inside tags functionality
* Product seo template apply child categories issue
* Duplicate domain in the sitemap URLs

---

## 2.0.165
*(2019-12-10)*

#### Fixed
* Undefined variable socialLinks

---

## 2.0.164
*(2019-12-10)*

#### Fixed
* Issue with alternate tags on pages Mageplaza Blog

#### Improvements
* Social links in Rich Snippets

---

## 2.0.163
*(2019-12-09)*

#### Fixed
* Rich snippets incorrect prices round
* Apply templates for product image url and alt for 
* Hide alternate url for non-visible product
* Issue with non-well formed numeric price

#### Improvements
* Use SEO templates description in rich snippets

---

## 2.0.162
*(2019-11-18)*

#### Improvements
* Template Syntax Editor

---


## 2.0.161
*(2019-11-13)*

#### Fixed
* Issue when image:caption tag empty
* Mirasvit blog alternate urls processing
* Rich Snippets warnings

---

## 2.0.160
*(2019-11-05)*

#### Fixed
* Issue with Mageplaza blog URLs (XML Sitemap)
* Disable Rich Snippet markup for ROOT category (case of Shop by Brand)

---


## 2.0.159
*(2019-10-31)*

#### Improvements
* SEO Templates for CMS Pages
* Autolinks refactoring

#### Fixed
* error when trying to add canonical rewrite
* incorrect minPrice\maxPrice values

---


## 2.0.158
*(2019-10-15)*

#### Fix
* Frontend sitemap pager issue
* Sitemap path issue on Magento EE

---

## 2.0.157
*(2019-10-07)*

#### Improvements
* Rich Snippets Reviews for current storeview only.
* SEO Sitemap refactoring.
* SEO Sitemap integration with Mageplaza Blog.

---

## 2.0.156
*(2019-10-04)*

#### Fixed
* Non well formed numeric value issue with final price

---

## 2.0.155
*(2019-10-02)*

#### Fixed
* Missing special price on product rich snippet
* Alternate urls missing on category page

---

## 2.0.154
*(2019-09-26)*

#### Fixed
* Issue with attribute option labels during CLI url generation

---

## 2.0.153
*(2019-08-27)*

#### Improvements
* Enable/Disable option for the Rich Snippets on the product pages.


#### Fixed
* Pattern [parent_url] exports category name instead of URL.
* Rich Snippets performance issue on category pages.

---

## 2.0.152
*(2019-08-15)*

#### Improvements
* Auto-links setup refactoring

#### Fixed
* Issue with custom og:image
* Serialization issue

---

## 2.0.151
*(2019-08-08)*

#### Fixed

* Issue with non applied templates for image URLs

---

## 2.0.150
*(2019-08-02)*

#### Fixed
* Issue with AWBlog posts in sitemap
* Issue with missed image urls in sitemap
* Issue with trailing slashes in the alt tags
* Undefined property $moduleManager

---

## 2.0.149
*(2019-07-24)*

#### Fixed
* Knowledge Base's alternate tags

---


## 2.0.148
*(2019-07-12)*

#### Fixed
* AggregateRating for category pages

---


## 2.0.147
*(2019-07-11)*

#### Improvements
* Show / hide disabled and out of stock products in SEO Sitemap
* Add aggregateRating for category pages (average rating for existing products)

#### Fixed
* added low price and hign price for grouped and bundle products
* Can't apply "is one of" rule
* Add separate configuration for category rich snippets deletion
* Missing interface after compilation

---


## 2.0.146
*(2019-06-05)*

#### Fixed
* issue with filterattribute_(Nlevel) in Robots Meta Header when SeoFilter enabled
---


## 2.0.145
*(2019-05-27)*

#### Improvements
* Set default value for RS priceValidUntil

#### Fixed
* Added escape for canonical urls
* Image SEO friendly urls
* SEO template can`t set meta title

---


## 2.0.144
*(2019-05-10)*

#### Improvements
* SEO Toolbar IPS

#### Fixed
* URL generation CLI
* SEO templates compatibility with Manadev LayeredNavigation

---


## 2.0.143
*(2019-04-25)*

#### Fixed
* Canonical Rewrites by conditions
* Empty seo sitemap link in the footer

---


## 2.0.142
*(2019-04-16)*

#### Improvements
* SEO Toolbar

#### Fixed
* Canonical Rewrites for products

---


## 2.0.141
*(2019-04-12)*

#### Fixed
* Area code issue with n98-magerun2.phar sys:url:list

---


## 2.0.140
*(2019-04-11)*

#### Fixed
* Improved performance for some extreme cases 
* Use canonical url for sitemap
* Issue with disapear rules in Meta Templates
* SEO Template - Product Rules

#### Improvements
* Mirasvit Blog posts sitemap integration
* Fishpig WordPress blog posts sitemap integration
* Added Rich Snippets to Mirasvit LayeredNavigation Brand page

---


## 2.0.139
*(2019-04-01)*

#### Improvements
* Add seo friendly urls for images of sitemap ([#178]())

---


## 2.0.138
*(2019-03-29)*

#### Improvements
* "debug" query param for dispaly toolbar

#### Fixed
* Issue with redirect during paypal checkout (if option redirect to lowercase URL is enabled)

---


## 2.0.137
*(2019-03-22)*

#### Improvements
* Ability to disable/enable native Meta Title Prefix/Suffix for custom Meta Titles (manually entered or using SEO Templates)
* Refactoring of cross-links (auto-links) algorithm

#### Fixed
* Auto-links add wrong symbols in some configurations

---


## 2.0.136
*(2019-03-18)*

#### Features
* Allow to add autolinks to Mageplaza blog posts

#### Fixed
* Autolinks are not applied if keyword has a dash (-)

---


## 2.0.134
*(2019-03-14)*

#### Fixed
* Autolinks for CMS Static Blocks

#### Improvements
* Added autolinks debugger to SEO Toolbar

---


## 2.0.133
*(2019-03-11)*

#### Fixed
* Issue with Closure

---


## 2.0.132
*(2019-03-07)*

#### Fixed
* Use Current Currency for RS Offer
* Set main image when SEO-friendly URLs for Product Images enabled
* Cross-links for Short Description (from content template)

---


## 2.0.131
*(2019-02-26)*

#### Improvements
* Added H1 Title to category edit form

#### Fixed
* Issue with applying magento variables in seo content
* Possible array issue with filters

---


## 2.0.130
*(2019-02-11)*

#### Improvements
* Refactoring

---


## 2.0.129
*(2019-02-07)*

#### Improvements
* Ability to use short description in product rich snippets

#### Fixed
* Return OutOfStock, if price is not available
* Auto links are not applied in some cases 

---


## 2.0.128
*(2019-02-01)*

#### Improvements
* Breadcrumbs rich snippet: Deepest path, if current path is empty

#### Fixed
* Issue with adding rel=next/prev on category page

---


## 2.0.127
*(2019-01-30)*

#### Improvements
* Ability to use Template Rules for Layered Navigation selected filters

#### Fixed
* Issue with canonical rewrite filters
* Issue with secret key

---


## 2.0.126
*(2019-01-23)*

#### Improvements
* AggregateOffer Rich Snippet for Configurable products

#### Fixed
* Rich Snippet final price for simple products (tax)
* Wrong price in Rich Snippets (if price > 10000)
* Issue with Z/W chars in seo templates
* XML sitemap does not include .html suffix for Mirasvit KB URLs

---


## 2.0.125
*(2019-01-11)*

#### Fixed
* Issue with item condition

---


## 2.0.124
*(2019-01-10)*

#### Fixed
* Possible issue with sitemap generation (Class Mirasvit\Seo\Api\Config\ImageConfigServiceInterface does not exist)
* Aggregate rating

---


## 2.0.123
*(2019-01-08)*

#### Improvements
* Image friendly urls and alts (Magento 2.3)
* Changed aggregated rating calculation logic (Rich Snippets)

#### Fixed
* Issue with apply templates for child categories
* Possible M2.1 issue: Cannot instantiate interface Magento\Catalog\Model\Product\Media\ConfigInterface
* Possible issue during update from old versions using manual installtion

---


## 2.0.121
*(2018-12-19)*

#### Improvements
* Moved Reviews Snippets to product markup

#### Fixed
* Issue with empty description for product rich snippet (if use meta description option)

---


## 2.0.119
*(2018-12-18)*

#### Fixed
* Issue with Rich Snippets removing on product page

---


## 2.0.118
*(2018-12-17)*

#### Fixed
* Issue with duplication product RS

---


## 2.0.117
*(2018-12-14)*

#### Fixed
* SEO alt tags didn't use storeview settings
* Possible issue with AJAX requests of 3rd party plugins

---


## 2.0.116
*(2018-12-14)*

#### Fixed
* Issue with special price in Rich Snippet
* Changed twitter meta key "property" to "name"

---


## 2.0.114
*(2018-12-13)*

#### Fixed
* Issue with page config

---


## 2.0.113
*(2018-12-12)*

#### Fixed
* Removing native rich snippets with enabled Page Cache

---


## 2.0.112
*(2018-12-08)*

#### Fixed
* Issue with multi-store frontend sitemap

---


## 2.0.111
*(2018-12-07)*

#### Improvements
* Leave pagination meta if length limiters are enabled

#### Fixed
* Issue with duplication Pagination meta

---



## 2.0.110
*(2018-12-07)*

#### Features
* Added option "Don't add automatically" for SEO description

#### Fixes
* In some cases, don't show two times CatalogOffer Rich Snippet

---


## 2.0.109
*(2018-12-06)*

#### Features
* Add SEO description widget

#### Improvements
* Rich Snippets for Category/Product Listing (OfferCatalog)
* Breadcrumbs Rich Snippet

---


## 2.0.106
*(2018-12-03)*

#### Fixed
* Issue with applying product urls for different store views (label option for select)

---


## 2.0.105
*(2018-11-29)*

#### Fixed
* Compatibility with Magento 2.3

---

## 2.0.104
*(2018-11-23)*

#### Fixed
* Empty attribute

---


## 2.0.103
*(2018-11-22)*

#### Fixed
* Issue with H1 Title logic
* Solved possible issues with AJAX requests of 3rd-party plugins
* Issue with reviews pagination

---


## 2.0.102
*(2018-11-20)*

#### Fixed
* Category Description

---


## 2.0.101
*(2018-11-19)*

#### Improvements
* Meta Title

#### Fixed
* Issue with Default Category Description

---


## 2.0.100
*(2018-11-16)*

#### Fixed
* Sm_ShopBy first page issue

---


## 2.0.98
*(2018-11-15)*

#### Fixed
* Prefix&Suffix in title

---


## 2.0.97
*(2018-11-14)*

#### Fixed
* Issue with rule validation on product page

---


## 2.0.96
*(2018-11-12)*

#### Fixed
* Added Template for SEO description to product rules

---


## 2.0.95
*(2018-11-09)*

#### Fixed
* Issue with saving Store View for Templates
* Areacode issue during CLI sitemap generation

---


## 2.0.94
*(2018-11-08)*

#### Fixed
* Migration for template rules
* Issue with "select" product attributes in meta templates
* Issue with applying [category_parent_name]
* Incorrect 'hreflang x-default' for some cases

---


## 2.0.93
*(2018-11-06)*

#### Improvements
* Toolbar Information

#### Fixed
* Issue with redirect or error on non-native checkout (affected versions since 2.0.86)
* Reviews are not loaded on product page (affected versions since 2.0.86)
* Undefined offset in TemplateEngine (affected versions since 2.0.86)

---


## 2.0.92
*(2018-10-31)*

#### Fixed
* Issue with Varnish urls

---


## 2.0.91
*(2018-10-30)*

#### Fixed
* Issue with category rich snippet

---


## 2.0.90
*(2018-10-28)*

#### Fixed
* Issue with pagination meta title
* Solved issue Argument 2 passed to Magento\Theme\Controller\Result\MessagePlugin::afterRenderResult() must implement interface Magento\Framework\Controller\ResultInterface
* Refactoring

---


## 2.0.87
*(2018-10-25)*

#### Improvements
* Added description position for SEO Rewrites

#### Fixed
* Autolinks for SEO description
* Issue with rewrite url pattern

---


## 2.0.86
*(2018-10-22)*

#### Fixed
* Custom template position
* Minor error during saving of not-valid cms page
* Issue with Blog sitemap

---


## 2.0.85
*(2018-08-30)*

#### Fixed
* Issue with less compile (SM theme)

---



### 2.0.84
*(2018-08-23)*

#### Fixed
* Fixed an issue with pub in images urls

---

### 2.0.83
*(2018-08-20)*

#### Fixed
* Fixed an issue with mass action for redirects
* Fixed an absence of home page in xml sitemap (for Magento 2.2.4 and 2.2.5)

---

### 2.0.82
*(2018-08-20)*

#### Fixed
* Fixed ability set product urls if Product URL Key Template enabled (for some stores)

---

### 2.0.81
*(2018-08-08)*

#### Fixed
* Fixed impossibility use Canonical Rewrite->Regular expression for some pages
* Issue with Blog sitemap

---

### 2.0.80
*(2018-08-06)*

#### Fixed
* Fixed an error "Fatal error: Uncaught Error: Call to undefined method Magento\Catalog\Model\ResourceModel\Category\Collection::getAllAttributeValues() in..." if in Canonical Rewrite use product attribute

---

### 2.0.79
*(2018-08-02)*

#### Fixed
* Fixed SEO description position (if set Under Product List)
* Fixed an issue with redirect for customer_address_form action

---

### 2.0.78
*(2018-07-30)*

#### Fixed
* Fixed hreflang x-default (if configured manually)

#### Features
* Ability to change category description and category image via SEO templates
* Ability use redirect chain

---

### 2.0.77
*(2018-07-20)*

#### Fixed
* Fixed an issue with tags like {{store url=""}}

---

### 2.0.76
*(2018-07-19)*

#### Fixed
* Fixed meta title for not category pages

---

### 2.0.75
*(2018-07-17)*

#### Fixed
* Fixed an error: "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '9-Search Engine Optimization' for key 'EAV_ATTRIBUTE_GROUP_ATTRIBUTE_SET_ID_ATTRIBUTE_GROUP_NAME', query was: INSERT INTO `eav_attribute_group` (`attribute_set_id`, `attribute_group_name`, `sort_order`, `attribute_group_code`) VALUES (?, ?, ?, ?)"


---

### 2.0.74
*(2018-07-02)*

#### Improvements
* addressRegion snippets
* Gtin snippets

---

### 2.0.73
*(2018-06-23)*

#### Fixed
* Fixed incorrect snippets image url (for some stores)

---

### 2.0.72
*(2018-06-23)*

#### Fixed
* bug: Fixed "Wrong Hreflang locale code value" info

---

### 2.0.71
*(2018-06-21)*

#### Fixed
* Fixed frontend sitemap error (for big categories)

---

### 2.0.70
*(2018-06-14)*

#### Fixed
* bug: Fixed setup:di:compile error

---

### 2.0.69
*(2018-06-13)*

#### Fixed
* Fixed frontend sitemap (for some stores)

---

### 2.0.68
*(2018-06-12)*

#### Fixed
* Fixed category Open Graph image (if "Category Opengraph" set to "Use first product image")
* Fixed incorrect snippets

---

### 2.0.67
*(2018-06-11)*

#### Fixed
* Fixed redirect loop for home page (if index.php always in REQUEST_URI)
* Fixed incorrect frontend sitemap redirect loop (for some stores)
* Compatibility with Mgs/unero theme

---

### 2.0.66
*(2018-06-01)*

#### Fixed
* Fixed an issue with redirect for all 404

---

### 2.0.65
*(2018-05-29)*

#### Fixed
* Fixed security if "Allow use HTML symbols in meta tags" is enabled

---

### 2.0.64
*(2018-05-24)*

#### Fixed
* Fixed incorrect meta description if "Allow use HTML symbols in meta tags" is enabled and symbol '"' exist in meta description

---

### 2.0.63
*(2018-05-23)*

#### Fixed
* Fixed description template (for some stores)

---

### 2.0.62
*(2018-05-03)*

#### Improvements
* Snippets for Amasty page

#### Fixed
* Fixed "pub" in sitemap for images (for some stores)

---

### 2.0.61
*(2018-04-26)*

#### Fixed
* Fixed incorrect sitemap image urls for multistores (Magento 2.2.*)

---

### 2.0.60
*(2018-04-25)*

#### Fixed
* Fixed incorrect sitemap image urls for multistores with different CDN (Magento 2.1.*)

---

### 2.0.59
*(2018-04-24)*

#### Fixed
* Fixed incorrect menu text for multistores if Alternate configured (for some stores)
* Fixed incorrect images if "Enable SEO-friendly URLs for Product Images" is enabled (for some stores)

---

### 2.0.58
*(2018-04-24)*

#### Fixed
* Fixed an error "Fatal error: Uncaught Error: Call to a member function setCurPage() on boolean"

---

### 2.0.57
*(2018-04-24)*

#### Improvements
* Additional info for template page

#### Fixed
* Fixed Product Short description templates for category page
* Fixed incorrect H1 tags count in SEO toolbar
* Fixed sitemap generation error: "Column not found: 1054 Unknown column 't2_thumbnail.value' in 'field list', ..."

---

### 2.0.56
*(2018-04-18)*

#### Improvements
* Ability use widget in short and full description template
* Ability change product short description for categories
* Ability delete wrong snippets from home page

#### Fixed
* Fixed incorrect canonical url for home page if "Add Store Code To Urls" is enabled
* Fixed Breadcrumbs Rich Snippets for category

---

### 2.0.55
*(2018-04-17)*

#### Improvements
* Ability add open graph image for every cms page
* Ability use widget in SEO description

#### Fixed
* Fixed an error: 'Class Aheadworks\Blog\Helper\Sitemap does not exist'
* Fixed error when "Enable Link Rel="next/prev" is enabled (for some stores)
* Fixed incorrect Open Graph when "Allow use HTML symbols in meta tags" is enabled
* Fixed twitter card when cache enabled

#### Documentation
* Documentation update

---

### 2.0.54
*(2018-04-11)*

#### Improvements
* Allow use HTML symbols in meta tags

---

### 2.0.53
*(2018-04-06)*

#### Fixed
* Fixed update error "PHP Fatal error:  require(): Failed opening required '...vendor/composer/../mirasvit/module-seo/src/SeoFilter/registration.php' ..."

---

### 2.0.52
*(2018-04-05)*

#### Fixed
* Compatibility SeoFilter with manual installation

---

### 2.0.51
*(2018-04-05)*

#### Fixed
* Fixed an error "Requested product doesn't exist .../vendor/mirasvit/module-seo/src/Seo/Observer/Canonical.php(249)"

---

### 2.0.50
*(2018-04-03)*

#### Improvements
* SeoFilter as additional extension

#### Fixed
* Fixed an error "JSON-LD	Missing ',' or '}' in object declaration."
* Fixed an error "Notice: Undefined index: src in .../vendor/mirasvit/module-seo/src/Seo/Helper/Analyzer.php on line 261"

---

### 2.0.49
*(2018-04-02)*

#### Improvements
* Friendly image additional check

---

### 2.0.48
*(2018-03-29)*

#### Fixed
* Fixed an error "Fatal error: Method Magento\Ui\TemplateEngine\Xhtml\Result::__toString() must not throw an exception, caught Error: Call to a member function getId() on null in .../vendor/magento/module-ui/Component/Wrapper/UiComponent.php on line 0"

---

### 2.0.47
*(2018-03-28)*

#### Fixed
* Fixed incorrect symbols for rich snippets
* Fixed incorrect sitemap path when sitemap is splitted and generated by cron
* Fixed incorrect redirect

---

### 2.0.46
*(2018-03-28)*

#### Fixed
* Fixed incorrect symbols for rich snippets
* Fixed incorrect sitemap path when sitemap is splitted and generated by cron
* Fixed incorrect redirect

---

### 2.0.45
*(2018-03-23)*

#### Improvements
* Ability use store_mp_brand variable for Mageplaza Shopbybrand brand page

---

### 2.0.44
*(2018-03-20)*

#### Improvements
* SEO Rewrites sort order
* Redirect uppercase to lowercase
* Ability add custom canonical for product

#### Fixed
* Fixed an incorrect product order if 'Enable Link Rel="next/prev"' set to 'Yes'
* Fixed "SEO description" for "SEO Rewrite"

---

### 2.0.43
*(2018-03-13)*

#### Fixed
* Fixed double data register for breadcrumbs
* Delete invisible symbols during import

---

### 2.0.42
*(2018-03-09)*

#### Improvements
* Canonical to store without store code

#### Fixed
* Mageplaza Shop By Brand compatibility

---

### 2.0.41
*(2018-03-05)*

#### Improvements
* Show website in visibility field
* Delete wrong snippets automatically

#### Fixed
* Fixed "Additional links" config for store
* Fixed sitemap url if use pub folder

---

### 2.0.40
*(2018-03-01)*

#### Improvements
* Prefer https for Cross Domain Canonical URL

---

### 2.0.39
*(2018-02-19)*

#### Features
* Ability to add snippets to individual product reviews

---

### 2.0.38
*(2018-02-14)*

#### Documentation
* Added information on new features usage to extension's documentation and interface help hints

#### fixed
* Compilation error "Incorrect dependency in class Mirasvit\Seo\Observer\Canonical"(for some stores, affected versions 2.0.30 - 2.0.37)

---

### 2.0.37
*(2018-02-14)*

#### Improvements
* Different redirect codes for Redirect Management subsystem(301, 302, 307) are now available

---

### 2.0.36
*(2018-02-13)*

#### Features
* CLI commands to generate Google sitemap files (php bin/magento mirasvit:seositemap:generate --info | --all | --sitemap_id)

---

### 2.0.35
*(2018-02-09)*

#### Improvements
* Twitter Card information can be added to any store frontend page

---

### 2.0.34
*(2018-02-07)*

#### Features
* Add Twitter Summary Cards on store product pages

---

### 2.0.33
*(2018-02-06)*

#### Fixed
* Checkout page does not load correctly when "Trailing Slash" option is enabled(for some stores)

---

### 2.0.32
*(2018-02-05)*

#### Fixed
* Images not displayed when added using WYSIWYG editor on "Edit Product" Admin Panel page and displayed via Product SEO Templates using [product_description] and [product_short_descripption] template variables.

---

### 2.0.31
*(2018-02-05)*

#### Fixed
* 'Unique constraint violation found' Exception fixed if SEO Filters enabled(for some stores)

---

### 2.0.30
*(2018-02-02)*

#### Fixed
* Fixed canonical link for Home Page on multilingual stores when Web > URI Options > "Add Store Code to URLs" is set to "Yes" and Marketing > Advanced SEO Suite > Settings > "Trailing Slash" is set to "Redirect to the same page without trailing slash"

---

### 2.0.29
*(2018-01-31)*

* ChangeLog alterations

---

### 2.0.28
*(2018-01-31)*

* ChangeLog alterations

---

### 2.0.27
*(2018-01-30)*

#### Fixed
* Fixed "Requested country is not available." exception for some cases when "Organization snippets" enabled.
* Fixed Ajax failing with Exception #0 (RuntimeException): Catalog Layer has been already created
* Fixed "Exception #0 (Zend_Db_Statement_Exception): SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails" for some stores when SEO Filters enabled
* Fixed empty meta description on category pages(for some stores due to theme specifics or customizations)

#### Improvements
* [category_brand_name] variable is added to be used for meta information templates on "Shop By Brand" pages

---

### 2.0.26
*(2018-01-09)*

#### Fixed
* Fixed 404 NOT FOUND error if store don't use suffix and SEO Filters enabled
* XML Google Sitemap links are now generated according to "Trailing Slash" option of Mirasvit Seo(if enabled)

---

### 2.0.25
*(2018-01-04)*

#### Fixed
* Fixed compilation error (for magento 2.1.10)
After run php bin/magento setup:di:compile you will see following
[ReflectionException]
  Class Magento\Catalog\Model\View\Asset\ImageFactory does not exist

---

### 2.0.24
*(2017-12-28)*

#### Fixed
* Fixed generation of Product Images Alt and Title for category page (for magento 2.1.6)
* Fixed minor issue with mass status changes for SEO rewrite in admin panel
* Fixed redirecting from URLs with URL parameters

---

## 2.0.22
*(2017-12-14)*

#### Fixed
* Fixed error with friendly URLs for Product Images (for magento 2.1.6)

---

### 2.0.21
*(2017-12-11)*

#### Fixed
* "Notice: Undefined variable: formattedMinPrice" fixed for category snippets on some stores

---

### 2.0.20
*(2017-12-11)*

#### Documentation
* Documentation for new functionality added

---

### 2.0.19
*(2017-12-07)*

#### Fixed
* Product rich snippets fixed

---

### 2.0.18
*(2017-12-07)*

#### Fixed
* Stability adjustments introduced
* Fixed "Uncaught Error: Call to a member function getAttribute() on null" for vendor attribute on some stores

---

### 2.0.17
*(2017-11-27)*

#### Fixed
* Fixed admin load time issue.

---

### 2.0.16
*(2017-11-20)*

#### Fixed
* Fixed the long page load if too much html tags

---

### 2.0.15
*(2017-11-16)*

#### Fixed
* Fixed incorrect votes snippets (from 2.0.14)

---

### 2.0.14
*(2017-11-14)*

#### Features
* Snippets using JSON-LD

---

### 2.0.13
*(2017-11-14)*

#### Improvements
* Added "ratingCount"

---

### 2.0.12
*(2017-11-07)*

#### Fixed
* Compatibility with helpdesk

---

### 2.0.11
*(2017-10-31)*

#### Fixed
* Fixed compilation error.

---

### 2.0.10
*(2017-10-19)*

#### Features
* SEO-friendly URLs for Product Images

---

### 2.0.9
*(2017-10-17)*

#### Fixed
* Fix setup:di:compile error

---

### 2.0.8
*(2017-10-17)*

#### Fixed
* Template rule compatibility (magento 2.2)

---

### 2.0.7
*(2017-10-13)*

#### Fixed
* Fixed setup:di:compile error
* Fixed an error with serializer (magento 2.2)
* Fixed an error if rule enabled

---

### 2.0.6
*(2017-10-10)*

#### Fixed
* Fixed an error:"Unknown module(s): 'Mirasvit_SeoFilter'"

---

### 2.0.5
*(2017-10-09)*

#### Features
* Seo filters
* Canonical rewrite

#### Fixed
* Patch to prevent "Exception: Warning: Invalid argument supplied for foreach()" for some stores
* Fixed an error if use setup::install

#### Documentation
* Documentation improvement

---

### 2.0.4
*(2017-09-29)*

#### Fixed
* Fixed an error with rules (magento 2.2)

---

### 2.0.3
*(2017-09-27)*

#### Fixed
* Magento 2.2 compatibility

---

### 2.0.2
*(2017-09-25)*

#### Fixed
* Disable command

---

### 2.0.1
*(2017-09-18)*

#### Improvements
* Manual links

#### Fixed
* Fixed Mirasvit Blog sitemap for multistores
* Fixed Mirasvit Kb sitemap for multistores
* Fixed sitemap generation by cron
* Fix alternate tags issue
* Compatibility with Codazon Fastest theme

---

### 2.0.0
*(2017-08-30)*

#### Improvements
* Refactoring

---

### 1.0.80
*(2017-08-30)*

#### Improvements
* Refactoring

---

### 1.0.79
*(2017-08-30)*

#### Improvements
* Refactoring

---

### 1.0.78
*(2017-08-29)*

#### Fixed
* Fixed incorrect canonical if Trailing slash enabled
* Fixed an error (for Magento 2.0.x)

---

### 1.0.77
*(2017-08-15)*

#### Fixed
* Fixed sitemap folder

#### Documentation
* Online manual enhancement

---

### 1.0.76
*(2017-08-14)*

#### Improvements
* User interface minor improvement

#### Fixed
* Fixed alternate tags bug

---

### 1.0.75
*(2017-08-03)*

#### Fixed
* Minor Mirasvit Knowledge Base compatibility

---

### 1.0.74
*(2017-08-01)*

#### Improvements
* Added ability to define unique Organization snippets information for different store views
* Added ability to define SEO Toolbar position

---

### 1.0.73
*(2017-07-28)*

#### Improvements
* Mirasvit Knowledge Base sitemap

#### Fixed
* fixed missing Opengraph tags for Home page
* Fixed missing Rich Snippets Breadcrumbs of BreadcrumbList type on product pages
* Fixed an issue of duplicating Hreflang locale code on product pages(for some stores)

---

### 1.0.72
*(2017-07-27)*

#### Fixed
* Fixed incorrect meta tags for layered navigation

---

### 1.0.71
*(2017-07-24)*

#### Improvements
* User Interface adjustments

#### Documentation
* Online User Manual updated

---

### 1.0.70
*(2017-07-21)*

#### Improvements
* compatibility with Page Cache Warmer version 1.0.33

---

### 1.0.69
*(2017-07-13)*

#### Improvements
* Canonical for Magefan_Blog

#### Fixed
* Fixed sitemap issue
* Fixed an issue with incorrect links limit per page

---

### 1.0.68
*(2017-06-23)*

#### Fixed
* Fixed an issue with incorrect links limit per page

---

### 1.0.67
*(2017-06-23)*

#### Fixed
Message ```product key already exists for the following product``` on ```mirasvit:seo --apply-product-url-key-template```
execution now does not stop  command from applying URL-key template for other matching products in a row

---

### 1.0.66
*(2017-06-22)*

#### Fixed
* Fixed caching issue

---

### 1.0.65
*(2017-06-20)*

#### Documentation
* Online User Manual updated

---

### 1.0.64
*(2017-06-16)*

#### Fixed
* "The filter must be an object. Please set a correct filter" error fixed(for some stores)
* Performance issue fixed for attributes block on product view page

---

### 1.0.63
*(2017-05-31)*

#### Improvements
* Rich Snippets accuracy and price formatting improved

#### Fixed
* Incorrect Robots meta header tags config data (magento 2.2.0-dev)

---

### 1.0.62
*(2017-05-24)*

#### Fixed
* Incorrect alternate tags config data (magento 2.2.0-dev)

---

### 1.0.61
*(2017-05-23)*

#### Features
* Ability to define product images alt, title and caption tags for frontend and Google sitemap

---

### 1.0.60
*(2017-05-22)*

#### Features
* Ability add alternate tags for any stores combinations

#### Fixed
* Fixed child category sitemap
* Fixed cms alternate group issue
* Fixed an error with circular dependency

---

### 1.0.59
*(2017-05-04)*

#### Improvements
* Auto Links documentation and example CSV file actualized

#### Fixed
* Fixed breadcrumbs design issue when SM Himarket extension installed

#### Documentation
* General user manual adjustments made

---

### 1.0.58
*(2017-04-24)*

#### Improvements
* "Apply to child categories" setting added to make SEO Templates management more flexible

---

### 1.0.57
*(2017-04-10)*

#### Features
* Ability add seo description in any template

#### Improvements
* Сompatibility with Magefan_Blog

#### Fixed
* Fixed alternate tags for Amasty Xlanding page

---

### 1.0.56
*(2017-03-30)*

#### Fixed
* Fixed issue with ability download Import Links example

---

### 1.0.55
*(2017-03-30)*

#### Fixed
* Fixed issue with ability download Import Links example

---

### 1.0.53
*(2017-03-28)*

#### Fixed
* Fixed Open Graph issue

---

### 1.0.52
*(2017-03-27)*

#### Features
* Ability use paths of templates to add links inside

#### Fixed
* Fixed an error if can't get image url
* Fixed sitemap error if blog haven't category

---

### 1.0.51
*(2017-03-23)*

#### Improvements
* Amasty_Xlanding compatibility
* Cut category additional data for alternate url
* Delete 'home' for home page in sitemap
* Paginated canonical
* Manufacturer part number snippets
* Trailing slash
* AW Blog sitemap

#### Fixed
* Fixed mysql error "Unknown column 't2_name.value'"
* Fixed an issue with Product URL Key Template

---

### 1.0.50
*(2017-02-14)*

#### Improvements
* Ability set Max Length for Product Name and Max Length for Product Short Description

---

### 1.0.49
*(2017-02-13)*

#### Fixed
* Fixed an issue with paypal "Skip Order Review Step"

### 1.0.48
*(2017-02-13)*

#### Fixed
* Fixed an issue with paypal "Skip Order Review Step"

---

### 1.0.47
*(2017-02-10)*

#### Fixed
* Fixed redirect issue
* Fixed ad issue with incorrect meta tags on brand page

---

### 1.0.46
*(2017-01-30)*

#### Improvements
* Added ability use x-default alternate tag
* Ability use different positions for SEO Description

#### Fixed
* Fixed an issue with incorrect snippets for an empty category
* Fixed an issue with double slash in canonical (forsome stores)
* Fixed an issue with HTML5 validation

---

### 1.0.45
*(2017-01-25)*

#### Improvements
* Store template improvement
* Toolbar overflow

#### Fixed
* Fixed an issue with adding robots tags (for some pages)
* Fixed issue with broken html on product page (if snippets enabled)
* Fixed an issue with incorrect title

---

### 1.0.44
*(2017-01-16)*

#### Fixed
* Fixed seo rewrite issue for contact page
* Fixed redirect for account/create page

---

### 1.0.43
*(2017-01-10)*

#### Improvements
* Ability show seo toolbar depending from cookie

#### Fixed
* Fixed an issue with store template

---

### 1.0.42
*(2016-12-29)*

#### Improvements
* Ability set new condition snippet for all products

---

### 1.0.41
*(2016-12-27)*

#### Fixed
* Fixed notice

---

### 1.0.40
*(2016-12-26)*

#### Fixed
* Fixed an issue with check url observer (sql query throw error)

---

### 1.0.39
*(2016-12-23)*

#### Fixed
* Fixed an issue with displaying seo description block

---

### 1.0.38
*(2016-12-09)*

#### Improvements
* Compatibility with M2.2

---

### 1.0.36
*(2016-12-08)*

#### Fixed
* Fixed division by zero error

---

### 1.0.35
*(2016-12-07)*

#### Features
* BreadcrumbList snippets

---

### 1.0.34
*(2016-11-24)*

#### Fixed
* Fixed an issue with incorrect rich snippets

---

### 1.0.33
*(2016-11-21)*

#### Features
* Ability export redirects

---

### 1.0.32
*(2016-11-11)*

#### Fixed
* Fixed an issue with incorrect alternate tags (for some stores)
* Fixed error if slash exist in autolink keyword

---

### 1.0.31
*(2016-11-08)*

#### Fixed
* Fixed an issue with page load delay (if large number of redirects with *)

---

### 1.0.30
*(2016-11-07)*

#### Improvements
* Compatibility with  extension Mirasvit CacheWarmer version 1.0.1

---


### 1.0.29
*(2016-10-27)*

#### Fixed
* Fixed an issue with SEO template error

---

### 1.0.28
*(2016-10-24)*

#### Fixed
* Fixed an issue with users roles

---

### 1.0.27
*(2016-10-18)*

#### Fixed
* Fix compilation error

---

### 1.0.26
*(2016-10-18)*

#### Fixed
* Fixed an issue with FPC performance

---

### 1.0.25
*(2016-10-12)*

#### Fixed
* Fixed an issue with redirect error

---

### 1.0.24
*(2016-10-12)*

#### Improvements
* Use the same font-awesome.min.css for all extensions

---

### 1.0.23
*(2016-10-10)*

#### Improvements
* Ability set store id in import file

#### Fixed
* Fixed an error if get parent category data

---

### 1.0.22
*(2016-10-06)*

#### Fixed
* Fix notice
* Fixed an issue with broken design (for some stores)
* Fixed an issue with incorrect store code in URL for Autolinks
* Fixed an issue with Cross Domain Canonical
* Fixed an issue with attribute error

---

### 1.0.21
*(2016-09-28)*

#### Fixed
* Fix compilation error

---

### 1.0.20
*(2016-09-27)*

#### Fixed
* Fix undefined index notice
* Fixed an issue with attribute error

---

### 1.0.19
*(2016-09-26)*

#### Fixed
* Fixed an issue with snippets comma in price

---

### 1.0.18
*(2016-09-22)*

#### Fixed
* Fixed an issue with filter attributes for robots tags

---

### 1.0.17
*(2016-09-22)*

#### Fixed
* Fixed an issue with robots tags for search pages

---

### 1.0.16
*(2016-09-20)*

#### Fixed
* Fixed notice

---

### 1.0.15
*(2016-09-19)*

#### Features
* Ability change product url key by template

---

### 1.0.14
*(2016-09-12)*

#### Fixed
* Fixed breadcrumbs issue for venustheme

---

### 1.0.13
*(2016-09-07)*

#### Fixed
* Fixed an issue with excluding pages from XML sitemap

---

### 1.0.12
*(2016-08-23)*

#### Fixed
* Fixed an issue with wrong title on home page

---

### 1.0.11
*(2016-08-22)*

#### Features
* Added ability to use a longest product url as canonical

#### Fixed
* Fixed an issue with incorrect aggregate rating value

---

### 1.0.10
*(2016-08-08)*

#### Fixed
* Fixed an error if Category Opengraph set as Use first product image

---

### 1.0.9
*(2016-08-05)*

#### Fixed
* Fixed an issue with error if run setup:di:compile (affects from 1.0.8)

---

### 1.0.8
*(2016-08-04)*

#### Features
* Added ability to remove parent category path for category urls

---

### 1.0.7
*(2016-07-19)*

#### Fixed
* Fixed links for "Example of CSV file" for Redirects and Autolinks

---

### 1.0.6
*(2016-07-12)*

#### Documentation
* Fix My Downloadable Products link

---

### 1.0.5
*(2016-06-30)*

#### Fixed
* Fixed an issue with configuration Robots Meta Header in admin panel
* Fixed an issue with error if get parent category data

---

### 1.0.4
*(2016-06-24)*

#### Improvements
* Support of Magento 2.1.0

---

### 1.0.3
*(2016-05-17)*

#### Fixed
* Issue with wrong case of some filenames

### 1.0.2
*(2016-05-12)*

#### Improvements
* Ability to autolink product attributes too
* Backend menu
* Improved SEO Toolbar

#### Fixed
* Fixed an issue with saving configuration in magento 2.0.5
* Fixed an issue with saving new customer address

---

### 1.0.1
*(2016-04-01)*

* Added breadcrumbs depending on CMS Page Settings
* Added breadcrums on sitemap page

---

### 1.0.0
*(2016-02-29)*

* Initial release
