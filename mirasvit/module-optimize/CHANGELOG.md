# Change Log
## 1.5.1
*(2023-06-06)*

#### Fixed
* Webp images (HYVA)

---


## 1.5.0
*(2023-04-20)*

#### Improvements
* Migrate to declarative schema
* JS files collecting for JS bundles improved

---


## 1.4.0
*(2023-03-16)*

#### Fixed
* PHP8.1 compatibility

---


## 1.3.23
*(2023-03-06)*

#### Fixed
* Fixed the issue with Move JS/CSS features applied to AJAX responses (requests without proper headers)

---


## 1.3.22
*(2023-03-02)*

#### Improvements
* WebP images support for Swissup Breeze themes' product gallery widget

---


## 1.3.21
*(2023-01-20)*

#### Fixed
* Fixed the issue with errors during image optimization process (quote in filename)

---


## 1.3.20
*(2022-11-15)*

#### Fixed
* Fixed the issue with the error 'Undefined index: [data-role=swatch-options]'

---


## 1.3.19
*(2022-08-18)*

#### Improvements
* WebP for swatch images in product gallery

#### Fixed
* Console command return value

---


## 1.3.18
*(2022-06-09)*

#### Fixed
* Fixed the issue with memory limit error when LazyLoad enabled (since 1.3.17)

---


## 1.3.17
*(2022-06-08)*

#### Fixed
* Fixed a few issues related to errors detected by validator.w3.org

---


## 1.3.16
*(2022-05-27)*

#### Fixed
* Fixed the issue with webp images for video preview on product page 
* Fixed the issue with frontend page builder 

---


## 1.3.15
*(2022-01-21)*

#### Fixed
* PHP 8.1 compatibility

---


## 1.3.14
*(2021-12-02)*

#### Improvements
* Ability to disable JavaScript bundling on a page basis

---


## 1.3.13
*(2021-10-18)*

#### Fixed
* Issue with move JS to bottom and long scripts

---


## 1.3.12
*(2021-10-13)*

#### Fixed
* Possible gaps in the markup after enabling "Move JS to Page Bottom"

---


## 1.3.11
*(2021-09-07)*

#### Fixed
* Fixed the issue with webp images on product pages when tags included in fotorama config

#### Improvements
* Support for notorama product gallery widget

---


## 1.3.10
*(2021-07-27)*

#### Fixed
* Fixed the issue with "Move JS to Page Bottom" and long scripts (empty pages)

---


## 1.3.9
*(2021-07-15)*

#### Fixed
* fixed the issue with resized image can be smaller that original image with original image width in responsive images config

---


## 1.3.8
*(2021-07-06)*

#### Fixed
* Preload only configured CSS exceptions

---


## 1.3.7
*(2021-06-29)*

#### Improvements
* Proper work of 'Use Webp for Fotorama' feature with cache

---


## 1.3.6
*(2021-06-22)*

#### Fixed
* Fixed the issue with the error when webp image removed

---


## 1.3.5
*(2021-06-16)*

#### Improvements
* Support for Catalog media URL format 'Image optimization based on query parameters' (added in Magento 2.4.2)

---


## 1.3.4
*(2021-06-14)*
#### Fixed
* Remove from DB images that removed from the filesystem
* Update image status if webp image removed from the filesystem

---


## 1.3.3
*(2021-06-11)*

#### Fixed
* Fixed the issue with webp images when picture-source-img construction is present in the layout
* Correct type for preloaded CSS

#### Improvements
* Additional configs

---


## 1.3.2
*(2021-05-20)*

#### Fixed
* Fixed possible issue with not using webp images on product pages

---


## 1.3.1
*(2021-05-13)*

#### Fixed
* Fixed the issue with the error in logs (Undefined index: lighthouseResult)

---


## 1.3.0
*(2021-05-05)*

#### Fixed
* Fixed the conflict with 3rd-party fotorama-based gallery widgets (Notice: Undefined index: mage/gallery/gallery)

---


## 1.2.9
*(2021-04-30)*

#### Features
* Preload CSS exceptions

