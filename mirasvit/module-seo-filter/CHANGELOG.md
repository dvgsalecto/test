## 1.2.9
*(2022-11-01)*

#### Fixed
* Fixed the issue with filtering products in multistore

---

## 1.2.8
*(2022-10-21)*

#### Improvements
* Clear link for all options per attribute (Mirasvit_LayeredNavigation)

---

## 1.2.7
*(2022-10-20)*

#### Improvements
* friendly URLs for Product Attribute Linking (Mirasvit_LayeredNavigation)

---

## 1.2.6
*(2022-09-29)*

#### Fixed
* Fixed the issue with SeoFilters not working when categories don't have rewrites

---

## 1.2.5
*(2022-06-20)*

#### Improvements
* remove db_schema_whitelist.json

---

## 1.2.4
*(2022-06-13)*

#### Fixed
* Fixed the issue with unable to save custom attribute aliases (multistore)
* Fixed the issue with brand pages (Mirasvit_Brand) when some options' aliases are equal to some brands' pages URL keys

---

## 1.2.3
*(2022-06-01)*

#### Fixed
* Aliases for additional Sale and New filters

---

## 1.2.2
*(2022-05-27)*

#### Fixed
* Fixed the issue with unable to save custom aliases (multistore)

---

## 1.2.1
*(2022-05-24)*

#### Fixed
* Performance issue (router)

---

## 1.2.0
*(2022-05-12)*

#### Improvements
* Switch to declarative DB schema

---

## 1.1.24
*(2022-04-11)*

#### Fixed
* Fixed issues with filters on Brand View pages (Mirasvit_Brand module)

---

## 1.1.23
*(2022-04-06)*

#### Fixed
* Fixed the issue with changing attribute alias after each attribute save

---

## 1.1.22
*(2022-02-23)*

#### Fixed
* Fixed the issue with 404 page when filters applied (same category paths but different ids for different stores in rewrites)

---

## 1.1.21
*(2022-02-18)*

#### Fixed
* Fixed the issue with slider filter and float values

---

## 1.1.20
*(2022-02-11)*

#### Fixed
* Fixed the issue with error 'Call to a member function getRequestPath() on null'
* Fixed the issue with error 'strpos(): Empty needle'

---

## 1.1.19
*(2022-02-02)*

#### Fixed
* Fixed the issue with 404 page on applied filters when filter alias include category path
* Fixed the issue with empty SEO filter rewrites for options in arabic

---

## 1.1.18
*(2022-01-18)*

#### Fixed
* Fixed the issue with 404 pages when filters applied on subcategory pages (some cases)

---

## 1.1.17
*(2022-01-04)*

#### Fixed
* Incorrect category base URL in filters issue (some cases)
* Fixed the issue with filter when attribute code is the same as category URL key (long URL)
* Fixed the issue with price slider (long URL)
* Fixed the issue with empty option aliases for attribute options with empty labels
* Matching the wrong category brings 404 error (5 weeks ago)

---

## 1.1.16
*(2021-11-22)*

#### Fixed
* Fixed the issue with multiselect and long URL format
* Fixed the issue with unable to remove selected filters from the filter clear block with Group options by attribute format "[x] Attribute: Option, Option" (Layered Navigation)

---

## 1.1.15
*(2021-11-11)*

#### Fixed
* Not allow saving custom option alias if identical alias already exists

---

## 1.1.14
*(2021-10-28)*

#### Fixed
* Fixed the issue with custom aliases with more then one '-' symbol
* Fixed the issue with slider filter

---

## 1.1.13
*(2021-10-15)*

#### Fixed
* Fixed the issue with custom aliases contains "-" symbol (partly duplicated aliases)

---

## 1.1.12
*(2021-08-31)*

#### Fixed
* Price slider filter redirects to 404

---

## 1.1.11
*(2021-08-19)*

#### Improvements
* Optional multiselect per attribute

---

## 1.1.10
*(2021-07-20)*

#### Fixed
* SEO filter prefix leads to 404
* Decimal filters (slider, from-to) with long seo rewrite issue

---

## 1.1.9
*(2021-07-06)*

#### Fixed
* Issue with price filter

---

## 1.1.8
*(2021-06-23)*

#### Fixed
* 404 on incorrect URLs (typos in category path or filters)
* Fixed the issue with Layered Navigation additional filters

---

## 1.1.7
*(2021-05-31)*

