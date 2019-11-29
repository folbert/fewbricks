# Fewbricks Development Workflow
Notes to Fewbricks Developers.

## Docs

## Testing as both plugin and custom install location
The Fewbricks repo is placed in a dedicated folder outside of the WordPress-installation and the dev server. We then use symlinks to that folder in order to be able to test running Fewbricks from different locations.

### As composer package in theme

#### Create symlink
vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/fewbricks/ /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/folbert/fewbricks"

#### Remove symlink
vagrant ssh -- -t "cd /var/www/web/app/themes/echocrate-sage-9_0_9/vendor/folbert/; unlink fewbricks"

### As plugin

#### Create symlink
vagrant ssh -- -t "ln -s /var/www/___fewbricksrepos___/fewbricks/ /var/www/web/app/plugins/fewbricks"

### Remove symlink
cat symlink-remove-plugin.sh | vagrant ssh
vagrant ssh -- -t "cd /var/www/web/app/plugins/; unlink fewbricks"