---


## 1.2.8
*(2021-04-29)*

#### Fixed
* Fixed the issue with product pages not being cached (affects from 1.2.1)

---


## 1.2.7
*(2021-04-26)*

#### Improvements
* Small improvement of optimizations regarding fonts

---


## 1.2.6
*(2021-04-21)*

#### Improvements
* Small optimization improvements

---


## 1.2.5
*(2021-04-08)*

#### Fixed
* Issue with error 'Uncaught Error: Call to a member function getWebpPath() on boolean'

---


## 1.2.4
*(2021-04-06)*

#### Fixed
* Fixed the issue with changing products color on category pages

---


## 1.2.3
*(2021-03-19)*

#### Fixed
* CSS move to bottom (prevent move for canonical tags)
* Issue with processing (loading) CSS for inline
* Issue with preload fonts (custom domain for static content)

---


## 1.2.2
*(2021-03-12)*

#### Fixed
* The error "Notice: Undefined index: HTTP_ACCEPT"

---


## 1.2.1
*(2021-03-12)*

#### Features
* Ability to use webp images in gallery widget on product pages

#### Improvements
* Ability to generate/delete resized images from CLI
* Responsive images generation improved

---


## 1.2.0
*(2021-03-11)*

####Fixed
* Fixed the issue with images in search autocomplete popup (WYOMIND)
* Fixed the issue with preload fonts
* Fixed the issue with applying optimizations in feeds
* Minor fixes

---


## 1.1.9
*(2021-02-04)*

