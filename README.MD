### service containers:
```bash
docker-compose -f docker-compose.services.yml -p boilerplate-services up -d
```

### php and caddy containers:
```bash
docker-compose up -d --build
```

#### If no composer.json file is found in the root directory (first time setup), symfony skeleton will be installed, effectively overriding .gitignore and .env files, see docker/php/docker-entrypoint.sh
