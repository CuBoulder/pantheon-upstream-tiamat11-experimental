# CU Boulder Drupal 10+ Custom Entities

All notable changes to this project will be documented in this file.

Repo : [GitHub Repository](https://github.com/CuBoulder/tiamat-profile)

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [20250312] - 2025-03-12

- ### D11 version bump
  D11 version bump

* * *

## [20250219] - 2025-02-19

## [20250212] - 2025-02-12

- ### Issue/1597

  Added schemas for the new paragraph type - article secondary content
  Updated article paragraph schemas to reflect new addtion
  Updated reusable paragraph types

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/1598>

* * *

## [20250115] - 2025-01-15

## [20241211] - 2024-12-11

## [20241204] - 2024-12-04

- ### Create image.style.focal_image_teaser_wide.yml

  Added new teaser wide style which is 2:1 instead of 3:2

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/1529>

* * *

## [20241122] - 2024-11-22

## [20241120] - 2024-11-20

- ### Update image.style.focal_image_wide.yml

  Updated focal wide image style to be 3:2 instead of 2:1

  Resolves #190 

* * *

- ### Additional height options for video hero unit

  Added top and bottom padding options to the design tab so that users can easily adjust the height of their videos.

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/1480>

* * *

- ### Adds Newsletter List Block and Newsletter Summary Field

  Creates the Newsletter List Block schema. Updates Newsletter schema to include a Summary field. 

  Includes:

  - `theme` => <https://github.com/CuBoulder/tiamat-theme/pull/1476>
  - `profile` => <https://github.com/CuBoulder/tiamat10-profile/pull/231>
  - `custom-entities`  => <https://github.com/CuBoulder/tiamat-custom-entities/pull/192>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1391>
  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1475>

* * *

## [20241113] - 2024-11-13

- ### Newsletter: Adds authoring information fields

  Adds Authored by and Authored On fields to Newsletter nodes

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1448>

* * *

## [20241030] - 2024-10-30

- ### Person Page: Adds On / Off Toggle field

  Adds an on / off toggle field to make the Articles by Person block on a Person page optional.

  Includes:

  - theme => <https://github.com/CuBoulder/tiamat-theme/pull/1437>
  - custom_entities => <https://github.com/CuBoulder/tiamat-custom-entities/pull/186>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1398>

* * *

## [20241023] - 2024-10-23

- ### Updates article date/time formatting default option label
  [change] Resolves CuBoulder/tiamat-custom-entities#183

* * *

## [20241017] - 2024-10-17

- ### Updates linter workflow

  Updates the linter workflow to use the new parent workflow in action-collection.

  CuBoulder/action-collection#7

  Sister PR in: All the things

* * *

- ### Article List Page: Expose Category/Tag Filter Toggle Setting

  Adds two new toggles to the Article List Page settings, which will expose filters on Categories and Tags for page visitors. This will allow visitors to the page to further filter Articles, which was previously a setting in D7.

  This will have migration implications. 

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/1387>
  - `tiamat-custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/180>

  Resolves <https://github.com/CuBoulder/tiamat-theme/pull/1387>

* * *

## [20241009] - 2024-10-09

- ### Create developer-sandbox-ci.yml
  new ci workflow

* * *

## [20241002] - 2024-10-02

## [20240925] - 2024-09-25

- ### Newsletter and Article Nodes: Field Adjustments
  Adjusts the following fields on the `Article` and `Newsletter` nodes:
  - Article: Removes 'Sticky at Top'. Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1319>
  - Newsletter: Adds 'Published' checkbox to allow Unpublished Newsletters. Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1310>

* * *

## [20240918] - 2024-09-18

- ### Create image.style.section_background.yml

  New image style for section backgrounds.
  Scales to 1920 width, but does not crop height at all.

  Sister PR: <https://github.com/CuBoulder/ucb_bootstrap_layouts/pull/57>

* * *

- ### Adds the Faculty Publications block

  [new] This update adds the Faculty Publications block. Faculty Publications blocks pull results from [CU Experts](https://experts.colorado.edu/). A variety of filters are available to bring near feature-parity with the version in D7. Notable changes in this version:

  - Adds an option to detect when the block has been added to a faculty member's person page, and automatically use that person's email address for the author filter.
  - Replaces the pager with a "More publications" button which loads the next batch of publications. Results are loaded fast and no longer require a reload of the page to view.
  - Removes "Any" for number of results to prevent poor client performance. 10, 25, 50, or 100 are available options.

  CuBoulder/tiamat-theme#1146

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/1297), [tiamat10-profile](https://github.com/CuBoulder/tiamat10-profile/pull/201)

* * *

- ### Article thumbnail style change
  This is a change to the article's thumbnail display so that cropping works properly across our various blocks.
  This is one of several incoming changes for issue #1249
  <https://github.com/CuBoulder/tiamat-theme/issues/1249>

* * *

## [20240911] - 2024-09-11

## [20240904] - 2024-09-04

- ### Content list update
  Helps close <https://github.com/CuBoulder/tiamat-theme/pull/1265>.
  Adds the necessary entity changes to allow collection item pages to be used in the content list.

* * *

- ### Updates `core.entity_form_display.node.ucb_person.default.yml`
  [bug] This update adds the missing author information to Person nodes to match our other content types. Resolves CuBoulder/tiamat-custom-entities#166

* * *

- ### New Image styles issue/1240

  Added three new image styles:
  Slider Ultrawide (1600x600)
  Slider Widescreen (1600:900)
  Slider 3:2 (1500:1000)

  Each style has the proper sizing dictated by Kevin
  The Slider block has been updated to have the proper names and sizes associated with them.
  The slide paragraph now has the default image style set to Original.
  The slider block template has had it's sizing logic moved to the paragraph slide template.
  The paragraph slide template uses parent logic to check what side the slider is going to be and applies the appropriate style to each image.

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/1252>

  Closes #1240 

* * *

## [20240821] - 2024-08-21

- ### Focal Point Update

  Added focal point to all cropping image styles.
  Colorbox styles have the focal point added but will still be uncropped due to templating limitations for now.

  Sister PR: <https://github.com/CuBoulder/tiamat10-profile/pull/192>

* * *

- ### 'Small Square' Image Style size adjustments

  ### Image Style: Small Square

  Adjusts the `Small Square` image style size to mirror the `Small` image style sizing, reducing the width from 500px to 375px. 

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1222>

* * *

- ### Content Entities for Mega Menu
  Closes <https://github.com/CuBoulder/tiamat-theme/issues/629>.
  Adds the necessary content entities for the mega menu.

* * *

## [20240814] - 2024-08-14

- ### Hides "End Date" fields from Content Sequence items

  These fields aren't currently used anywhere and do nothing. This update hides them.

  [remove] Resolves CuBoulder/tiamat-custom-entities#158

* * *

- ### New Image Styles: Colorbox Image Styles

  Adds config files for Colorbox style images

  ### New Image Styles

  Adds 4 new colorbox image styles: `Colorbox Small` , `Colorbox Small Square`, `Colorbox Small Thumbnail`, `Colorbox Square`. On click, these open up a modal with the full image and caption.

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/1205>
  - `tiamat-custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/160>
  - `tiamat-profile` => <https://github.com/CuBoulder/tiamat10-profile/pull/185>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1174>

* * *

- ### Slate Form: Allows a Block Description & Config Fixes

  ### Slate Form

  Enables a hidden Block Description so users can add in information to make their reuseable block more easily identifiable when going to `/admin/content`

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/1171>

  ### Dev Config Fix

  A previously commit broke some config in `filter.format` files for wysiwyg and full html, preventing devs from reinstalling via `lando install-site`.  This has been corrected.

  Related: <https://github.com/CuBoulder/tiamat-theme/pull/1182>

* * *

- ### Image Styles: Adds 'Original Image Size' style, adjusts small

  ### Image Styles

  - Adds new 'Original Image Size' image style to WYSIWYG and Full HTML
  - Adjusts the 'Small' Image Size to be 375px wide, mirroring D7. Previously this was set to 500px.

  Includes:

  - `tiamat-custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/155>
  - `tiamat-profile` => <https://github.com/CuBoulder/tiamat10-profile/pull/177>

  Resolves #154 

* * *

## [20240711] - 2024-07-11

- ### Image Gallery Masonry changes
  Helps close <https://github.com/CuBoulder/tiamat-theme/issues/1085>.
  Sister Pull Request with <https://github.com/CuBoulder/tiamat-theme/pull/1094>.
  Adds the necessary entities to enable the masonry option for image galleries.

* * *

## [20240604] - 2024-06-04

- ### Adds secondary and footer menus as allowed options for class notes list pages
  Resolves #149

* * *

- ### Updates form display of Content Sequence block
  This update includes two modifications to the Content Sequence block's form display:
  - [Bug] Restores missing block info description for Content Sequence blocks added using Block Layout.
  - [Remove] Removes stray description field previously used for the advanced Content Sequence. CuBoulder/tiamat-theme#934; Resolves CuBoulder/tiamat-custom-entities#142 

* * *

- ### Update field.storage.block_content.field_bs_background_style.yml

  Switched 'gray' to 'light gray' for site setting consistency.

  Resolves #146 

* * *

- ### Adds Alert setting to Text Block

  ### Text Block

  Adds a new "Alert" style to the Text Block, useful for alerts or notifications on your site.

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/991>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/145>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/880>

* * *

- ### Video Hero Block: Enables background color block style

  ### Video Hero Block

  Enables the background style on the Video Hero block. Previously this field was disabled on the block's display.

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/989>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/144>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/988>

* * *

## [20240513] - 2024-05-13

- ### Update core.entity_view_display.block_content.video_hero_unit.default.yml

  Update video hero unit's display options so that the title displays properly.

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/950>

* * *

- ### Removes horizontal and advanced content sequence blocks

  [a11y, Remove] The horizontal and advanced variants of content sequence aren't properly accessible to screenreader users. This update removes them. CuBoulder/tiamat-theme#934

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/940)

* * *

- ### Remove Plain text from Collection Item Page
  Closes <https://github.com/CuBoulder/tiamat-theme/issues/928>.
  Removes the plain text option from the collection item page preview.

* * *

- ### Update core.entity_view_display.node.basic_page.default.yml

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/898>
  Sister PR: <https://github.com/CuBoulder/ucb_bootstrap_layouts/pull/38>
  Sister PR: <https://github.com/CuBoulder/tiamat10-profile/pull/119>

  Updated basic page default layout to be a two column set up rather than single column

  The first column contains the title and body content 
  The second column contains the Main, Secondary, and Footer navigations

  This will allow for the new layout to display properly. 

* * *

- ### Issue/tiamat theme/804
  Sister pull request to resolve <https://github.com/CuBoulder/tiamat-theme/issues/804>.
  Adds necessary custom entities for the wallpaper image style.

* * *

- ### Issue/129

  Closes #129.
  Removes all relevant how-to files and pages.

  Sister requests:
  Tiamat-profile: <https://github.com/CuBoulder/tiamat10-profile/pull/117>
  Tiamat-theme: <https://github.com/CuBoulder/tiamat-theme/pull/890>

* * *

- ### Removal of article hero files
  Removes necessary files for article hero units.

* * *

- ### Newsletter: Adds optional URL field to Newsletter Section: Custom Content

  Adds the optional URL field for Newsletter Section's Custom Content.

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/882>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/131>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/872>

* * *

- ### Newsletter: Moves social links from Node to Newsletter term

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/867>

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/871>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/130>

* * *

- ### Issue Page: Section Titles made optional

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/852>

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/855>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/127>

* * *

- ### Makes the URL to the Events Calendar block widget builder a link
  Resolves CuBoulder/tiamat-custom-entities#124

* * *

- ### Updates Collection Grid block

  This update:

  - [Bug] Fixes a minor typo in the description of the "Display Summary" field. Resolves CuBoulder/tiamat-custom-entities#122
  - [Bug] Moves "Block Heading" into the correct place under the "Styles" tab in the form display.  Resolves CuBoulder/tiamat-custom-entities#121

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/851)

* * *

- ### Collection Item Page: Tab Labels change
  Resolves #123 

* * *

- ### Updates Social Media Icons block

  This update:

  - Removes "Use default links" option from Social Media Icons block.
  - Moves description field to the top when adding a Social Media Icons block in Block Layout.

  CuBoulder/tiamat-theme#795

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/827)

* * *

- ### Adjusts descriptions of various blocks

  Adjusts descriptive text of the following blocks:

  - Content Grid
  - Content Row
  - Events Calendar
  - Expandable Content
  - Form Block

  Previously these were described as 'paragraphs' rather than blocks.

  Resolves #116 

* * *

- ### Block Style Updates

  Update vidoe hero unit with block styles

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/808>

* * *

- ### Updates Articles

  This update:

  - Removes margin at the top of articles with header image.
  - Moves header image caption to immediately below header image.
  - Removes options for black text or hiding the overlay on the header image, setting the white text on dark overlay as the default.
  - Updates description of the article header image text field.

  CuBoulder/tiamat-theme#791
  CuBoulder/tiamat-theme#790

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/805)

* * *

- ### Disables 'Sticky at Top of Lists' and 'Promoted to Front Page'

  Disables the 'Sticky at Top of Lists' and 'Promoted to Front Page' fields from Form Display across all Content Types

  Resolves #114 

* * *

- ### Issue Archive Path Auto

  ## Issue Archive

  Needed a pathauto so the button on the "Latest Issues Block" so it works by default (only one expected per site so a similar pathauto to the "Class Notes" implemented)

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/773>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/113>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/765>

* * *

- ### Newsletter Changes

  - `Newsletter Text Blocks` previously had two fixed Text Blocks. This has been updated to a paragraph type with no limit and the previous fields were removed. 
  - Custom content in the `Newsletter Section Content` paragraph no longer includes a category field.
  - Adds a `Social Media Links` boolean field to the Newsletter.
  - Includes Email HTML views for new paragraph types

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/770>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/112>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/706>

* * *

- ### Added "None"

  Added `None` as an option to background style and made it a required field with `None` selected as default

  Fixed hero and event calendar classes showing in content 
  Fixed color layering and cascading
  Added `None` as an option for `Block Style` background color

  Related PR: <https://github.com/CuBoulder/tiamat-theme/pull/747>
  Related PR: <https://github.com/CuBoulder/ucb_bootstrap_layouts/pull/26>

* * *

- ### Removes requirement for Related Articles

  Related Articles block no longer required, which would cause errors on migrated sites with this block

  Resolves #102 

* * *

- ### Block styles

  Huge update to custom entities for block styles
  Every block got the updates for block styles as an extra tab
  Blocks without tabs were given tabs for separation of content and styles
  300+ file changes/creations

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/729>
  Sister PR: <https://github.com/CuBoulder/tiamat10-profile/pull/99>

* * *

- ### Issue Node: Removing the Secondary Image

  Fixes the following on Issue Content Types:

  - Removes the Secondary Image field from the form and page display. Also removes the hard-coded dark gray box with the title and body in it, as users can use CKEditor5 plugins such as Box, Button, Icons, and Media Library to achieve a variety of left-side layouts. 
  - Fixes bug with Teaser view of Categories displaying improperly
  - "Read More" capitzalized via CSS instead of hard-coded

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/730>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/107>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/704>

* * *

- ### Issue and Issue Archive use Media Library images

  Changes the Issue cover image field to use the Media Library images rather than the default. This change requires creating an additional consumer in `Focal Image Enable` to use un-cropped image styles from JSON:API as well as modifying the Issue Archive build process to use that un-cropped image.

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/707>
  - `tiamat-custom-entities` =>  <https://github.com/CuBoulder/tiamat-custom-entities/pull/105>
  - `ucb-focal-image-enable` => <https://github.com/CuBoulder/ucb_focal_image_enable/pull/8>

  Resolves [#104 ](https://github.com/CuBoulder/tiamat-custom-entities/issues/104)

* * *

- ### update text field for video reveal
  Closes <https://github.com/CuBoulder/tiamat-theme/issues/662>.
  Changes the text field for video reveal.

* * *

- ### Collection Item Page Preview Page
  Closes #101.
  Changes the preview field into a full html field.

* * *

- ### Content Row: Block Changes

  Adjusts the following on the `Content Row` blocks:

  - On the "Configure Block" modal, switched the order of the tabs so 'Row Content' is on the left and open by default and 'Row Design' is on the right and hidden
  - Added three teaser displays: `Large Teaser`, `Large Teaser Alternate`, and `Teaser`. Previously the teaser displays available were Teaser and Teaser Alternate.
  - The `Large Teaser` and `Large Teaser Alternate` displays use the focal image wide style images rather than square.
  - Adjusts style of the `Teaser` display to mirror other teaser-list style elements, such as the Article List. 
  - Adjusted style of the `Tile` style display to more closely mirror the D7 version, which achieved the tile effect with images and text alternating. 
  - Fixes bug where internal links, such as `/homepage` would cause a WSOD when added to Row Layout Content

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/687>
  - `custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/99>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/673>
  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/674>
  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/675>

* * *

- ### Content Sequence fixes.
  Helps close content sequence tickets.
  Sister pull request in <https://github.com/CuBoulder/tiamat-theme/pull/685>.

* * *

- ### Social Media Block entities
  Helps close <https://github.com/CuBoulder/tiamat-theme/issues/12>.
  Adds custom entities for social media block

* * *

- ### Class Note + Class Note List Changes

  - Adds images and adjusts the style of the `Class Notes List` page to mirror the Teaser-List display of other List-type nodes
  - Allows for `Class Note` Content types to have multiple images (custom-entities)

  Includes:

  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/657>
  - `tiamat-custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/95>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/206>

* * *

- ### Class Note Enhancements

  Adjusts permissions for Class Notes, adds optional image field. Resolves <https://github.com/CuBoulder/tiamat-theme/issues/622>

  Includes:

  - tiamat-theme => <https://github.com/CuBoulder/tiamat-theme/pull/648>
  - tiamat-profile => <https://github.com/CuBoulder/tiamat10-profile/pull/75>
  - custom-entities => <https://github.com/CuBoulder/tiamat-custom-entities/pull/94>

* * *

- ### Adds Collection Grid block and Collection Item content type
  Helps close <https://github.com/CuBoulder/tiamat-theme/issues/534>.
  Adds the entities for the collection grid and collection item pages.

* * *

- ### FAQ Content Type

  Adds the FAQ Content Type. Resolves <https://github.com/CuBoulder/tiamat-theme/issues/620>

  Includes:

  - tiamat-theme (issue/tiamat-theme/620) => <https://github.com/CuBoulder/tiamat-theme/pull/641>
  - custom-entities (issue/tiamat-theme/620) => <https://github.com/CuBoulder/tiamat-custom-entities/pull/92>
  - ucb-admin-menus (issue/tiamat-theme/620) => <https://github.com/CuBoulder/ucb_admin_menus/pull/20>

* * *

- ### Adds Class Note Page + Class Notes List Page

  Adds the `Class Note` Node and `Class Note List` node. A Class Note List Page lists your Class Notes and has built in filters to allow visitors to filter by year or sort by class year or date posted.

  Includes:
  `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/621>
  `tiamat-custom-entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/91>

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/588>

* * *

- ### Video hero unit separation setup

  Set up files for the separated hero units

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/606>

* * *

## [20231212] - 2023-12-12

- ### Issue/567

  Small change to make the title not required for content rows

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/582>

* * *

- ### People List Filter Labels as a Global Setting

  Changes the People List `Filter 1`, `Filter 2`, and `Filter 3` custom labels to a Global Setting in Site Configuration, rather than being set per-page. These labels will be set under Configuration => Cu Boulder Site Settings => Appearance and Layout.

  Resolves [#543 ](https://github.com/CuBoulder/tiamat-theme/issues/543)

  Includes:

  - `ucb_site_configuarion` => <https://github.com/CuBoulder/ucb_site_configuration/pull/35>
  - `tiamat-theme` => <https://github.com/CuBoulder/tiamat-theme/pull/560>
  - `ucb_custom_entities` => <https://github.com/CuBoulder/tiamat-custom-entities/pull/87>

* * *

- ### pathauto updates

  Path auto updates so that parent items are listed in the url alias and by extension the breadcrumbs

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/557>

* * *

- ### Add help text to Calendar Block
  Closes <https://github.com/CuBoulder/tiamat-theme/issues/539>.
  Adds new help text to Calendar Block to link to the widget builder

* * *

- ### updated entities for scheduler
  Used for <https://github.com/CuBoulder/tiamat-theme/issues/504>.
  Adds entities needed for the scheduler module.

* * *

- ### View Display fix on 'Focal Image Wide' + 'Focal Image Square' Image Styles on Sandbox Sites

  Changes view display configuration for 'Focal Image Wide' and 'Focal Image Square' to resolve the issue where unwanted fields would render with the styled image on sandbox sites.

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/521>

* * *

- ### Resolves configuration conflict for Image Styles causing issues on the Admin Interface

  Resizes the `Wide` Image Style after fixing config.

  Removes conflicting/duplicate `Image Style` configuration from `profile` that already existed in `custom-entities`, which caused the Admin interface to WSOD while trying to update the Image Styles via UI. 

  Includes:

  - `profile` => [`issue/tiamat-theme/524`](https://github.com/CuBoulder/tiamat10-profile/pull/40)
  - `custom-entities` => [`issue/tiamat-theme/524` ](https://github.com/CuBoulder/tiamat-custom-entities/pull/82)

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/524>

* * *

- ### Update core.entity_view_display.node.basic_page.default.yml

  Added setting so default section has "contained" set.

  Closes #77 

* * *

## [20230918] - 2023-09-18

- ### Hero Unit Size Priority

  Added "Size Priority" option to hero unit.

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/482>

* * *

- ### metatag necessary fields
  Closes <https://github.com/CuBoulder/tiamat-theme/issues/149>.
  Adds social sharing custom entity to enable metatags.

* * *

- ### Update core.entity_view_display.node.basic_page.default.yml

  The page title being moved to layout builder mode

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/473>

* * *

- ### New: Adds 'People List Block'

  ### People List Block

  A configurable and placeable block that displays a list of People, similar to the Person List Page with simpler options. Block contains options for how your block will display to users (Teaser, Grid, Name & Thumbnail, Name Only) and selectable filters by taxonomies on a Person (Department, Job Type, Filter 1, 2, 3) to curate a specific list of People ordered by Last Name.

  Includes:

  - `tiamat-custom-entities` => `issue/tiamat-theme/466`
  - `tiamat-theme` => `issue/tiamat-theme/466`

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/466>

* * *

- ### Removes image requirement from Content Row "Teaser" layouts

  This update enables the creation of Content Row blocks with image-less content and displays it correctly in the "Teasers" and "Teasers Alternate" layouts.

  CuBoulder/tiamat-theme#453

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/457)

* * *

- ### Removes "D9" from theme name and the theme, custom entities Composer package names

  CuBoulder/tiamat-theme#435

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/452), [tiamat-profile](https://github.com/CuBoulder/tiamat-profile/pull/52), [tiamat10-profile](https://github.com/CuBoulder/tiamat10-profile/pull/13), [tiamat-project-template](https://github.com/CuBoulder/tiamat-project-template/pull/28), [tiamat10-project-template](https://github.com/CuBoulder/tiamat10-project-template/pull/8), [ucb_site_configuration](https://github.com/CuBoulder/ucb_site_configuration/pull/26)

* * *

- ### Updated Byline
  Byline now has Author Person Page entity ID targetting

* * *

- ### Adds Description to Form Page Node
  Resolves #18 

* * *

- ### Change: Adds 'White' background to card-styled Text Block

  Adds a White background option to card-style Text Block for the case where sections have a different colored background

  Includes:

  - `tiamat-theme` => `issue/tiamat-theme/413`
  - `tiamat-custom-entities` => `issue/tiamat-theme/413`

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/413>

* * *

- ### Adds Additional Events link to Event Calendar block

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/381> - Adds a Link field to the Events Calendar Block to allow for links to additional events.

  Includes:
  [tiamat-theme](https://github.com/CuBoulder/tiamat-theme) => [issue/tiamat-theme/381 ](https://github.com/CuBoulder/tiamat-theme/pull/411)
  [tiamat-custom-entities](https://github.com/CuBoulder/tiamat-custom-entities) => [issue/tiamat-theme/381](https://github.com/CuBoulder/tiamat-custom-entities/pull/65)

* * *

- ### Changes labels of Hero Block 'Content' and 'Design' tabs
  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/399>

* * *

- ### Issue 320: Adding primary link to person pages
  Closes Issue 320 in tiamat-theme. Adds the necessary files for a primary link field in the person page.

* * *

- ### Update field.storage.block_content.field_grid_column_count.yml

  Added options for 5 and 6 columns in grid content

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/395>

* * *

- ### Changes to Article content type, Text and Content Grid blocks
  - Changes Article category and tag fields to tag style. Resolves CuBoulder/tiamat-theme#349
  - Removes Article Hero from Article. CuBoulder/tiamat-theme#352
  - Renames and reorders tabs in the Content Grid form display. Resolves CuBoulder/tiamat-theme#375
  - Renames tabs in the Text block form display. Resolves CuBoulder/tiamat-theme#386

* * *

- ### Update field.field.paragraph.row_layout_content.field_row_layout_cont…

  Made the text option not required

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/391>

* * *

- ### New Block Type: Article Slider

  Adds the Article Slider block. Much like the Article List page and other Article blocks, this will display a maximum of 6 articles in an interactive slider using user-provided inclusion and exclusion filters.

  Resolves [#319 ](https://github.com/CuBoulder/tiamat-theme/issues/319)

  Includes:
  `tiamat-theme` => `issue/tiamat-theme/319`
  `tiamat-custom-entities` => `issue/tiamat-theme/319`

* * *

- ### New Block Type: Article Feature

  Adds a new block type: Article Feature. The Article Feature block displays the latest Articles, with Category & Tag filters set by the user much like the Article List page. The first Article displays a large image and summary and the remaining articles displays titles and thumbnails. 

  Resolves [#318 ](https://github.com/CuBoulder/tiamat-theme/issues/318)

  Includes:

  - `tiamat-theme` => `issue/tiamat-theme/318`
  - `tiamat-custom-entities` => `issue/tiamat-theme/318`

* * *

- ### New Block Type: Article Grid

  Adds a new block type - Article Grid. Allows for Articles with thumbnails to be displayed in an Article List-style grid display.

  Includes:

  - `tiamat-theme` => `issue/tiamat-theme/317`
  - `tiamat-custom-entities` => `issue/tiamat-theme/317`

  Resolves [#317 ](https://github.com/CuBoulder/tiamat-theme/issues/317)

* * *

- ### Update field.field.block_content.events_calendar.field_calendar_code.yml

  Updated help text to contain link to the events calendar widget maker

  Sister PR: <https://github.com/CuBoulder/tiamat-theme/pull/367>

* * *

- ### Change: Related Articles set via Global Settings

  Resolves[ #246 ](https://github.com/CuBoulder/tiamat-theme/issues/246)-- Related Articles paragraph now uses the Global Settings (Admin => Configuration / CU Boulder site settings / Related Articles) for Taxonomy Exclusions

  Includes:

  - tiamat-theme `issue/246`
  - tiamat-custom-entities `issue/tiamat-theme/246`

* * *

- ### New Block Type: Article List Block

  Adds Article List Block - a block version of the Article List page with some added display style customizations.

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/316>

  Includes:
  \-tiamat-theme (<https://github.com/CuBoulder/tiamat-theme/pull/357>) => `issue/tiamat-theme-316` 
  \-custom-entities => `issue/tiamat-theme-316`

* * *

- ### Issue/tiamat theme/265
  Closes #265.

* * *

- ### Change: Newsletter Taxonomy Enhancements and Newsletter URL Path

  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/306>

  Adds the following fields to the Newsletter Taxonomy type to eventually be used in styling the Newsletter email render:

  - Design
  - Email Footer
  - Image
  - Newsletter Path\*

  Also changes pathauto for Newsletters to follow this pattern:
  _/newsletter/newsletter-path\*/title_

* * *

- ### chg: bumping for D10 compatibility

* * *

- ### Adds pronouns field to the Person page

  A pronouns text field has been added to the Person page, allowing a person's pronouns to be displayed below their name.

  CuBoulder/tiamat-theme#315

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/327)

* * *

- ### Update hero unit form display

  Added "Block Description" to the form display.
  This option is needed to add titles to the Block Layout list of options.

  Closes #45
  (Issue number changed in ticket repo transfer)

* * *

- ### Modifies person page form display
  - CuBoulder/tiamat-theme#308: adds descriptions for the _Job Type_ and _Phone_ fields
  - Resolves CuBoulder/tiamat-theme#310: renames "Other" tab to "Filters"
  - Resolves CuBoulder/tiamat-theme#311: renames "Description" tab and "Bio" field to "Body"

* * *

- ### Add new image styles to WYSIWYG and full html
  Closes #152 in Tiamat Theme.
  Adds the new image styles to the custom entities

* * *

## [20230323] - 2023-03-23

- ### Changes "Order by" for Person List page

  The option "Has Job Type, Last Name" has become "Job Type, Last Name". Rather than simply checking for the existence of the _job type_, sorting is performed alphabetically by a person's first _job type_.

  CuBoulder/tiamat-theme#280; Author @TeddyBearX 
  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/287)

* * *

- ### Removes the ability to turn off "Restrict choices to those selected" in People List

  The option is no longer present when creating or editing a People List page.

  CuBoulder/tiamat-theme#281

  Sister PR in: [tiamat-theme](https://github.com/CuBoulder/tiamat-theme/pull/285)

* * *

- ### Newsletter Email View Modes

  Adds `Email HTML` View Modes for the Newsletter Node, allowing for dual render styles to satisfy Newsletter requirements
  Partially resolves <https://github.com/CuBoulder/tiamat-theme/issues/222>

  Includes:
  `tiamat-theme` => issue/222
  `tiamat-custom-entities` => issue/222

* * *

- ### Removes the ability to add articles to menus
  Resolves CuBoulder/tiamat-theme#239

* * *

- ### Hidden Terms: Category and Tag Taxonomy Display Option

  Hidden Terms: Category and Tag schemas receive form option to toggle display for admin-only taxonomies.

  Resolves [#217 ](https://github.com/CuBoulder/tiamat-theme/issues/217)

  Change Includes:

  - `tiamat-theme` => `issue/217`
  - `tiamat-custom-entities` => `issue/217`

* * *

## [20230209] - 2023-02-09

- ### Adds Title Background Images to Articles
  Schemas for new Article fields for Header Image, Overlay, and Header Color
  Resolves <https://github.com/CuBoulder/tiamat-theme/issues/154>

* * *

- ### Publication Bundle

  Includes the following additions included in the Publication Bundle, resolves <https://github.com/CuBoulder/tiamat-theme/issues/168>.

  New Content Types:

  - Issue
  - Issue Archive

  Updated Content Types:

  - Article

  New Block Types (Basic Page):

  - Current Issue block
  - Latest Issue block
  - Category Cloud block
  - Tag Cloud block

  Notes for testing:
  Includes branches `issue/168` on `tiamat-theme`

* * *

- ### Adds `CHANGELOG.md` and workflow to `tiamat-custom-entities`
  Resolves #32 

* * *

[unreleased]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20250312...HEAD
[20250312]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20250219...20250312
[20250219]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20250212...20250219
[20250212]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20250115...20250212
[20250115]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241211...20250115
[20241211]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241204...20241211
[20241204]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241122...20241204
[20241122]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241120...20241122
[20241120]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241113...20241120
[20241113]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241030...20241113
[20241030]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241023...20241030
[20241023]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241017...20241023
[20241017]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241009...20241017
[20241009]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20241002...20241009
[20241002]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240925...20241002
[20240925]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240918...20240925
[20240918]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240911...20240918
[20240911]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240904...20240911
[20240904]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240821...20240904
[20240821]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240814...20240821
[20240814]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240711...20240814
[20240711]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240604...20240711
[20240604]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20240513...20240604
[20240513]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20231212...20240513
[20231212]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20230918...20231212
[20230918]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20230323...20230918
[20230323]: https://github.com/CuBoulder/tiamat-custom-entities/compare/20230209...20230323
[20230209]: https://github.com/CuBoulder/tiamat-custom-entities/compare/5194d160ddd0ecedec145abb78463eda2032d8a4...20230209
