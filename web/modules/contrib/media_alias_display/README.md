# Media Alias Display

This module allows for direct viewing of a file with the URL alias.
Instead of viewing the media entity and all the fields users can
view a file (like a PDF). Instead of `sites/default/files/name-of-file`
it will display the URL alias.

This is useful if a media object is referenced in multiple locations
the media object can be updated with a new file and reflected in all
instances automatically.

For a full description of the module, visit the
[project page](https://www.drupal.org/project/media_alias_display).

Submit bug reports and feature suggestions, or track changes in the
[issue queue](https://www.drupal.org/project/issues/media_alias_display).


## Requirements

This module requires:

- Drupal Core Media

## Recommended modules

- [Pathauto](https://www.drupal.org/project/pathauto)
- Drupal Core Workflow

## Installation

Install as you would normally install a contributed Drupal module. For further
information, see
[Installing Drupal Modules](https://www.drupal.org/docs/extending-drupal/installing-drupal-modules).

## Tricks

- If you're viewing a file with an alias and need help finding the
  media object just append `?edit-media` to the URL, this will redirect
  you straight to the media edit page.
- If you want the media file to be downloaded, you may append `?download`
  or `?dl` to the URL.


## Configuration

1. Once the module is installed.

2. Go to `/admin/config/media/media-settings` and verify
  "Standalone media URL" is checked.


## Maintainers

- Stephen Mustgrave - [smustgrave](https://www.drupal.org/u/smustgrave)