#### Features
* friendly URLs for Layered Navigation Grouped Options feature

#### Fixed
* Fixed the issue with custom alias with '-' symbol

---

## 1.1.6
*(2021-05-13)*

#### Fixed
* Match filters with "-"

---

## 1.1.5
*(2021-04-23)*

#### Fixed
* Issue with brand page urls
* Issue with filter by category

---

## 1.1.4
*(2021-04-21)*

#### Improve
* URL mode (multi-store)

---

## 1.1.3
*(2021-04-13)*

#### Fixed
* Filter by price. Notice: Array to string conversion
* Brand page getClearUrl issue

---

## 1.1.2
*(2021-04-06)*

#### Fixed
* Issue with loading url rewrites

---

## 1.1.1

*(2021-03-23)*

#### Fixed

* Issue with disabled category
* Remove pagination from friendly filter URL

---

## 1.1.0

*(2021-03-22)*

#### Improve

* New URL mode for SEO friendly filters (attr1/opt1-opt2/attr2/opt3-opt4.html)
* Removed compatibility for Magento 2.1, 2.2

---

## 1.0.29

*(2020-12-01)*

#### Fixed

* Issue with brand url

---

## 1.0.28

*(2020-11-19)*

#### Fixed

* unable to apply filter on brand page

---

## 1.0.27

*(2020-09-08)*

#### Fixed

* filter urls

---

## 1.0.26

*(2020-09-04)*

#### Features

* Support applying mode

--

## 1.0.25

*(2020-08-20)*

#### Refactor

* Improved module structure

---

## 1.0.24

*(2020-08-12)*

#### Features

* Seo-friendly urls for brand and all products pages

#### Fixed

* isMultiselectEnabled returns wrong value
* call to missing build_query function ([#21]())
* second click should clear filter

---

## 1.0.23

*(2020-07-29)*

#### Improvements

* Compatibility with Magento 2.4

---

## 1.0.22

*(2020-03-23)*

#### Fixed

* Issue with category filter url after apply other filters

---

## 1.0.21

*(2020-03-12)*

#### Fixed

* Use GET for category url (in the filters), if multi select is enabled

---

## 1.0.20

*(2020-03-10)*

#### Fixed

* Extra rewrite for weight filter (-)

---

## 1.0.19

*(2020-03-05)*

#### Improved

* Removing special symbols from friendly url: ™℠®©

---

## 1.0.18

*(2020-02-20)*

#### Features

* custom separator for SEO filters

#### Fixed

* Issue with multi filter
* unable to show and apply nested filter (price)

---

## 1.0.14

*(2019-10-28)*

#### Improved

* Code refactoring

#### Fixed

* error "include_once" statement detected

---

## 1.0.13

*(2019-08-09)*

#### Fixed

* Minor refactoring for pass eqp tests

---

## 1.0.12

*(2019-06-04)*

#### Fixed

* Empty url for Yes/No values
* Pagination issue with FishPig WordPress module
* Possible issue with request_path = .html in url_rewrite table

---

## 1.0.11

*(2018-11-29)*

#### Fixed

* Compatibility with Magento 2.3

---

## 1.0.10

*(2018-11-15)*

#### Fixed

* Issue with "The attribute model is not defined"

---

## 1.0.8

*(2018-10-24)*

#### Fixed

* Properly retrieve filter string
* Issue with rewrite attribute url, if our module is disabled

---

## 1.0.7

*(2018-08-17)*

#### Fixed

* Fixed incorrect urls if category with the same url exist

---

## 1.0.6

*(2018-07-17)*

#### Fixed

* Delete incorrect index

---

## 1.0.5

*(2018-07-16)*

#### Fixed

* Fixed an error "SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails..."

---

## 1.0.4

*(2018-05-29)*

#### Fixed

* Fixed an error: "Notice: Undefined property: Mirasvit\SeoFilter\Plugin\SwatchAttributeFilterMultiselectPlugin::$objectManager"

---

## 1.0.3

*(2018-05-23)*

#### Fixed

* Fix compilation error "Class Mirasvit\LayeredNavigation\Api\Service\SeoFilterUrlServiceInterface does not exist"

---

## 1.0.2

*(2018-05-23)*

#### Fixed

* Fixed incorrect urls for additional filters in Layered Navigation

---

## 1.0.1

*(2018-05-17)*

#### Fixed

* Issue with stock status

---

## 1.0.0

*(2018-04-03)*

* Initial release
