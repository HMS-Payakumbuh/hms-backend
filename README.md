# hms_backend

## Cloning error troubleshoot
If Laravel couldn't run after cloning:
1. Reinstall composer (composer install)
2. If "[Exception] The bootstrap/cache directory must be present and writable." appears, add bootstrap/cache directory manually
3. You have to create the env file. Copy the .env.example and rename it to .env
4. You have generate the APP_KEY (php artisan key:generate)
