 #!/bin/bash
bundle exec jekyll build
rsync -avp --delete _site/ studentn@student.nu:domains/fewbricks2.folbert.com/
