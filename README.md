# Technovotum
A corporate website for a company specializing in the development and manufacturing of non-destructive testing (NDT) equipment. The project showcases the company's products, technologies, and services with a modern, responsive, and user-friendly interface.

## Production deployment

Production runs on Ubuntu 24.04 with Nginx, PHP 8.3, PostgreSQL, and PHP-FPM.
Pushes to `main` build and test the application in GitHub Actions, then publish
a release to the VDS at `194.87.103.1`.

### GitHub Actions setup

The VDS has a restricted `votum-deploy` account. Its dedicated public key is
already authorized on the server. On the workstation used to provision it, copy
the matching private key:

```bash
pbcopy < ~/.ssh/votum_github_deploy_2026
```

Add a repository Actions secret named `VOTUM_DEPLOY_KEY` in
`Settings > Secrets and variables > Actions` and paste the copied value. Never
commit or share the private key. The workflow pins the VDS SSH host key in
`deploy/known_hosts`.

After the workflow is present on `main` and the secret is configured, each push
to `main` runs the tests, builds the frontend, and deploys a new release.
`workflow_dispatch` can also be used to deploy the current `main` branch
manually from the Actions tab.

### First database initialization

After configuring the production `.env` and applying migrations, run
`php artisan db:seed --class=Database\\Seeders\\ProductionSeeder` once. This
creates the public product catalogue and contact information without creating
test users. Do not run the general `DatabaseSeeder` in production: its user
factory creates accounts with the default password `password`.

### Application notifications

Keep SMTP and Telegram credentials only in `/var/www/votum/shared/.env` on the
VDS. Configure `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`,
`MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_MANAGER_ADDRESSES`,
`TELEGRAM_BOT_TOKEN`, and `TELEGRAM_CHAT_IDS` there. After updating `.env`,
refresh cached configuration and restart the queue worker:

```bash
cd /var/www/votum/current
sudo php artisan config:cache
sudo systemctl restart votum-queue
```
