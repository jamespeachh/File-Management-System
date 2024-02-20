pwd
output=$(git pull)

if [[ "$output" == *"Already up to date."* ]]; then
    test="             ★★★      This repository is up to date.      ★★★                "
else
        test="             ★★★              Changes made!               ★★★                "
    echo output
fi

echo "                    ▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄"
echo "                    █ ♥ ##    ##  ######  ##       ♥ █"
echo "                    █ ♥  ##  ##  ##    ## ##       ♥ █"
echo "                    █ ♥   ####   ##       ##       ♥ █"
echo "                    █ ♥    ##    ##       ##       ♥ █"
echo "                    █ ♥    ##    ##    ## ##       ♥ █"
echo "                    █ ♥    ##     ######  ######## ♥ █"
echo "                    ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀"
echo "┌─────────────────────────────────────────────────────────────────────────────┐"
echo "             ★★★  Hello!  Thank you for pulling my work!  ★★★                "
echo "             ★★★           ☆Star me on Github!☆           ★★★                "
echo "             ★★★        Created by Matthew Lewis          ★★★                "
echo "             ★★★          Art by Gina Pivirotto           ★★★                "
echo "$test"
output=$(php artisan view:cache)
echo "             ★★★               View Cached!               ★★★                "
output=$(php artisan route:cache)
echo "             ★★★             Route is Cached!               ★★★                "
echo "└─────────────────────────────────────────────────────────────────────────────┘"
echo.
echo "Jobs scheduled:"
php artisan schedule:list