#### Improvements
* Score check improved [#124]()

#### Fixed
* Fixed the issue with lazyload iframes
* Fixed the issue with inline CSS from resources feature

---


## 1.1.6
*(2021-01-15)*

#### Fixed
* Fixed the issue with error related to the responsive images functionality [#114]()

---


## 1.1.5
*(2021-01-14)*

#### Features
* Responsive Images (<a href="https://mirasvit.com/docs/module-optimize/current/configuration/settings#image-optimization">Check here</a>)

#### Improvements
* Ability to exclude webp image from lazyload by matching class of the original image [#110]()
* Minify JS exceptions [#111]()

---


## 1.1.4
*(2020-12-24)*

#### Improvements
* Webp quality depends on the Image Quality Level config [#106]()

#### Fixed
* Fixed the issue with inline styles from sources without protocol [#107]()

---


## 1.1.3
*(2020-12-16)*

#### Improvements
* GIF to WEBP conversion [#102]()
* Ability to add styles from CSS resourses directly to the HTML document [#104]()

#### Fixed
* Fixed the issue with empty exceptions for image lazyload [#103]()

---


## 1.1.2
*(2020-12-15)*

#### Improvements
* Ability to pre-connect third-party origins [#100]()

---


## 1.1.1
*(2020-12-11)*

#### Improvements
* Database performance improved [#98]()

---


## 1.1.0
*(2020-12-09)*

#### Fixed
* Fixed issue with errors during webp conversion due to braces in the name of the file [#96]()
* Fixed the issue with the admin panel not accessible after disabling JS optimizations [#95]()

---


## 1.0.25
*(2020-12-07)*

#### Improvements
* Database performance (indexes) [#93]()

---


## 1.0.24
*(2020-11-25)*

#### Improvements
* Ability to change some optimization configs in the scope of stores [#91]()
* Add debug.css only to debug pages [#90]()

---


## 1.0.23
*(2020-11-19)*

#### Improvements
* Image optimization strategy for webp conversion [#88]()

---


## 1.0.22
*(2020-11-18)*

#### Features
* Lazyload for offscreen iframes ([#86]())

---


## 1.0.21
*(2020-11-12)*

#### Improvements
* Additional CSS ([#83]())

#### Fixed
* Fixed the issue with image source in single quotes - webpages strategy ([#84]())

---


## 1.0.20
*(2020-11-09)*

#### Improvements
* Lazyload ([#80]())

---


## 1.0.19
*(2020-11-03)*

#### Improvements
* Improved image optimization strategy ([#78]())
* Debug mode for OptimizeImage ([#75]())

---


## 1.0.18
*(2020-10-19)*

#### Fixed
* Fixed issue with adding preload fonts to ajax response ([#72]())

---


## 1.0.17
*(2020-10-06)*

#### Improvements
* Minor code changes

---

## 1.0.16
*(2020-10-01)*

#### Fixed
* Compatibility with PHP 7.4

---


## 1.0.14
*(2020-09-16)*

#### Fixed
* Fixed error on pages with a few YouTube videos ([#64]())

---


## 1.0.13
*(2020-09-15)*

#### Improvements
* Validation for the ability to optimize images ([#62]())

---


## 1.0.12
*(2020-09-10)*

#### Improvement
* Conflicts validation

---


## 1.0.11
*(2020-09-07)*

#### Fixed
* Fixed issue with warnings during png images compression.

---


## 1.0.10
*(2020-09-04)*

#### Improvement
* Images compression ([#50]())

---


## 1.0.9
*(2020-09-01)*

#### Improvements
* Treshold for bundle/track requsts ([#46]())

#### Fixed
* Fixed issue with not all images displayed in some sliders ([#47]())

---


## 1.0.8
*(2020-08-27)*

#### Feature
* Lazy load for YouTube videos

#### Improvements
* Merge JS files option in the configurations of the extension

---


## 1.0.7
*(2020-07-29)*

#### Improvements
* Support of Magento 2.4

#### Fixed
* issue with CSS exceptions ([#37]())

---


## 1.0.6
*(2020-06-17)*

#### Fixed
* Issue with lazy load for images with a path in single quotes

---

## 1.0.5
*(2020-06-02)*

#### Fixed
* Issue with Magento 2.1.* compatibility

#### Improvements
* Disabling images conversion to webp when "Use WebP Images" is disabled


---


## 1.0.4
*(2020-04-23)*

#### Fixed
* Not all images visible with webp and lazyload
* Issue with webp conversion (Unsupported color conversion request)

---


## 1.0.3
*(2020-03-10)*

#### Improvements
* PageSpeed Optimizer in admin menu
* Move lazy-load exceptions to configuration

---


## 1.0.2
*(2020-03-05)*

#### Improvements
* Ability to exclude JS files from movement to the bottom of page
* Lazy-load (server transparent image placeholder in the original image size)
* Request validation (post, ajax, checkout etc)

---


## 1.0.1
*(2020-02-10)*

#### Improvements
* Additional exceptions (configurable in admin) for lazy-load

#### Fixed
* Issue with css defer
* Small config issues

---


## 1.0.0
*(2020-02-03)*

#### Improvements
* Additional exceptions for lazy-load

---


## 0.0.10
*(2020-01-24)*

#### Improvements
* Lazy load for webp images
* Ability to exclude specified URLs from move_js

#### Fixed
* Possible issues with measure google pagespeed score

---


## 0.0.9
*(2020-01-02)*

#### Improvements
* WebP images settings
* WebP Picture tag
* Added the command for validate required image optimization software

---


## 0.0.8
*(2019-12-26)*

#### Improvements
* WebP support

---


## 0.0.7
*(2019-12-25)*

#### Fixed
* Issue with saving the settings

---


## 0.0.6
*(2019-12-24)*

#### Improvements
* Lazy Images & Defer google fonts

---


## 0.0.5
*(2019-12-23)*

#### Fixed
* Replace 1px empty image with transparent

---


## 0.0.4
*(2019-12-23)*

#### Improvements
* Image optimization
* Add css option to all css files: font-display:swap
* Exception URL list for Move CSS option
* Deffer CSS

---


## 0.0.3
*(2019-12-18)*

#### Improvements
* Image optimization statistic
* JS minification
* PHPMD
* Debug option for lazy load images
* Optimize images queue

#### Fixed
* Issue with LazyLoad (Firefox)

---


## 0.0.2
*(2019-12-16)*

#### Improvements
* Image optimization module

---


## 0.0.1
*(2019-12-11)*

#### Improvements
* Initial release
