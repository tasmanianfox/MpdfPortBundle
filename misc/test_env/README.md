# Test environment

```bash
# Build a Docker image with reqyured deps
docker build -t local/php:7.4-composer  .

# Create a skeleton SF project
docker run --rm -it -v ~/.ssh:/root/.ssh -v $PWD/app:/app local/php:7.4-composer composer create-project symfony/website-skeleton test

# Install this bundle
docker run --rm -it -w /app/test -v ~/.ssh:/root/.ssh -v $PWD/app:/app local/php:7.4-composer composer require tfox/mpdf-port-bundle

# Start the dev server
docker run --rm -it -w /app/test -p 8000:8000 -v ~/.ssh:/root/.ssh -v $PWD/app:/app local/php:7.4-composer symfony server:start

```