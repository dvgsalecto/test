## 1.2.22
*(2023-05-16)*

#### Improvements
* Speed up rule validation

#### Fixed
* Reverting data during reindex


---

## 1.2.20
*(2023-04-27)*

#### Fixed
* Validation for multiselect attributes

---

## 1.2.18
*(2023-04-18)*

#### Fixed
* Store ID during reindex

---

## 1.2.17
*(2023-04-04)*

#### Fixed
* Error "Table mage_catalog_product_category_cl does not exist"

---

## 1.2.15
*(2023-04-03)*

#### Fixed
* Compatibility with PHP 8.2
* Compatibility with Magento 2.3.2
* Issue with backlog products

#### Improvements
* Speedup rule validation

---

## 1.2.14
*(2023-03-07)*

#### Fixed
* Error "Unique constraint violation found"
* Error "You cannot define a correlation name 'tbl_category_ids_'"

---

## 1.2.13
*(2023-03-02)*

#### Fixed
* Child product validation

---

## 1.2.12
*(2023-02-22)*

#### Fixed
* The issue when reindex remove all products from a category

---

## 1.2.8
*(2023-01-25)*

#### Fixed
* URL rewrites during dynamic category saving`
* Console command stops reindex process on the first error

---

## 1.2.7
*(2023-01-20)*

#### Fixed
* Removing rewrites

---

## 1.2.6
*(2023-01-06)*

#### Improvements
* Memory usage during reindex

---

## 1.2.5
*(2022-12-15)*

#### Fixed
* The error "Area code is not set"
* Removing rewrites during reindex

---

## 1.2.4
*(2022-12-05)*

#### Fixed
* The error "Integrity constraint violation: 1062 Duplicate entry for key 'CATALOG_CATEGORY_PRODUCT_CATEGORY_ID_PRODUCT_ID'"

---

## 1.2.3
*(2022-12-04)*

#### Fixed
* Website filter (exclude products that do not assign to website)

---

## 1.2.2
*(2022-11-27)*

#### Fixed
* Results for "Any" aggregator
* Preview does not take in the consideration the option "Exclude Products"

---

## 1.2.1
*(2022-11-08)*

#### Improvements
* Moved category reindex to Message queues

---

## 1.1.13
*(2022-11-03)*

#### Fixed
* Smart conditions

---

## 1.1.12
*(2022-10-25)*

#### Fixed
* Rule validation on reindex

---

## 1.1.11
*(2022-10-10)*

#### Fixed
* Error "str_replace(): Argument #3 ($subject) must be of type array|string, Magento\Framework\DB\Select given"

---

## 1.1.10
*(2022-10-07)*

#### Fixed
* The issue when reindex do not disable on save

---

## 1.1.9
*(2022-10-05)*

#### Fixed
* Issue when category does not reindex on save

---

## 1.1.8
*(2022-09-23)*

#### Improvements
* Speedup rule validation

---

## 1.1.7
*(2022-09-05)*

#### Improvements
* Added option "Run with Reindex Process"

---

## 1.1.6
*(2022-08-04)*

#### Fixed
* Condition "Has Active Special Price" does not include catalog rule discount

---

## 1.1.5
*(2022-07-28)*

#### Improvements
* Added option "Reindex after save"

---

## 1.1.4
*(2022-07-11)*

#### Improvements
* Added the ability to select products by pattern

#### Fixed
* Dynamic Category icon for categories with children
* Timeout issue when saving dynamic category

---

## 1.1.3
*(2022-06-20)*

#### Improvements
* remove db_schema_whitelist.json

---

## 1.1.2
*(2022-06-14)*

#### Fixed
* Compatibility php7.1

---

## 1.1.1
*(2022-05-25)*

#### Fixed
* Assign category when saving product through API

---

## 1.1.0
*(2022-05-23)*

#### Improvements
* Migrate to declarative schema

---

## 1.0.29
*(2022-03-21)*

#### Fixed
* Issue when cannot disable dynamic category

---

## 1.0.28
*(2022-02-10)*

#### Improvements
* Added parent/child conditions

---

## 1.0.26
*(2022-01-19)*

#### Improvements
* Added option "Exclude Products"

---

## 1.0.25
*(2021-12-24)*

#### Fixed
* Reindex category on save

---

## 1.0.24
*(2021-11-23)*

#### Improvements
* Indexation workflow

---

## 1.0.23
*(2021-11-19)*

#### Fixed
* Compatibility with m2.4.2

---

## 1.0.22
*(2021-11-09)*

#### Improvements
* Decrease reindex time

---

## 1.0.21
*(2021-11-03)*

#### Improvements
* Added smart attribute "Created"

#### Fixed
* Condition "Has Active Special Price is No"

---

## 1.0.20
*(2021-10-12)*

#### Improvements
* Added option "Reindex Mode"

---

## 1.0.19
*(2021-08-05)*

#### Fixed
* Assign product to category on product save using REST API

---

## 1.0.18
*(2021-06-29)*

#### Improvements
* Validation of the configurable products

---

## 1.0.17
*(2021-05-28)*

#### Improvements
* Added new condition "Is Salable"
* Added the ability to copy rules from other dynamic categories

---

## 1.0.16
*(2021-04-13)*

#### Fixed
* Call to a member function isStatic() on bool in vendor/magento/module-eav/Model/Entity/Collection/AbstractCollection.php (deleted attribute)

---

## 1.0.15
*(2021-04-12)*

#### Fixed
* JS error on the category tree (rules)

---

## 1.0.14
*(2021-01-11)*

#### Fixed
* Apply Sale rule on configurable products too

---

## 1.0.13
*(2021-01-07)*

#### Fixed
* Compatibility with PHP 7.1

---

## 1.0.12
*(2020-12-22)*

#### Fixed
* Display of attributes of type "textarea"
 
#### Improvements
* Speedup category reindex

---

## 1.0.11
*(2020-12-11)*

#### Fixed
* Rename condition "On Sale" to "Has Active Special Price"
 
#### Improvements
* Added command "mirasvit:dynamic-category:reindex"

---

## 1.0.10
*(2020-12-01)*

#### Improvements
* New rule condition by product rating
* New rule condition by number of reviews

---

## 1.0.9
*(2020-11-26)*

#### Fixed
* Rule condition for the attribute "Quantity"

---

## 1.0.8
*(2020-11-10)*

#### Fixed
* Compatibility with m2.3.2

---

## 1.0.7
*(2020-10-16)*

#### Fixed
* Minor fixes

---

## 1.0.6
*(2020-10-12)*

#### Fixed
* Issue with reindex

---

## 1.0.5
*(2020-10-12)*

#### Fixed
* Issue with reindex

---

## 1.0.4
*(2020-10-09)*

#### Improvements
* Added filter by Product Type

---

## 1.0.3
*(2020-10-08)*

#### Fixed
* On sale feature

---

## 1.0.2
*(2020-10-06)*

#### Improvements
* New conditions

---

## 1.0.1
*(2020-09-23)*

#### Fixed
* Minor fixes

---

## 1.0.0
*(2020-09-21)*

#### Features
* Initial release
