# Twitter Embed

Simple embed of Twitter widgets, without OAuth.

## Features

- Expose Twitter widgets to Drupal with Block and FieldFormatter.
- Covered widgets: Timeline, Button (@todo).

## Configuration

After enabling the module, you have the following options.

### Embed as a Block

- Add a **Twitter timeline** or a **Twitter button** block.
- Configuration is per block.

### Embed as a Field

- Add a **Twitter embed** field on any content entity and choose a 
_Timeline widget_ or a _Button widget_.
- Configure the display options.

## Documentation

The options are described on 
[Twitter Publish](https://publish.twitter.com/) 
and 
[Twitter Developer Documentation](https://dev.twitter.com/web/overview).

## Dependencies

None.

## Related modules

For the WYSIWYG, use [URL Embed](https://www.drupal.org/project/url_embed).

To get a Twitter timeline
- as a Block,
use [Twitter Block](https://www.drupal.org/project/twitter_block),
available for Drupal 7 and 8.
- as a Field,
use [Twitter Embed Field](https://www.drupal.org/project/twitter_embed_field),
currently as a dev release for Drupal 8.
This module aims to 
- unify a single configuration interface over Blocks and Fields
- provide several widgets implementation.

For more advanced use cases, review the 
[Twitter](https://www.drupal.org/project/twitter) module.
It is available for Drupal 7 and there is a Drupal 8 release on its way.

Have also a look at the 
[Social API](https://www.drupal.org/project/social_api)
module for Drupal 8.

## Roadmap

- Implement the Button widget
- Unit tests
