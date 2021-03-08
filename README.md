# EGOI Video Evidence Platform

## Notes for Kubernetes Deployment

Make sure to provide at least the following environment variables:

```shell
APP_KEY # see below
APP_URL # e.g. https://video-evidence.egoi.ch

DB_HOST
DB_DATABASE
DB_USERNAME
DB_PASSWORD

AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_DEFAULT_REGION
AWS_BUCKET # use a separate bucket per installation
```

To generate a key, you can run `./artisan key:generate --show`.

To set up the database schema, run `./artisan migrate --force`.
