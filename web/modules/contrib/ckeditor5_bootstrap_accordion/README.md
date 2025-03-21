# CKEditor 5 Bootstrap Accordion

Insert and edit a [Bootstrap 5 accordion](https://getbootstrap.com/docs/5.3/components/accordion/)
in CKEditor 5, seamlessly within the editor. CKEditor 5 Bootstrap Accordion is
built using CKEditor 5's modern TypeScript plugin APIs and designed to look
like it belongs in the editor. For more information visit the
[Drupal.org project page](https://www.drupal.org/project/ckeditor5_bootstrap_accordion).

## Features

### Core features

- Add an accordion and insert or delete accordion items conveniently from the
CKEditor toolbars.
- Choose to open the first item or all items individually for each accordion.
- Accordions work right out of the box, no extra CSS or JavaScript is needed on
your site if it already uses Bootstrap 5's provided CSS and JavaScript.
- Accordion-in-accordion nesting is supported.

### Features for developers

- Build a custom CKEditor 5 plugin to add your own items to an accordion's
toolbar, simply by altering the `bootstrapAccordion.toolbarItems`
configuration.
- Customize accordion styling by overriding Bootstrap 5's CSS variables, and
style accordions to match your site's theme while keeping their functionality
intact.

### Accessibility

- `aria-controls` and `aria-expanded` attributes are added to all accordions
and supported by Bootstrap.
- Tab key navigation is possible while editing within an accordion widget.

## Post-Installation

After installation, enable the plugin by dragging the "Accordion" item onto the
toolbar of your text format (`/admin/config/content/formats`) and checking the
box next to the "Accordion enabler" filter. Accordions won't function properly
without the filter enabled.

## Additional Requirements

Your site should be using the Bootstrap 5 frontend library in its main theme.
The library isn't required in the admin theme or for editing the accordion.

This plugin was developed exclusively for modern Drupal 10+ sites and requires
CKEditor 5, meaning it's entirely incompatible with CKEditor 4 or other
editors. It's also incompatible with older versions of Bootstrap as it uses the
new accordion component added to Bootstrap 5.
